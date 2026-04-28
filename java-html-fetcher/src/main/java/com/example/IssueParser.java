package com.example;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.SerializationFeature;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.File;
import java.io.IOException;
import java.nio.file.*;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class IssueParser {

    private static final String ARTICLES_DIR = "articles";
    private static final String OUTPUT_JSON = "articles.json";

    static class ArticleData {
        public int year;
        public String issueSeq;   // том (число в скобках)
        public String issue;      // номер выпуска
        public String titleIssue; // название выпуска (из <title>)
        public String titlePaper; // название статьи
        public String url;        // ссылка на страницу статьи
        public String pdfUrl;     // прямая ссылка на PDF (формируется из HTML)

        public ArticleData(int year, String issueSeq, String issue, String titleIssue,
                           String titlePaper, String url, String pdfUrl) {
            this.year = year;
            this.issueSeq = issueSeq;
            this.issue = issue;
            this.titleIssue = titleIssue;
            this.titlePaper = titlePaper;
            this.url = url;
            this.pdfUrl = pdfUrl;
        }

        public ArticleData() {}
    }

    public static void main(String[] args) throws IOException {
        Path articlesPath = Paths.get(ARTICLES_DIR);
        if (!Files.exists(articlesPath)) {
            System.err.println("Папка " + ARTICLES_DIR + " не найдена!");
            return;
        }

        List<ArticleData> allArticles = new ArrayList<>();

        try (DirectoryStream<Path> stream = Files.newDirectoryStream(articlesPath, "*.html")) {
            for (Path htmlFile : stream) {
                System.out.println("Обработка файла: " + htmlFile.getFileName());

                try {
                    Document doc = Jsoup.parse(htmlFile.toFile(), "UTF-8");

                    String title = doc.title();
                    if (!title.contains("содержание выпуска")) {
                        System.out.println("  Пропускаем (не страница выпуска): " + title);
                        continue;
                    }

                    String titleIssue = title.trim();

                    int year = extractYear(doc, title);
                    if (year == 0) {
                        System.err.println("  Не удалось определить год, пропускаем файл");
                        continue;
                    }

                    String[] issueAndSeq = extractIssueAndSeq(doc);
                    String issue = issueAndSeq[0];
                    String issueSeq = issueAndSeq[1];
                    if (issue.equals("unknown") || issueSeq.equals("unknown")) {
                        System.err.println("  Не удалось определить номер/том, пропускаем файл");
                        continue;
                    }

                    Elements articleRows = doc.select("tr[id^=arw]");
                    if (articleRows.isEmpty()) {
                        System.out.println("  Статей не найдено");
                        continue;
                    }

                    int articleCount = 0;
                    for (Element row : articleRows) {
                        // 1. Ссылка на страницу статьи (item.asp?id=...)
                        Element itemLink = row.selectFirst("a[href*=item.asp?id=]");
                        if (itemLink == null) continue;

                        String href = itemLink.attr("href");
                        String articleId = extractIdFromUrl(href);
                        if (articleId.isEmpty()) continue;

                        // 2. Название статьи
                        String titlePaper = itemLink.selectFirst("b, span, b span").text();
                        if (titlePaper.isEmpty()) titlePaper = itemLink.text();

                        String url = "https://elibrary.ru/item.asp?id=" + articleId;

                        // 3. Поиск номера файла для PDF из javascript:load_article(...)
                        String fileNumber = extractFileNumberFromRow(row);
                        String pdfUrl = null;
                        if (fileNumber != null) {
                            pdfUrl = String.format("https://elibrary.ru/download/elibrary_%s_%s.pdf", articleId, fileNumber);
                        }

                        ArticleData data = new ArticleData(year, issueSeq, issue, titleIssue,
                                titlePaper, url, pdfUrl);
                        allArticles.add(data);
                        articleCount++;
                    }
                    System.out.println("  Добавлено " + articleCount + " статей из выпуска " + issue + "(" + issueSeq + ") за " + year);

                } catch (Exception e) {
                    System.err.println("  Ошибка при разборе: " + e.getMessage());
                }
            }
        }

        ObjectMapper mapper = new ObjectMapper();
        mapper.enable(SerializationFeature.INDENT_OUTPUT);
        mapper.writeValue(new File(OUTPUT_JSON), allArticles);

        System.out.println("Сохранено " + allArticles.size() + " записей в " + OUTPUT_JSON);
    }

    // Извлекает второй числовой параметр из javascript:load_article(число)
    private static String extractFileNumberFromRow(Element row) {
        // Ищем ссылку с атрибутом href, начинающимся на javascript:load_article
        Element jsLink = row.selectFirst("a[href^=javascript:load_article]");
        if (jsLink == null) return null;
        String jsHref = jsLink.attr("href");
        Pattern p = Pattern.compile("load_article\\((\\d+)\\)");
        Matcher m = p.matcher(jsHref);
        if (m.find()) {
            return m.group(1);
        }
        return null;
    }

    // === Вспомогательные методы (без изменений) ===

    private static int extractYear(Document doc, String title) {
        Element yearElement = doc.selectFirst("td:containsOwn(Год:), div:containsOwn(Год:)");
        if (yearElement != null) {
            String text = yearElement.text();
            Pattern p = Pattern.compile("Год:\\s*(\\d{4})");
            Matcher m = p.matcher(text);
            if (m.find()) return Integer.parseInt(m.group(1));
        }
        Pattern pTitle = Pattern.compile("за\\s*(\\d{4})\\s*год");
        Matcher mTitle = pTitle.matcher(title);
        if (mTitle.find()) return Integer.parseInt(mTitle.group(1));
        String html = doc.html();
        Pattern pAny = Pattern.compile("Год[:\\s]+(\\d{4})");
        Matcher mAny = pAny.matcher(html);
        if (mAny.find()) return Integer.parseInt(mAny.group(1));
        return 0;
    }

    private static String[] extractIssueAndSeq(Document doc) {
        String[] result = new String[]{"unknown", "unknown"};
        Element elem = doc.selectFirst("td:containsOwn(Номер:), div:containsOwn(Номер:)");
        if (elem == null) return result;
        String text = elem.text();
        Pattern pattern = Pattern.compile("Номер:\\s*(\\S+)\\s*\\(([^)]+)\\)");
        Matcher matcher = pattern.matcher(text);
        if (matcher.find()) {
            result[0] = matcher.group(1).trim();
            result[1] = matcher.group(2).trim();
        }
        return result;
    }

    private static String extractIdFromUrl(String url) {
        Pattern p = Pattern.compile("id=(\\d+)");
        Matcher m = p.matcher(url);
        if (m.find()) return m.group(1);
        return "";
    }
}