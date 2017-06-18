SELECT count(*) FROM `bibl_publication_statistics` where user_agent not like "%bot%" and type='p' and action='download';


--выводит по неделям

select DATE_FORMAT(insert_date,'%u-%Y') AS Week, 
CONCAT(DATE_FORMAT(min(insert_date),'%d-%b'),' - ',
DATE_FORMAT(max(insert_date),'%d-%b')) AS period, count(*) AS num, 
COUNT( DISTINCT ip ) AS uniq_num 
from 
bibl_publication_statistics 
where user_agent not like "%bot%"
group by DATE_FORMAT(insert_date,'%u-%Y') 
order by insert_date desc



По юзер агентам от большего к меньшему
SELECT user_agent, count (*) num FROM `bibl_publication_statistics` group by  user_agent order by num desc

select DATE_FORMAT(insert_date,'%Y-%m-%d') AS date, DATE_FORMAT(insert_date,'%W') AS Day_Week, count(*) AS num, COUNT( DISTINCT username ) AS uniq_num from vizit_users group by DATE_FORMAT(insert_date,'%Y-%m-%d') order by id desc

По юзер агентам по дням:
SELECT DATE_FORMAT(insert_date,'%Y-%m-%d') AS date, 
DATE_FORMAT(insert_date,'%W') AS Day_Week, 
count(*) num 
FROM `bibl_publication_statistics` 
where user_agent = "YandexBot"
group by  DATE_FORMAT(insert_date,'%Y-%m-%d')
order by num desc
limit 10



ltx71 - (http://ltx71.com/)
Wotbox/2.01 (+http://www.wotbox.com/bot/)


if (strstr($_SERVER['HTTP_USER_AGENT'], 'YandexBot')) {
	$bot='YandexBot';
} //Выявляем поисковых ботов
elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) {
	$bot='Googlebot';
}elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'Yahoo! Slurp')) {
	$bot='Yahoobot';
}elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'Baiduspider')) {
	$bot='Baiduspiderbot';
}elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'www.opensiteexplorer.org')) {
	$bot='Opensiteexplorerbot';
}elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'www.bing.com')) {
	$bot='Bingbot';
}elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'http://ltx71.com')) {
	$bot='ltx71bot';
}elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'www.wotbox.com')) {
	$bot='Wotboxbot';
}elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'Java/')) {
	$bot='Javabot';
}

update bibl_publication_statistics set user_agent='Yahoobot' where user_agent like '%Yahoo! Slurp%';
update bibl_publication_statistics set user_agent='Baiduspiderbot' where user_agent like '%Baiduspider%';
update bibl_publication_statistics set user_agent='Opensiteexplorerbot' where user_agent like '%www.opensiteexplorer.org%';
update bibl_publication_statistics set user_agent='Bingbot' where user_agent like '%www.bing.com%';
update bibl_publication_statistics set user_agent='ltx71bot' where user_agent like '%http://ltx71.com%';
update bibl_publication_statistics set user_agent='Wotboxbot' where user_agent like '%www.wotbox.com%';
update bibl_publication_statistics set user_agent='Javabot' where user_agent like '%Java/%';
