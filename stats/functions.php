<?php
include_once '../admin/includes/config.php';
function getPDO() {
	$connect_string = sprintf ( 'mysql:host=%s;dbname=%s', HOST, DB_NAME );
	$pdo = new PDO ( $connect_string, DB_USER, DB_PASS, array (
			PDO::ATTR_PERSISTENT => true 
	) );
	$pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$pdo->query ( "SET NAMES 'utf8'" );
	return $pdo;
}
function getArrayColumNamesAndData($query) {
	$returnObjects = array ();
	// $query = "SELECT * FROM bibl_publication p limit 10";
	$returnColNamesAndRows = array ();
	$columns = array ();
	$rows = array ();
	try {
		$pdo = getPDO ();
		$stmt = $pdo->prepare ( $query );
		// $stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->execute ();
		$rows = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		for($i = 0; $i < $stmt->columnCount (); $i ++) {
			$col = $stmt->getColumnMeta ( $i );
			$columns [] = $col ['name'];
		}
	} catch ( PDOException $ex ) {
		echo "Ошибка:" . $ex->getMessage ();
	}
	if (count ( $rows ) == 0) {
		return null;
	}
	$returnColNamesAndRows ['columns'] = $columns;
	$returnColNamesAndRows ['rows'] = $rows;
	return $returnColNamesAndRows;
}
function printTable($returnColNamesAndRows, $title) {
	echo "<h3> $title</h3>";
	echo "<table border='1'>\r\n";
	
	echo "<tr>\r\n";
	foreach ( $returnColNamesAndRows ['columns'] as $column ) {
		echo "<th>" . $column . '</th>';
	}
	echo "</tr>\r\n";
	$i = 0;
	foreach ( $returnColNamesAndRows ['rows'] as $row ) {
		$color = "";
		if($i % 2 == 0) {
			$color = "#607D8B";
		}
		echo "<tr style='background-color: $color;'>\r\n";
		//echo "<tr>\r\n";
		foreach ( $returnColNamesAndRows ['columns'] as $column ) {
			echo "<td>" . $row [$column] . '</td>';
		}
		echo "<tr>\r\n";
		$i++;
	}
	echo "</table>\r\n";
}
function getStatView() {
	return getArrayColumNamesAndData ( "select * from v_stat" );
}
function getStatViewGroupedByDayActionView() {
	$query = "select DATE_FORMAT(v.insert_date,'%Y-%m-%d') 'date' ,DATE_FORMAT(insert_date,'%W') AS Day_Week, v.action, COUNT(*) num ". 
				" from v_stat v " . 
			    " where v.action='view' " .
				" group by v.action, DATE_FORMAT(v.insert_date,'%Y-%m-%d')";
	return getArrayColumNamesAndData ( $query );
}
function getStatViewGroupedByDayActionDownload() {
	$query = "select DATE_FORMAT(v.insert_date,'%Y-%m-%d') 'date' ,DATE_FORMAT(insert_date,'%W') AS Day_Week, v.action, COUNT(*) num ".
			" from v_stat v " .
			" where v.action='download' " .
			" group by v.action, DATE_FORMAT(v.insert_date,'%Y-%m-%d')";
	return getArrayColumNamesAndData ( $query );
}
function getSummarizeStatView() {
	$query = "SELECT
  p.id,
  p.name_rus,
  GROUP_CONCAT(CONCAT(a.last_name_rus, ' ', a.first_name_rus)) AS authors_name,
  bibl_issue.`year`,
  bibl_issue.number,
  bibl_issue.issue,
  bibl_section.name_rus AS section_name,
  (SELECT count(*) num FROM `v_stat` t where type='p' and action='download' and t.item_id=p.id group by  t.item_id) as 'downloadedNum',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id=p.id and lang='kaz' group by  t.item_id ) as 'viewedNumKaz',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id=p.id and lang='rus' group by  t.item_id ) as 'viewedNumRus',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id=p.id and lang='eng' group by  t.item_id) as 'viewedNumEng',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id=p.id group by  t.item_id ) as 'viewedNum'
