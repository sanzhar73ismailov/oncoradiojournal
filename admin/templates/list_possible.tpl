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
<div class="center_title">Возможно мои публикации</div>
<div class="comment_label">* Для сортировки по столбцу кликните по
заголовку этого столбца</div>
<div style="color: red">Отметьте галочками работы, соавтором которых вы являетесь и нажмите "Подтвердить". Эти работы будут отображаться в списке Ваших работ</div>
<form method="post" action="index.php">
<input type="hidden" name="page" value="save_possible">
<table class="table_list" id="myTable">
	<thead>
		<tr>
		    <th>Отметить свои</th>
			<th>Код</th>
			<th>Название</th>
			<th>Источник</th>
			<th>Год</th>
			<th>Авторы</th>
			
			


		</tr>
	</thead>
	<tbody>
		{foreach $publications as $item}

		<tr>


<td><input type="checkbox" name="ids[]" value="{$item.id}">  </td>
			<td>{$item.id}</td>
			<td>{$item.name}</td>
			<td>{$item.source}</td>
			<td>{$item.year}</td>
			
			<td>{foreach $item.authors_array as $a} {$a->last_name}
			{$a->first_name|mb_substr:0:1}.{$a->patronymic_name|mb_substr:0:1}.<br />
			{/foreach}</td>
           
           



			{/foreach}
	
	</tbody>
</table>
<input type="submit" value="Подтверждаю"/>
</form>

</div>



{include file="footer.tpl"}</div>
</body>
</html>
