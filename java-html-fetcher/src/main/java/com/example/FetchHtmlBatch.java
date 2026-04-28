package com.example;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;

public class FetchHtmlBatch {

    private static final String USER_AGENT = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36";
    private static final String REFERER = "https://elibrary.ru/";
    private static final String ARTICLES_DIR = "articles";
    private static final int SLEEP_MS = 5000; // 2 секунды между запросами

    // Список записей: каждая строка "год,том,номер,id"
    private static final String[] ENTRIES = {
            "2025,75,1,82506481",
            "2025,76,2,89028114",
            "2025,77,3,89031765",
            "2025,78,4,89028879",
            "2024,71,1,71961546",
            "2024,72,2,70614376",
            "2024,73,3,82386154",
            "2024,74,4,82374511",
            "2023,67,1,54153609",
            "2023,68,2,54167624",
            "2023,69,3,55818775",
            "2023,70,4,65546459",
            "2022,63,1,48233100",
            "2022,64,2,49162537",
            "2022,65,3,49622847",
            "2022,66,4,53698485",
            "2021,59,1,46145903",
            "2021,60,2,46416959",
            "2021,61,3,46614650",
            "2021,62,4,47557780",
            "2020,55,1,42652898",
            "2020,56,2,43936784",
            "2020,57,3,44143099",
            "2020,58,4,45279244",
            "2019,51,1,41664039",
            "2019,52,2,41663694",
            "2019,53,3,41663762",
            "2019,54,4,41665054",
            "2018,47,1,36510797",
            "2018,48,2,36482273",
            "2018,49,3,36482295",
            "2018,50,4,36952387",
            "2017,44,2,34836895",
            "2017,45,3,34836109",
            "2017,46,4,36470470",
            "2017,45,3S,36582680",
            "2016,39,1,34836668",
            "2016,40,2,34836669",
            "2016,41,3,34837956",
            "2016,42,4,34836670",
            "2015,35,1,34836894",
            "2015,36,2,34835758",
            "2015,37,3,34835966",
            "2015,38,4,34836667",
            "2014,31,1,34836381",
            "2014,32,2,34836382",
            "2014,33-34,3-4,34835757",
            "2013,27,1,34835346",
            "2013,28,2,34835347",
            "2013,29,3,34835755",
            "2013,30,4,34835756",
            "2012,23,1,34836869",
            "2012,24-25,2-3,34836893",
            "2012,26,4,34835345",
            "2011,18,1,34835754",
            "2011,19,2,34836108",
            "2011,20,3,34834951",
            "2011,21,4,34835218",
            "2010,14,1,34835217",
            "2010,15,2,34835344",
            "2010,16-17,3-4,34835357"
    };

    public static void main(String[] args) {
        createArticlesDir();

        for (String entry : ENTRIES) {
            String[] parts = entry.split(",");
            if (parts.length != 4) {
                System.err.println("Некорректная строка: " + entry);
                continue;
            }

            String year = parts[0].trim();
            String volume = parts[1].trim();   // "выпускСквознойНомер"
            String issue = parts[2].trim();    // номер выпуска
            String id = parts[3].trim();

            String fileName = String.format("article_%s-%s-%s-%s.html", year, volume, issue, id);
            String url = "https://elibrary.ru/item.asp?id=" + id;

            System.out.println("Обработка: " + fileName);
            System.out.println("URL: " + url);

            try {
                Document doc = Jsoup.connect(url)
                        .userAgent(USER_AGENT)
                        .referrer(REFERER)
                        .timeout(30000)
                        .ignoreHttpErrors(false)
                        .get();

                String html = doc.html();
                Path filePath = Paths.get(ARTICLES_DIR, fileName);
                Files.writeString(filePath, html);
                System.out.println("Сохранено: " + filePath.toAbsolutePath());

            } catch (IOException e) {
                System.err.println("Ошибка при загрузке ID " + id + ": " + e.getMessage());
                // Продолжаем со следующим ID
            }

            // Пауза между запросами
            try {
                System.out.println("Ожидание " + SLEEP_MS + " мс...\n");
                Thread.sleep(SLEEP_MS);
            } catch (InterruptedException e) {
                Thread.currentThread().interrupt();
                System.err.println("Прерывание сна, остановка цикла.");
                break;
            }
        }

        System.out.println("Загрузка завершена.");
    }

    private static void createArticlesDir() {
        Path dir = Paths.get(ARTICLES_DIR);
        if (!Files.exists(dir)) {
            try {
                Files.createDirectories(dir);
            } catch (IOException e) {
                System.err.println("Не удалось создать директорию 'articles': " + e.getMessage());
            }
        }
    }
}