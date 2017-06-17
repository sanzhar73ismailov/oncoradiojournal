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
</head>
<body>
<div id="wrap">{include file="header.tpl"}



<div id="content">
<div class="center_title">{$title}</div>
<div class="comment_label">* Для сортировки по столбцу кликните по
заголовку этого столбца</div>

<table class="table_list" id="myTable">
	<thead>
		<tr>
			<th>Код</th>
			<th>Год</th>
			<th>Номер</th>
			<th>Выпуск</th>
			<th>-</th>
			<th>секции</th>
		</tr>
	</thead>
	<tbody>
		{foreach $list as $item}
		<tr>
			<td><a href='index.php?page=issue&id={$item->id}&do=view'>{$item->id}</a></td>
			<td>{$item->year}</td>
			<td>{$item->number}</td>
			<td>{$item->issue}</td>
			<td><nobr><a href='index.php?page=publication&issue_id={$item->id}&type_publ=paper_classik&do=edit'>Добавить публикацию</a></nobr></td>
			<td>
				{foreach $item->sections as $a} 
				<nobr>{$a->name_rus}<b>|</b></nobr>
				{/foreach}
			</td>
		</tr>	
			{/foreach}
	
	</tbody>
</table>


</div>



{include file="footer.tpl"}</div>
</body>
</html>
