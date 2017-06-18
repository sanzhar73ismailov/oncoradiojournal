--select * from `bibl_keyword` k where k.name REGEXP "\r\n" order by id;

select distinct
p.id, 
p.`name_rus`,
i.`year`,
i.`issue`,
i.`number`,
p.`p_first`,
(
		select GROUP_CONCAT(distinct LCASE(k.name) SEPARATOR ', ') 
		from bibl_publication_keyword pk
		inner join bibl_keyword k on pk.keyword_id=k.id
		where pk.publication_id=p.id 
        and k.name REGEXP "\r\n" 
) AS keywords
from bibl_publication p
inner join `bibl_issue` i on p.`issue_id`=i.id
inner join `bibl_publication_keyword` pk on p.`id`=pk.`publication_id`
inner join `bibl_keyword` k on k.`id`=pk.`keyword_id`
where k.name REGEXP "\r\n" order by i.`year`, i.`issue`, i.`number`,p.`p_first`;
;

select distinct
p.id, 
p.`name_rus`,
i.`year`,
i.`issue`,
i.`number`,
p.`p_first`
from bibl_publication p
inner join `bibl_issue` i on p.`issue_id`=i.id
inner join `bibl_publication_keyword` pk on p.`id`=pk.`publication_id`
inner join `bibl_keyword` k on k.`id`=pk.`keyword_id`
where 
p.`abstract_rus` like "%-%" 
OR p.`abstract_eng` like "%-%"
OR p.`abstract_kaz` like "%-%"
order by i.`year`, i.`issue`, i.`number`,p.`p_first`;
;