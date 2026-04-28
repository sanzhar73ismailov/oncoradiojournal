package com.example;

import org.jsoup.Connection;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;

public class FetchHtml {

    private static final String BASE_URL = "https://elibrary.ru/item.asp?id=";
    private static final String USER_AGENT = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36";
    private static final String REFERER = "https://elibrary.ru/";

    public static void main(String[] args) throws IOException {
        // ID статьи можно передать аргументом командной строки
        String articleId = args.length > 0 ? args[0] : "32561873";
        String url = BASE_URL + articleId;

        System.out.println("Загружаем: " + url);

        try {
            // Выполняем GET-запрос с заголовками браузера
            Connection connection = Jsoup.connect(url)
                    .userAgent(USER_AGENT)
                    .referrer(REFERER)
                    .timeout(30000) // 30 секунд таймаут
                    .ignoreHttpErrors(false); // не игнорировать ошибки HTTP

            Document doc = connection.get();
            String html = doc.html();

            // Сохраняем в файл
            String fileName = "articles/article_" + articleId + ".html";
            Files.writeString(Paths.get(fileName), html);
            System.out.println("HTML сохранён в файл: " + fileName);

            // Выводим первые 500 символов для предпросмотра
            System.out.println("\nПервые 500 символов:\n" + html.substring(0, Math.min(500, html.length())));

        } catch (IOException e) {
            System.err.println("Ошибка при загрузке страницы: " + e.getMessage());
            e.printStackTrace();
        }
    }
}