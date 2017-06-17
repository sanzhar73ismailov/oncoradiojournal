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
			<th>ФИО каз.</th>
			<th>ФИО рус.</th>
			<th>ФИО анг.</th>
			<th>эл.почта</th>
			<th>ученая степень</th>
		</tr>
	</thead>
	<tbody>
		{foreach $list as $item}
		<tr>
			<td><a href='index.php?page=author&id={$item->id}&do=edit'>{$item->id}</a></td>
			<td>{$item->last_name_kaz} {$item->first_name_kaz} {$item->patronymic_name_kaz}</td>
			<td>{$item->last_name_rus} {$item->first_name_rus} {$item->patronymic_name_rus}</td>
			<td>{$item->last_name_eng} {$item->first_name_eng} {$item->patronymic_name_eng}</td>
			<td>{$item->email}</td>
			<td>{$item->degree}</td>
		
		</tr>	
			{/foreach}
	
	</tbody>
</table>


</div>



{include file="footer.tpl"}</div>
</body>
</html>
