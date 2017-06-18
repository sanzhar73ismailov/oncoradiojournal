SELECT * FROM bibl_section where name_rus like '%ЭПИДЕМИОЛОГИЯ%';
SELECT * FROM bibl_section where name_rus like '%ПСИХО-СОЦИАЛЬНАЯ%';
SELECT * FROM bibl_section where name_rus like '%ОБЗОРЫ%';
SELECT * FROM bibl_section where name_rus like '%профилактика%';
SELECT * FROM bibl_section where name_rus like '%ДИАГНОСТИКА%';
SELECT * FROM bibl_section where name_rus like '%ЛЕЧЕНИЕ%';

INSERT INTO   `bibl_section`(`id`,`name_kaz`,`name_rus`,`name_eng`) VALUE (null, 'Подготовка кадров', 'Подготовка кадров', 'Подготовка кадров');

SELECT * FROM bibl_section where name_rus like '%подготов%';
SELECT * FROM bibl_section where name_rus like '%юбил%';

INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (22, 53, 1);
INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (22, 27, 1);
INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (22, 24, 1);
INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (22, 55, 1);
INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (22, 4, 1);
INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (22, 15, 1);

INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (23, 53, 1);
INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (23, 27, 1);
INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (23, 4, 1);
INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (23, 15, 1);
INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (23, 56, 1);
INSERT INTO bibl_issue_section(issue_id,section_id,order_field) VALUE (23, 54, 1);