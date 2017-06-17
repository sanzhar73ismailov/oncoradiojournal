<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>{$title}</title>
{include file="js_include.tpl"}
<script src="jscript/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(document).ready(function() 
	    { 
	        $("#myTable").tablesorter(); 
	    } 
	);
</script>
<style>
   ul {
    padding: 0; /* Убираем поля */
    margin-left: 20px; /* Отступ слева */
   }
  </style>
</head>
<body>
<div id="wrap">{include file="header.tpl"}



<div id="content"><!--<div class="quick_panel"></div>-->
<div class="center_title">{$title}</div>
<div class="comment_label">* Для сортировки по столбцу кликните по
заголовку этого столбца</div>

{*include file="panel.tpl"*}


<fieldset class="fragment">
<legend>Фильтр по номеру</legend>
<table border="1"><tr>
{for $i=0 to (count($list_issues)-1)}
{assign var="nomer_name" value="{$list_issues[$i]->year}-({$list_issues[$i]->number})-{$list_issues[$i]->issue}"}


{if $i>0 && $i%8==0}
</tr><tr>
{/if}
<td><a class="filter_publ" id='{$nomer_name}'  href="" onclick="return showRowsofPublications('{$nomer_name}');">{$nomer_name}</a></td>
{/for}
</tr>
<tr>
		<td colspan="7" align="center"><input type="submit" name="submit"
			value="Сбросить фильтр (показать всё)" style="width:500px;"
			onclick="showAllrowsPubs();"></td>
			<td colspan="8" align="center">Выбрано:<span id="selected">{count($publications)}</span></td>
	</tr>
</table>
</fieldset>



<table class="table_list" id="myTable">
	<thead>
		<tr>
			<th>Код</th>
			<th>Название</th>
			<th>ТД</th>
			<th>Год</th>
			<th>Ном</th>
			<th>Вып</th>
			<th>Стр</th>
			<th>Авторы</th>
			<th>Ключевые слова</th>
		</tr>
	</thead>
	<tbody>
		{foreach $publications as $item}

		<tr class="publ{$item.issueObj->year}-({$item.issueObj->number})-{$item.issueObj->issue}">

			<td>{$item.id}</td>
			{*
			http://localhost/publ/index.php?page=publication&do=edit&type_publ=paper_classik&issue_id=15&section_id=19&author_id=62&authors_orgs%5B%5D=62%5E3
			<td><a href='index.php?page=add_publication_authors_organizations&id={$item.id}'>{$item.name}</a></td>
			
			<td><a href='index.php?page=add_publication_authors_organizations&id={$item.id}'>{$item.name}</a></td>
			*}
			
			<td><a href='index.php?page=publication&do=view&type_publ=paper_classik&id={$item.id}'>{$item.name_rus}</a></td>
			<td>{$item.type|truncate:2:""}</td>
			<td>{$item.issueObj->year}</td>
			<td>{$item.issueObj->number}</td>
			<td><nobr>{$item.issueObj->issue}</nobr></td>
			<td><nobr>{$item.p_first}-{$item.p_last}</nobr></td>
			<td style='font-size: 70%;'>
			 <ul>
				{foreach $item.authors_array as $a} 
				<li>{$a->author_name}</li>
				{/foreach}
			 </ul>
			</td>
			<td style='font-size: 70%;'>
			 <ul>
				{foreach $item.keywords_array as $a} 
				<li><nobr>{$a->name}({$a->lang})</nobr></li>
				{/foreach}
			 </ul>
			</td>
		{/foreach}
	
	</tbody>
</table>


</div>



{include file="footer.tpl"}</div>
</body>
</html>
