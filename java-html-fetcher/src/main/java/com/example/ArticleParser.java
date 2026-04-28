package com.example;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.SerializationFeature;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;

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
    private static final Pattern FILENAME_PATTERN = Pattern.compile("article_(\\d+)-(\\d+)-(\\d+)-(\\d+)\\.html");

    static class ArticleData {
        public int year;
        public int issueSeq;   // "выпускСквознойНомер" (том)
        public int issue;      // номер выпуска
        public String title;
        public String url;

        public ArticleData(int year, int issueSeq, int issue, String title, String url) {
            this.year = year;
            this.issueSeq = issueSeq;
            this.issue = issue;
            this.title = title;
            this.url = url;
        }

        // для Jackson
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
                String fileName = htmlFile.getFileName().toString();
                Matcher matcher = FILENAME_PATTERN.matcher(fileName);
                if (!matcher.matches()) {
                    System.err.println("Пропускаем файл с неверным именем: " + fileName);
                    continue;
                }

                int year = Integer.parseInt(matcher.group(1));
                int issueSeq = Integer.parseInt(matcher.group(2));
                int issue = Integer.parseInt(matcher.group(3));
                String articleId = matcher.group(4);

                String url = "https://elibrary.ru/item.asp?id=" + articleId;
                String title = extractTitleFromHtml(htmlFile.toFile());

                ArticleData data = new ArticleData(year, issueSeq, issue, title, url);
                articles.add(data);

                System.out.println("Обработан: " + fileName + " -> " + title);
            }
        }

        // Сохраняем в JSON
        ObjectMapper mapper = new ObjectMapper();
        mapper.enable(SerializationFeature.INDENT_OUTPUT);
        mapper.writeValue(new File(OUTPUT_JSON), articles);

        System.out.println("Сохранено " + articles.size() + " записей в " + OUTPUT_JSON);
    }

    private static String extractTitleFromHtml(File htmlFile) {
        try {
            Document doc = Jsoup.parse(htmlFile, "UTF-8");
            // Пробуем несколько возможных селекторов заголовка статьи на elibrary.ru
            String title = doc.select("h1#articleTitle, h1.title, meta[name=DC.Title]").attr("content");
            if (title != null && !title.isEmpty()) {
                return title.trim();
            }
            // Если мета-тег не помог – берём <title>
            title = doc.title();
            if (title != null && !title.isEmpty()) {
                return title.trim();
            }
            // Или текст в "ArticleTitle"
            title = doc.select(".articleTitle").text();
            if (title != null && !title.isEmpty()) {
                return title;
            }
        } catch (IOException e) {
            System.err.println("Ошибка при парсинге " + htmlFile + ": " + e.getMessage());
        }
        return "Unknown title";
    }
}