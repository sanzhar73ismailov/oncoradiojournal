SELECT concat(`last_name_rus`, ' ', substr(`first_name_rus`,1,1)) name, 
count(*) num,
GROUP_CONCAT(distinct id  ORDER BY id SEPARATOR ',')
FROM `bibl_author`
group by name order by num desc

АЖМАГАМБЕТОВА А 	2	21,158
БЕКБОСЫНОВ Н	2	35,203
КИМ В	2	12,266
КИМ С	2	75,210
КУЛКАЕВА Г	2	222,521
СМАГУЛОВА Г	2	136,341
СУЛЕЙМЕНОВА А	2	140,263
ШАЛКАРБАЕВА Н	2	155,384


SELECT * 
FROM `bibl_author`
where id in 
(21,158
,35,203
,12,266
,75,210
,222,521
,136,341
,140,263
,155,384)
order by last_name_rus,first_name_rus  asc