FROM
  bibl_publication p
  INNER JOIN bibl_publication_author pa ON (p.id = pa.publication_id)
  INNER JOIN bibl_author a ON (pa.author_id = a.id)
  INNER JOIN bibl_issue ON (p.issue_id = bibl_issue.id)
  INNER JOIN bibl_section ON (p.section_id = bibl_section.id)
GROUP BY
  p.id,
  p.name_rus,
  bibl_issue.`year`,
  bibl_issue.number,
  bibl_issue.issue,
  bibl_issue.`file`,
  bibl_section.name_rus
ORDER BY viewedNum desc";
	return getArrayColumNamesAndData ( $query );
}
function getGeneralStat() {
	$query = "select 'entyties', 'number' from bibl_publication
union
select 'issues', COUNT(*) from bibl_issue
union
select 'publications', COUNT(*) from bibl_publication
union
select 'authors', COUNT(*) from bibl_author
union
select 'unused authors', COUNT(*) from bibl_author a where a.id not in (select pa.author_id from bibl_publication_author pa)
union
select 'organizations', COUNT(*) from bibl_organization
union
select 'sections', COUNT(*) from bibl_section
union
select 'keywords', COUNT(*) from bibl_keyword k where k.lang='rus'
union
select 'unused keywords', COUNT(*) from bibl_keyword k where k.id not in (select pk.keyword_id from bibl_publication_keyword pk)
union
select 'просмотрено статей', COUNT(*) from v_stat where type='p'
union
select 'просмотрено статей на каз.', COUNT(*) from v_stat t where type='p' and t.action='view' and t.lang='kaz'
union
select 'просмотрено статей на рус.', COUNT(*) from v_stat t where type='p' and t.action='view' and t.lang='rus'
union
select 'просмотрено статей на анг.',COUNT(*) from v_stat t where type='p' and t.action='view' and t.lang='eng'
union
select 'скачано статей',COUNT(*) from v_stat t where type='p' and t.action='download'
union
select 'просмотрено номеров',COUNT(*) from v_stat t where type='i' and t.action='view'
union
select 'скачано номеров',COUNT(*) from v_stat t where type='i' and t.action='download'";
	return getArrayColumNamesAndData ( $query );
}
function getStatSearch() {
	return getArrayColumNamesAndData ( "select * from bibl_search_statistics" );
}
function getKeywordStat($lang) {
	$query = "SELECT  bibl_keyword.name, COUNT(*) AS num
	FROM
	bibl_publication_keyword
	INNER JOIN bibl_keyword ON (bibl_publication_keyword.keyword_id = bibl_keyword.id)
	where bibl_keyword.`lang`='$lang'
	GROUP BY
	bibl_keyword.id
	ORDER BY
	num DESC";
	return getArrayColumNamesAndData ( $query );
}
function getBotsGeneralStat() {
	$query = "
			SELECT
			  s.user_agent,
			  count(*) AS num
			FROM
			  bibl_publication_statistics s
			WHERE
			  s.user_agent LIKE '%bot%'
			GROUP BY
			  s.user_agent
			ORDER BY
			 num DESC
			";
	return getArrayColumNamesAndData ( $query );
}
function getBotsByDayStat() {
	$query = "SELECT
	s.user_agent,
  DATE_FORMAT(s.insert_date,'%Y-%m-%d') day1,
  count(*) AS num
FROM
  bibl_publication_statistics s
WHERE
  s.user_agent LIKE '%bot%'
GROUP BY
  s.user_agent,
  DATE_FORMAT(s.insert_date,'%Y-%m-%d')
ORDER BY
 day1 desc,			
  num DESC";
	return getArrayColumNamesAndData ( $query );
}
function getBotsByWeekStat() {
	$query = "SELECT
	s.user_agent,
  DATE_FORMAT(insert_date,'%u-%Y') Week,
  CONCAT(DATE_FORMAT(min(insert_date),'%d-%b'),' - ',DATE_FORMAT(max(insert_date),'%d-%b')) AS period,
  count(*) AS num
FROM
  bibl_publication_statistics s
WHERE
  s.user_agent LIKE '%bot%'
GROUP BY
  s.user_agent,
  DATE_FORMAT(insert_date,'%u-%Y')
ORDER BY
DATE_FORMAT(insert_date,'%u-%Y') desc,
  num DESC";
	return getArrayColumNamesAndData ( $query );
}
function getBotsByMonthStat() {
	$query = "SELECT
  s.user_agent,
  DATE_FORMAT(s.insert_date,'%b-%Y') AS Month,
  count(*) AS num	
FROM
  bibl_publication_statistics s
WHERE
  s.user_agent LIKE '%bot%'
GROUP BY
  s.user_agent,
  DATE_FORMAT(s.insert_date,'%b-%Y') 
ORDER BY
DATE_FORMAT(s.insert_date,'%b-%Y')  desc,
  num DESC";
	return getArrayColumNamesAndData ( $query );
}

