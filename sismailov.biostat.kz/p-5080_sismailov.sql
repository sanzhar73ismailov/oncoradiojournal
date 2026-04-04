CREATE TABLE page_visits (
                             id BIGINT AUTO_INCREMENT PRIMARY KEY,
                             visit_time DATETIME DEFAULT CURRENT_TIMESTAMP,

                             ip VARCHAR(45),

                             country VARCHAR(100),
                             city VARCHAR(100),
                             isp VARCHAR(255),

                             is_bot TINYINT(1),
                             bot_name VARCHAR(255),

                             device_type VARCHAR(50),
                             os VARCHAR(50),

                             load_time_ms INT,

                             user_agent TEXT,
                             accept_language VARCHAR(255),
                             page_lang VARCHAR(10),

                             referer TEXT,
                             request_uri TEXT,

                             headers JSON,
                             session_id VARCHAR(255)
);