<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>{$title}</title>
{include file="js_include.tpl"}
</head>
<body>
<div id="wrap">{include file="header.tpl"}
<div id="content">
<div class="center_title">{$application_name}</div>

<table class="table_on_index">

	<tbody>
		<tr>
			<td>Добро пожаловать!</td>
		</tr>
		<!--  Закоментировано
		<tr>
			<td><a href="index.php?page=publication&do=edit">
			<button class="button_on_index">Добавить публикацию в формате КазНИТИ</button>
			</a></td>
		</tr>
		
		<tr>
			<td><a href="index.php?page=publication&do=edit&type_publ=tezis">
			<button class="button_on_index">Добавить тезис</button>
			</a></td>
		</tr>
		
		<tr>
			<td><a href="index.php?page=publication&do=edit&type_publ=patent">
			<button class="button_on_index">Добавить охранный документ</button>
			</a></td>
		</tr>
		
		<tr>
			<td><a href="index.php?page=publication&do=edit&type_publ=book">
			<button class="button_on_index">Добавить книгу (монографию)</button>
			</a></td>
		</tr>
		
		<tr>
			<td><a href="index.php?page=publication&do=edit&type_publ=method_recom">
			<button class="button_on_index">Добавить метод. рекомендацию</button>
			</a></td>
		</tr>
		
		<tr>
			<td><a href="index.php?page=list">
			<button class="button_on_index">Список публикаций</button>
			</a></td>
		</tr>

		<tr>
		
	

		<td><a href="index.php?page=logout">
		<button class="button_on_index">Выход</button>
		</a></td>
		</tr>
		-->


	</tbody>
</table>

<fieldset class="statistica"><legend>Статистика:</legend> 
{foreach $statistica as $item} {$item.type_name}: {$item.quantity}
<p />
{/foreach}</fieldset>


</div>
{if isset($message) and $message!=""}
<table class="form">


	<tr>
		<td></td>
		<td>
		<div>{$message}</div>
		</td>


	</tr>
	<tr>
		<td></td>
		<td></td>



	</tr>


</table>

{/if} {include file="footer.tpl"}</div>
</body>
</html>
