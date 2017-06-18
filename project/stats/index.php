<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Статистика</title>
</head>
<body>
<?php
include_once '../admin/includes/config.php';
include_once 'functions.php';



?>

<table border='1' width="100%">
	<tr>
		<td><!-- Header -->
		<h1>Статистика</h1>
		</td>
	</tr>
	<tr>
		<td><!-- Body -->
		<table>
			<tr>
				<td valign="top" width="20%"><!-- Left panel --> 
				<?php include "left_menu.php";?>

				</td>
				<td><!-- Right panel --> <?php
				if(isset($_REQUEST['report'])){
					switch($_REQUEST['report']){
						case 'pervichka':
							$returnColNamesAndRows = getStatView();
							printTable($returnColNamesAndRows, "Таблица по посещаемости и скачиванию");
							break;
						case 'summary':
							$returnColNamesAndRows = getSummarizeStatView();
							printTable($returnColNamesAndRows, "Таблица по посещаемости и скачиванию");
							break;
						case 'generalStat':
							$returnColNamesAndRows = getGeneralStat();
							printTable($returnColNamesAndRows, "Таблица по посещаемости и скачиванию");
							break;
						case 'searchStatByDayView':
							$returnColNamesAndRows = getStatViewGroupedByDayActionView();
							printTable($returnColNamesAndRows, "Таблица по посещаемости");
							break;
						case 'searchStatByDayDownload':
								$returnColNamesAndRows = getStatViewGroupedByDayActionDownload();
								printTable($returnColNamesAndRows, "Таблица по скачиванию");
								break;
						case 'searchStat':
							$returnColNamesAndRows = getStatSearch();
							printTable($returnColNamesAndRows, "Таблица по поиску");
							break;
						case 'keywordStatKaz':
							$returnColNamesAndRows = getKeywordStat("kaz");
							printTable($returnColNamesAndRows, "Таблица по ключ.словам каз.");
							break;
						case 'keywordStatRus':
							$returnColNamesAndRows = getKeywordStat("rus");
							printTable($returnColNamesAndRows, "Таблица по ключ.словам рус.");
							break;
						case 'keywordStatEng':
							$returnColNamesAndRows = getKeywordStat("eng");
							printTable($returnColNamesAndRows, "Таблица по ключ.словам анг.");
							break;
						case 'botGeneral':
							$returnColNamesAndRows = getBotsGeneralStat();
							printTable($returnColNamesAndRows, "Таблица по Ботам всего");
							break;
						case 'botByDay':
							$returnColNamesAndRows = getBotsByDayStat();
							printTable($returnColNamesAndRows, "Таблица по Ботам по дням");
							break;
						case 'botByWeek':
							$returnColNamesAndRows = getBotsByWeekStat();
							printTable($returnColNamesAndRows, "Таблица по Ботам по неделям");
							break;	
						case 'botByMonth':
							$returnColNamesAndRows = getBotsByMonthStat();
							printTable($returnColNamesAndRows, "Таблица по Ботам по месяцам");
							break;
							case 'botByDaySum':
								$returnColNamesAndRows = getBotsByDayStatSummar();
								printTable($returnColNamesAndRows, "Таблица по Ботам по дням суммарная");
								break;
							case 'botByWeekSum':
								$returnColNamesAndRows = getBotsByWeekStatSummar();
								printTable($returnColNamesAndRows, "Таблица по Ботам по неделям суммарная");
								break;
							case 'botByMonthSum':
								$returnColNamesAndRows = getBotsByMonthStatSummar();
								printTable($returnColNamesAndRows, "Таблица по Ботам по месяцам суммарная");
								break;
						case 'pubByAuthor':
							$returnColNamesAndRows = getNumberPublsByAuthor();
							printTable($returnColNamesAndRows, "Кол. публ.по авторам");
							break;
						case 'pubByOrg':
							$returnColNamesAndRows = getNumberPublsByOrg();
							printTable($returnColNamesAndRows, "Кол. публ.по организациям");
							break;
						default:
							echo "<h3>Пустота</h3>";
							break;

					}
				}
				?></td>
			</tr>
		</table>

		</td>
	</tr>
	<tr>
		<td><!-- Footer --></td>
	</tr>
</table>


</body>
</html>