function getBotsByDayStatSummar() {
	$query = "select m.user_agent, min(m.num) min, max(m.num) max,avg(m.num) avg,sum(m.num) sum  from 
(SELECT
	s.user_agent,
  DATE_FORMAT(s.insert_date,'%Y-%m-%d') day1,
  count(*) AS num
FROM
  bibl_publication_statistics s
WHERE
  s.user_agent LIKE '%bot%'
GROUP BY
  s.user_agent,
  DATE_FORMAT(s.insert_date,'%Y-%m-%d')
ORDER BY
 day1 desc,			
  num DESC) m
  GROUP BY m.user_agent
  ORDER by m.num desc";
	return getArrayColumNamesAndData ( $query );
}
function getBotsByWeekStatSummar() {
	$query = "select m.user_agent, min(m.num) min, max(m.num) max,avg(m.num) avg,sum(m.num) sum  from 
(SELECT
	s.user_agent,
  DATE_FORMAT(insert_date,'%u-%Y') Week,
  CONCAT(DATE_FORMAT(min(insert_date),'%d-%b'),' - ',DATE_FORMAT(max(insert_date),'%d-%b')) AS period,
  count(*) AS num
FROM
  bibl_publication_statistics s
WHERE
  s.user_agent LIKE '%bot%'
GROUP BY
  s.user_agent,
  DATE_FORMAT(insert_date,'%u-%Y')
ORDER BY
DATE_FORMAT(insert_date,'%u-%Y') desc,
  num DESC) m
  GROUP BY m.user_agent
  ORDER by m.num desc";
	return getArrayColumNamesAndData ( $query );
}
function getBotsByMonthStatSummar() {
	$query = "select m.user_agent, min(m.num) min, max(m.num) max,avg(m.num) avg,sum(m.num) sum  from 
(SELECT
  s.user_agent user_agent,
  DATE_FORMAT(s.insert_date,'%b-%Y') AS Month,
  count(*) AS num,
  AVG(s.user_agent) AS average			
	
FROM
  bibl_publication_statistics s
WHERE
  s.user_agent LIKE '%bot%'
GROUP BY
  s.user_agent,
  DATE_FORMAT(s.insert_date,'%b-%Y') 
ORDER BY
DATE_FORMAT(s.insert_date,'%b-%Y')  desc,
  num DESC) m
  GROUP BY m.user_agent
  ORDER by m.num desc";
	return getArrayColumNamesAndData ( $query );
}


function getNumberPublsByAuthor() {
	$query = "
SELECT 
  bibl_author.last_name_rus,
  bibl_author.first_name_rus,
  bibl_author.patronymic_name_rus,
  COUNT(*) AS num
FROM
  bibl_publication_author
  INNER JOIN bibl_author ON (bibl_publication_author.author_id = bibl_author.id)
GROUP BY
  bibl_author.id,
  bibl_author.last_name_rus,
  bibl_author.first_name_rus,
  bibl_author.patronymic_name_rus
ORDER BY
  num DESC";
	return getArrayColumNamesAndData ( $query );
}
function getNumberPublsByOrg() {
	$query = "
SELECT 
  bibl_organization.name_rus,
  COUNT(*) AS num
FROM
  bibl_publication_author
  INNER JOIN bibl_organization ON (bibl_publication_author.organization_id = bibl_organization.id)
GROUP BY
  bibl_organization.id
ORDER BY
  num DESC";
	return getArrayColumNamesAndData ( $query );
}

?>