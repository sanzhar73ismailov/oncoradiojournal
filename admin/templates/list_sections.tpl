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
			<th>Наименование каз.</th>
			<th>Наименование рус.</th>
			<th>Наименование анг.</th>
		</tr>
	</thead>
	<tbody>
		{foreach $list as $item}
		<tr>
			<td><a href='index.php?page=section&id={$item->id}&do=edit'>{$item->id}</a></td>
			<td>{$item->name_kaz}</td>
			<td>{$item->name_rus}</td>
			<td>{$item->name_eng}</td>
		
		</tr>	
			{/foreach}
	
	</tbody>
</table>


</div>



{include file="footer.tpl"}</div>
</body>
</html>
