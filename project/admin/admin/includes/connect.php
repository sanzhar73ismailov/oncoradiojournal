<?php
include_once '../includes/config.php';

$link = mysql_connect(HOST, DB_USER, DB_PASS)  or die('Не удалось соединиться: ' . mysql_error());
mysql_set_charset("utf8");
//echo 'Соединение успешно установлено';
mysql_select_db(DB_NAME) or die('Не удалось выбрать базу данных');



  


?>