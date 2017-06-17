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
<div class="center_title">{$title}</div>
<form method="get" action="index.php">
<input type="hidden" name="page" value="publication">
<input type="hidden" name="do" value="edit">
<table class="table_on_publ_add">

	<tbody>

		<tr>
			<td valign="top">
			<input type="radio" name="type_publ" value="paper_classik"  required="required"/></td>
			<td valign="top" style="color: green; width: 100px">Статья
			классическая</td>
			<td valign="top">Публикация периодического издания (журнала)</td>
		</tr>

		<tr>
			<td colspan="3">
			<fieldset><legend>Научные собрания (конференции, съезды и т.п.)</legend>
			<table>
				<tr>
					<td valign="top">
					<input type="radio" name="type_publ" value="tezis_paper_spec" required="required"/></td>
					<td valign="top" style="color: green; width: 100px">Статья спец.
					выпуска</td>
					<td valign="top">опубликованная в специальном выпуске
					периодического журнала</td>
				</tr>
				<tr>
					<td valign="top"><input type="radio" name="type_publ"
						value="tezis_paper"  required="required"/></td>
					<td valign="top" style="color: green; width: 100px">Статья</td>
					<td valign="top">опубликованная в сборнике, (публикация более 3
					страниц)</td>
				</tr>
				<tr>
					<td valign="top"><input type="radio" name="type_publ"
						value="tezis_tezis"  required="required"/></td>
					<td valign="top" style="color: green; width: 100px">Тезис</td>
					<td valign="top">тезис, доклад, постер (публикация до 3 страниц)</td>
				</tr>

			</table>
			</fieldset>
			</td>

		</tr>


		<tr>
			<td valign="top"><input type="radio" name="type_publ" value="patent"  required="required"/></td>
			<td valign="top" style="color: green; width: 100px">Охранный документ</td>
			<td valign="top">Патенты, предпатенты, изобретения, авторские
			свидетельства и т.п.</td>
		</tr>

		<tr>
			<td valign="top"><input type="radio" name="type_publ" value="book"  required="required"/></td>
			<td valign="top" style="color: green; width: 100px">Книга</td>
			<td valign="top">Книги, моногафии</td>
		</tr>

		<tr>
			<td valign="top"><input type="radio" name="type_publ"
				value="method_recom"  required="required"/></td>
			<td valign="top" style="color: green; width: 100px">Методика</td>
			<td valign="top">Методические рекомендации, руководства</td>
		</tr>
       <!-- 
		<tr>
			<td valign="top"><input type="radio" name="type_publ" value="disser"  required="required"/></td>
			<td valign="top" style="color: green; width: 100px">Диссертация</td>
			<td valign="top">Авторефераты, диссертации</td>
		</tr>
		<tr>
        -->		
		<tr>
			<td valign="top"><input type="checkbox" name="electron" value="1" /></td>
			<td valign="top" style="color: red; width: 100px">Электронная публикация</td>
			<td valign="top">Отметить дополнительно к выбранному варианту публикации выше, если работа опубликована в электронном журнале (имеется URL-адрес и номер DOI)</td>
		</tr>
		<tr>
		
		
		
			<td valign="top" colspan="3">
			<button style="width: 100px">Далее</button>
			</td>
		</tr>





	</tbody>
</table>
</form>

{include file="footer.tpl"}</div>

</body>
</html>
