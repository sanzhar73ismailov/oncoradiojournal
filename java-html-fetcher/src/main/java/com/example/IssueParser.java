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
        public String url;

        public ArticleData(int year, String issueSeq, String issue, String titleIssue, String titlePaper, String url) {
            this.year = year;
            this.issueSeq = issueSeq;
            this.issue = issue;
            this.titleIssue = titleIssue;
            this.titlePaper = titlePaper;
            this.url = url;
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

                    // Проверяем, что это страница выпуска
                    String title = doc.title();
                    if (!title.contains("содержание выпуска")) {
                        System.out.println("  Пропускаем (не страница выпуска): " + title);
                        continue;
                    }

                    // 1. Извлекаем название выпуска (titleIssue)
                    String titleIssue = title.trim();

                    // 2. Извлекаем год
                    int year = extractYear(doc, title);
                    if (year == 0) {
                        System.err.println("  Не удалось определить год, пропускаем файл");
                        continue;
                    }

                    // 3. Извлекаем номер и том (issue и issueSeq)
                    String[] issueAndSeq = extractIssueAndSeq(doc);
                    String issue = issueAndSeq[0];
                    String issueSeq = issueAndSeq[1];
                    if (issue.equals("unknown") || issueSeq.equals("unknown")) {
                        System.err.println("  Не удалось определить номер/том, пропускаем файл");
                        continue;
                    }

                    // 4. Парсим строки статей
                    Elements articleRows = doc.select("tr[id^=arw]");
                    if (articleRows.isEmpty()) {
                        System.out.println("  Статей не найдено");
                        continue;
                    }

                    int articleCount = 0;
                    for (Element row : articleRows) {
                        Element link = row.selectFirst("a[href*=item.asp?id=]");
                        if (link == null) continue;

                        String href = link.attr("href");
                        String articleId = extractIdFromUrl(href);
                        if (articleId.isEmpty()) continue;

                        String titlePaper = link.selectFirst("b, span, b span").text();
                        if (titlePaper.isEmpty()) titlePaper = link.text();

                        String url = "https://elibrary.ru/item.asp?id=" + articleId;

                        ArticleData data = new ArticleData(year, issueSeq, issue, titleIssue, titlePaper, url);
                        allArticles.add(data);
                        articleCount++;
                    }
                    System.out.println("  Добавлено " + articleCount + " статей из выпуска " + issue + "(" + issueSeq + ") за " + year);

                } catch (Exception e) {
                    System.err.println("  Ошибка при разборе: " + e.getMessage());
                }
            }
        }

        // Сохраняем JSON
        ObjectMapper mapper = new ObjectMapper();
        mapper.enable(SerializationFeature.INDENT_OUTPUT);
        mapper.writeValue(new File(OUTPUT_JSON), allArticles);

        System.out.println("Сохранено " + allArticles.size() + " записей в " + OUTPUT_JSON);
    }

    // === Извлечение года из документа или заголовка ===
    private static int extractYear(Document doc, String title) {
        // Сначала пробуем из явного блока на странице
        Element yearElement = doc.selectFirst("td:containsOwn(Год:), div:containsOwn(Год:)");
        if (yearElement != null) {
            String text = yearElement.text();
            Pattern p = Pattern.compile("Год:\\s*(\\d{4})");
            Matcher m = p.matcher(text);
            if (m.find()) {
                return Integer.parseInt(m.group(1));
            }
        }
        // Ищем в заголовке "за 2017 год"
        Pattern pTitle = Pattern.compile("за\\s*(\\d{4})\\s*год");
        Matcher mTitle = pTitle.matcher(title);
        if (mTitle.find()) {
            return Integer.parseInt(mTitle.group(1));
        }
        // Ищем везде
        String html = doc.html();
        Pattern pAny = Pattern.compile("Год[:\\s]+(\\d{4})");
        Matcher mAny = pAny.matcher(html);
        if (mAny.find()) {
            return Integer.parseInt(mAny.group(1));
        }
        return 0;
    }

    // === Извлечение номера (issue) и тома (issueSeq) из строки "Номер: 2 (44)" ===
    private static String[] extractIssueAndSeq(Document doc) {
        String[] result = new String[]{"unknown", "unknown"};
        Element elem = doc.selectFirst("td:containsOwn(Номер:), div:containsOwn(Номер:)");
        if (elem == null) return result;
        String text = elem.text();
        // Ищем паттерн: Номер: 2 (44)  или  Номер: 3-4 (33-34)
        Pattern pattern = Pattern.compile("Номер:\\s*(\\S+)\\s*\\(([^)]+)\\)");
        Matcher matcher = pattern.matcher(text);
        if (matcher.find()) {
            result[0] = matcher.group(1).trim();   // issue
            result[1] = matcher.group(2).trim();   // issueSeq (том)
        }
        return result;
    }

    // === Извлечение ID из ссылки item.asp?id=xxxxx ===
    private static String extractIdFromUrl(String url) {
        Pattern p = Pattern.compile("id=(\\d+)");
        Matcher m = p.matcher(url);
        if (m.find()) {
            return m.group(1);
        }
        return "";
    }
}