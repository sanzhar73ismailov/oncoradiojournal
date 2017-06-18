<?php
session_start ();
if (isset ( $_REQUEST ['statistics'] )) {
	
	if (isset ( $_REQUEST ['p'] ) and $_REQUEST ['p'] == 'qweasd111!') {
		if ($_REQUEST ['statistics'] == 'off') {
			$_SESSION ['statistics'] = 0;
		} else {
			unset ( $_SESSION ['statistics'] );
		}
	}
}
$statistics_on = 1;
if (isset ( $_SESSION ['statistics'] ) and $_SESSION ['statistics'] == 0) {
	$statistics_on = 0;
}
// session_start ();
define ( "SUM_PER_PAGE", 500 );
// print_r($_SERVER['SCRIPT_NAME']);

// SERVER_ADDR
// print_r($_SERVER);
// print_r($_SERVER['SERVER_ADDR']);
function getRealIpAddr() {
	if (! empty ( $_SERVER ['HTTP_CLIENT_IP'] )) 	// Определяем IP
	{
		$ip = $_SERVER ['HTTP_CLIENT_IP'];
	} elseif (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
		$ip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER ['REMOTE_ADDR'];
	}
	return $ip;
}
function getUserAgent() {
	$bot = "";
	// Выявляем поисковых ботов
	$arrayBots = array(
    "YandexBot" => "YandexBot",
    "Googlebot" => "Googlebot",
    "Yahoo! Slurp" => "Yahoobot",
    "Baiduspider" => "Baiduspiderbot",
    "www.opensiteexplorer.org" => "Opensiteexplorerbot",
    "www.bing.com" => "Bingbot",
    "http://ltx71.com" => "ltx71bot",
    "Java/" => "Javabot",
    "http://megaindex.com/crawler" => "MegaIndex_rubot",
	"http://www.exabot.com/go/robot" => "Exabot",
	"YandexMobileBot" => "YandexMobileBot",
	"http://www.linkdex.com/bots/"=>"linkdexbot",
	"http://go.mail.ru/help/robots" => "Mail.RUbot",
    );
	$bot = $_SERVER ['HTTP_USER_AGENT'];
	foreach ($arrayBots as $key => $value){
		if (strstr ( $_SERVER ['HTTP_USER_AGENT'], $key )) {
			$bot = $value;
			break;
		}
	}
	return $bot;
}
function getLanguageFromBrowser() {
	// print_r ( $_SERVER ['HTTP_ACCEPT_LANGUAGE'] );
	$str = strtolower ( $_SERVER ['HTTP_ACCEPT_LANGUAGE'] );
	$pieces = explode ( ",", $str );
	$retStr = "";
	if ($pieces [0] == "ru-ru" || $pieces [0] == "ru") {
		$retStr = "rus";
	} elseif ($pieces [0] == "kk" || $pieces [0] == "kk-kz") { // kk-KZ
		$retStr = "kaz";
	} else {
		$retStr = "eng";
	}
	// echo '<h3>$retStr=' . $retStr . "</h3>";
	return $retStr;
}
function setLanguageToSession($str) {
	switch ($str) {
		case 'kaz' :
			$_SESSION ['lang'] = "kz";
			break;
		case 'rus' :
			$_SESSION ['lang'] = "ru";
			break;
		case 'eng' :
			$_SESSION ['lang'] = "en";
			break;
		default :
			break;
	}
}

if (isset ( $_GET ['language'] )) {
	// echo "<h2>set lanf from get</h2>";
	setLanguageToSession ( $_GET ['language'] );
} else {
	if (! isset ( $_SESSION ['lang'] )) {
		setLanguageToSession ( getLanguageFromBrowser () );
		// echo "<h2>set lang from browser</h2>";
	} else {
		// echo "<h2>set lang already</h2>";
	}
}

$lang = isset ( $_SESSION ['lang'] ) ? $_SESSION ['lang'] : 'en';
$include_metrica = 0;
if (strpos ( $_SERVER ['SERVER_NAME'], 'oncojournal.kz' ) !== false) {
	$include_metrica = 1;
}
// print("<h3>SERVER_NAME=" . $_SERVER['SERVER_NAME'] . "</h3>");
// print("<h3>?=" . ($_SERVER['SERVER_NAME'] == 'www.oncojournal.kz') . "</h3>");
?>