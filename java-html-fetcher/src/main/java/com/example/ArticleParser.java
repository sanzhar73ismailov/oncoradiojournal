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

public class ArticleParser {

    private static final String ARTICLES_DIR = "articles";
    private static final String OUTPUT_JSON = "articles.json";

    static class ArticleData {
        public int year;
        public String issueSeq;   // том
        public String issue;      // номер
        public String titleIssue; // название выпуска (журнал + номер/том/год)
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

        List<ArticleData> articles = new ArrayList<>();

        try (DirectoryStream<Path> stream = Files.newDirectoryStream(articlesPath, "*.html")) {
            for (Path htmlFile : stream) {
                System.out.println("Обработка: " + htmlFile.getFileName());
                try {
                    Document doc = Jsoup.parse(htmlFile.toFile(), "UTF-8");

                    // 1. ID статьи (приоритет: meta -> ссылка item.asp -> canonical)
                    String articleId = extractArticleId(doc);
                    if (articleId.isEmpty()) {
                        System.err.println("  Не найден ID статьи, пропускаем");
                        continue;
                    }

                    // 2. Год, том, номер
                    int year = extractYear(doc);
                    String issueSeq = extractVolume(doc);
                    String issue = extractIssue(doc);

                    // 3. Название журнала (из meta или по умолчанию)
                    String journalName = extractJournalName(doc);

                    // 4. Формируем titleIssue
                    String titleIssue = formatTitleIssue(journalName, year, issueSeq, issue);

                    // 5. Название статьи
                    String titlePaper = extractTitlePaper(doc);

                    String url = "https://elibrary.ru/item.asp?id=" + articleId;
                    ArticleData data = new ArticleData(year, issueSeq, issue, titleIssue, titlePaper, url);
                    articles.add(data);

                    System.out.println("  -> ID=" + articleId + ", год=" + year + ", том=" + issueSeq + ", номер=" + issue);
                    System.out.println("     Статья: " + shorten(titlePaper, 70));
                    System.out.println("     Выпуск: " + shorten(titleIssue, 70));
                } catch (Exception e) {
                    System.err.println("  Ошибка: " + e.getMessage());
                }
            }
        }

        ObjectMapper mapper = new ObjectMapper();
        mapper.enable(SerializationFeature.INDENT_OUTPUT);
        mapper.writeValue(new File(OUTPUT_JSON), articles);

        System.out.println("Сохранено " + articles.size() + " записей в " + OUTPUT_JSON);
    }

    // --- ID статьи: сначала meta, потом ссылка item.asp?id=, потом canonical ---
    private static String extractArticleId(Document doc) {
        // 1) Мета-тег
        String id = doc.select("meta[name=citation_article_id]").attr("content");
        if (!id.isEmpty()) return id.trim();

        // 2) Ссылки вида item.asp?id=12345
        Elements links = doc.select("a[href]");
        Pattern p = Pattern.compile("item\\.asp\\?id=(\\d+)");
        for (Element link : links) {
            String href = link.attr("href");
            Matcher m = p.matcher(href);
            if (m.find()) {
                return m.group(1);
            }
        }

        // 3) Каноническая ссылка
        String canonical = doc.select("link[rel=canonical]").attr("href");
        Matcher m = Pattern.compile("id=(\\d+)").matcher(canonical);
        if (m.find()) return m.group(1);

        return "";
    }

    // --- Год ---
    private static int extractYear(Document doc) {
        String yearStr = doc.select("meta[name=citation_year]").attr("content");
        if (!yearStr.isEmpty()) {
            try {
                return Integer.parseInt(yearStr.trim());
            } catch (NumberFormatException ignored) {}
        }
        // Поиск по тексту: "Год: 2024" и т.п.
        String text = doc.text();
        Pattern p = Pattern.compile("(?:Год|Year)[:\\s]*(\\d{4})");
        Matcher m = p.matcher(text);
        if (m.find()) return Integer.parseInt(m.group(1));
        return 0;
    }

    // --- Том (может содержать дефис, например "33-34") ---
    private static String extractVolume(Document doc) {
        String vol = doc.select("meta[name=citation_volume]").attr("content");
        if (!vol.isEmpty()) return vol.trim();
        // Поиск по тексту: "Том 75", "Volume 75"
        String text = doc.text();
        Pattern p = Pattern.compile("(?:Том|Volume)[:\\s]*([\\d-]+)");
        Matcher m = p.matcher(text);
        if (m.find()) return m.group(1);
        return "unknown";
    }

    // --- Номер (может быть "3-4", "3S" и т.д.) ---
    private static String extractIssue(Document doc) {
        String issue = doc.select("meta[name=citation_issue]").attr("content");
        if (!issue.isEmpty()) return issue.trim();
        String text = doc.text();
        Pattern p = Pattern.compile("(?:Номер|Issue)[:\\s]*([\\dS-]+)", Pattern.CASE_INSENSITIVE);
        Matcher m = p.matcher(text);
        if (m.find()) return m.group(1);
        return "unknown";
    }

    // --- Название журнала ---
    private static String extractJournalName(Document doc) {
        String journal = doc.select("meta[name=citation_journal_title]").attr("content");
        if (!journal.isEmpty()) return journal.trim();
        journal = doc.select("meta[name=dc.source]").attr("content");
        if (!journal.isEmpty()) return journal.trim();
        // Поиск в тексте по типичному шаблону
        Elements titles = doc.select(".journal_title, .jtitle, .bibitem:contains(Журнал)");
        for (Element el : titles) {
            String txt = el.text();
            if (txt.contains("Онкология") || txt.contains("радиология")) {
                return txt.replaceAll("Журнал\\s*", "").trim();
            }
        }
        return "Онкология и радиология Казахстана";
    }

    // --- Формирование titleIssue по шаблону: "Журнал / содержание выпуска № номер(том) за год" ---
    private static String formatTitleIssue(String journal, int year, String issueSeq, String issue) {
        if (year == 0 && issueSeq.equals("unknown") && issue.equals("unknown")) {
            return journal;
        }
        if (year > 0 && !issueSeq.equals("unknown") && !issue.equals("unknown")) {
            return String.format("%s / содержание выпуска № %s(%s) за %d год", journal, issue, issueSeq, year);
        } else if (year > 0 && !issue.equals("unknown")) {
            return String.format("%s / содержание выпуска № %s за %d год", journal, issue, year);
        } else if (year > 0) {
            return String.format("%s / содержание выпуска за %d год", journal, year);
        } else if (!issue.equals("unknown")) {
            return String.format("%s / выпуск № %s", journal, issue);
        }
        return journal;
    }

    // --- Заголовок статьи ---
    private static String extractTitlePaper(Document doc) {
        // Ищем в h1 или сильных селекторах
        String title = doc.select("h1#articleTitle, h1.title, .articleTitle").text();
        if (!title.isEmpty()) return title;
        title = doc.select("meta[name=DC.Title]").attr("content");
        if (!title.isEmpty()) return title;
        title = doc.title();
        if (!title.isEmpty()) return title;
        // Поиск в ссылке с item.asp?id
        Elements links = doc.select("a[href*=item.asp?id=] b, a[href*=item.asp?id=] span");
        for (Element link : links) {
            String t = link.text();
            if (t.length() > 10) return t;
        }
        return "Без названия";
    }

    private static String shorten(String s, int max) {
        if (s == null) return "";
        return s.length() > max ? s.substring(0, max) + "..." : s;
    }
}