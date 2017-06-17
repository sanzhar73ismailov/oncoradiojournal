<?php
include_once 'tabgeo_country_v4.php';
$file="stat.log";    // файл для записи истории посещения сайта
$col_zap=4999;    // ограничиваем количество строк log-файла


if(1==0){ //14.08.2016 - отключил
	if (strstr($_SERVER['HTTP_USER_AGENT'], 'YandexBot')) {$bot='YandexBot';} //Выявляем поисковых ботов
	elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) {$bot='Googlebot';}
	else { $bot=$_SERVER['HTTP_USER_AGENT']; }
	
	$ip = getRealIpAddr();
	$date = date("H:i:s d.m.Y");        // определяем дату и время события
	$home = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];    // определяем страницу сайта
	$lines = file($file);
	while(count($lines) > $col_zap) array_shift($lines);
	$lines[] = $date."|".$bot."|".$ip. " - ". tabgeo_country_v4($ip) . "|".$home."|\r\n";
	file_put_contents($file, $lines);
}
?>