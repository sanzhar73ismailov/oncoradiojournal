SELECT * FROM `v_stat`;

SELECT t.item_id, count(*) num
FROM `v_stat` t 
where type='p' and action='view'
group by  t.item_id
order by num desc;

SELECT t.item_id, count(*) num
FROM `v_stat` t 
where type='p' and action='download'
group by  t.item_id
order by num desc;

SELECT 'kaz', t.item_id, count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='kaz' group by  t.item_id 
union
SELECT 'rus', t.item_id, count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='rus' group by  t.item_id 
union
SELECT 'eng',t.item_id, count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='eng' group by  t.item_id
union
SELECT 'total', t.item_id, count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' group by  t.item_id 

select p.id,p.name_rus,
(
SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='kaz' group by  t.item_id 
) as 'kaz',
(
SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='rus' group by  t.item_id 
) as 'rus',
(
SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='eng' group by  t.item_id
) as 'eng',
(
SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' group by  t.item_id 
) as 'total'
from bibl_publication p where id='233'

select p.id,p.name_rus,
(SELECT count(*) num FROM `v_stat` t where type='p' and action='download' and t.item_id='233' group by  t.item_id) as 'download',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='kaz' group by  t.item_id ) as 'kaz',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='rus' group by  t.item_id ) as 'rus',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='eng' group by  t.item_id) as 'eng',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' group by  t.item_id ) as 'total'
from bibl_publication p where id='233'



select p.id,p.name_rus,
(SELECT count(*) num FROM `v_stat` t where type='p' and action='download' and t.item_id='233' group by  t.item_id) as 'downloadedNum',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='kaz' group by  t.item_id ) as 'viewedNumKaz',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='rus' group by  t.item_id ) as 'viewedNumRus',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' and lang='eng' group by  t.item_id) as 'viewedNumEng',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id='233' group by  t.item_id ) as 'viewedNum'
from bibl_publication p where id='233'

$query = "SELECT p.*,	
(SELECT count(*) num FROM `v_stat` t where type='p' and action='download' and t.item_id=p.id group by  t.item_id) as 'downloadedNum',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id=p.id and lang='kaz' group by  t.item_id ) as 'viewedNumKaz',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id=p.id and lang='rus' group by  t.item_id ) as 'viewedNumRus',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id=p.id and lang='eng' group by  t.item_id) as 'viewedNumEng',
(SELECT count(*) num FROM `v_stat` t where type='p' and action='view' and t.item_id=p.id group by  t.item_id ) as 'viewedNum'
from bibl_publication p order by viewedNum desc";


SELECT t.item_id, count(*) num
FROM `v_stat` t 
where type='i'  and action='view' 
group by  t.item_id
order by num desc;
