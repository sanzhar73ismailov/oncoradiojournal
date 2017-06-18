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



<div id="content"><!--<div class="quick_panel"></div>-->
<div class="center_title">{$title}</div>
<div class="comment_label">* Для сортировки по столбцу кликните по
заголовку этого столбца</div>

{include file="panel.tpl"}

<table class="table_list" id="myTable">
	<thead>
		<tr>
			<th>Код</th>
			<th>Название</th>
			<th>Тип документа</th>
			<th>Источник</th>
			<th>Год</th>
			<th>Авторы</th>
			<th>Ваш статус</th>
			<th>Регистратор</th>
			<th>-</th>


		</tr>
	</thead>
	<tbody>
		{foreach $publications as $item}

		<tr>

			<td>{$item.id}</td>
			<td>{$item.name}</td>
			<td>{$item.type}</td>
			<td>{$item.source}</td>
			<td>{$item.year}</td>
			<td>{foreach $item.authors_array as $a} {$a->last_name_rus}
			{$a->first_name_rus|mb_substr:0:1}.{$a->patronymic_name_rus|mb_substr:0:1}.<br />
			{/foreach}</td>
			<td>
			{$item.your_status}
			{if $item.responsible == 1}
				<img width="20" height="20" alt="Править" src="images/edit.jpg" />
				{/if}
				
				{if $item.coauthor == 1}
				<img width="20" height="20" alt="Править" src="images/author.jpg" />
				{/if}
			</td>
			<td>{$item.user_responsible->username_email}</td>
			
			<td><a
				href="index.php?page=publication&id={$item.id}&ce={$item.responsible}&type_publ={$item.type_detail}">
				
				Просмотр
				
				</a>

			</td>



			{/foreach}
	
	</tbody>
</table>


</div>



{include file="footer.tpl"}</div>
</body>
</html>
