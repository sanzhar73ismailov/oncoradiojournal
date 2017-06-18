<?php
define('SMARTY_DIR', '../Smarty-3.1.18/libs/');
define('SITE_NAME', "Публикации КАЗНИИ ОиР");
define('DEBUG', "1");
define('ADMIN_CODE', "onco2014");
define('ADMIN_EMAIL', "support@biostat.kz");
define('ORG_NAME', "Казахский научно-исследовательский институт онкологии и радиологии МЗ РК");

define("PAPER", 1);
define("BOOK", 2);
define("TEZIS", 3);
define("ELRES", 4);
define("PATENT", 5);
define("METHOD_RECOM", 6);

include_once 'includes/class_dao.php';
require_once(SMARTY_DIR . 'Smarty.class.php');
include_once 'includes/class_dictionary.php';
include_once 'includes/class_user.php';
include_once 'includes/class_navigate.php';
include_once 'includes/class_EntityEditAbstr.php';
include_once 'includes/class_global.php';
include_once 'includes/functions.php';

$smarty = new Smarty();
$smarty->assign('application_name',SITE_NAME);
//$smarty->force_compile = true;
$dao = new Dao();
//$globalObject = new GlobalObject();
//$globalObject->smarty = $smarty;
//$globalObject->dao = $dao;


ini_set("display_errors",1);
error_reporting(E_ALL);

/* For Logging  start */
$fileExtension = (file_exists('includes/global.php')) ? '' : '../';
include_once ($fileExtension . 'a_logger/logger.php'); // logger of sanzhar 04.04.2016
Logger::$PATH = $fileExtension . "a_logs";// . "\logs";
define ('TO_LOG', 0); // turn on logging - 1, turn off - 0

/* For Logging  end */

?>