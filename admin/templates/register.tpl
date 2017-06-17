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
<div class="center_title">Регистрация</div>

{if !$result}

<form method="post" action="register.php"
	onsubmit="return checkRegisterForm(this)">


<table class="form">




	<tr>
		<td>Ваша электронная почта
		
		<input type="hidden" name="entity" value="user"/>
		<input type="hidden" name="id" value="0"/>
		</td>
		<td><input id="username_email" type="email" name="username_email" size="50" required="required" value='{$object->username_email}' /></td>
	</tr>

	<tr>
		<td>Пароль</td>
		<td><input id="password1" type="password" name="password" size="50"
			required="required" /></td>
	</tr>
		<tr>
		<td>&nbsp</td>
		<td><div style="font-size: small;">не менее 6 символов, только латинские буквы и цифры</div></td>
	</tr>

	<tr>
		<td>Пароль повторить</td>
		<td><input id="password2" type="password" name="password_copy" size="50"
			required="required" /></td>
	</tr>
	
	<tr>
		<td>Код допуска (выдается админом)</td>
		<td><input id="code" type="password" name="code" size="50"
			required="required" /></td>
	</tr>
	
	<tr>
		<td>Фамилия</td>
		<td><input id="last_name" type="text" name="last_name" size="50" value='{$object->last_name}'
			required="required" /></td>
	</tr>
	
	<tr>
		<td>Имя</td>
		<td><input id="first_name" type="text" name="first_name" size="50" value='{$object->first_name}'
			required="required" /></td>
	</tr>
	
	<tr>
		<td>Отчество</td>
		<td><input id="patronymic_name" type="text" name="patronymic_name" size="50" value='{$object->patronymic_name}'/></td>
	</tr>
	
	<tr>
		<td>Фамилия на английском</td>
		<td><input id="last_name_en" type="text" name="last_name_en" size="50" value='{$object->last_name_en}'
			required="required" /></td>
	</tr>
	
	<tr>
		<td>Имя на английском</td>
		<td><input id="first_name_en" type="text" name="first_name_en" size="50" value='{$object->first_name_en}'
			required="required" /></td>
	</tr>
	
	<tr>
		<td>Отчество на английском</td>
		<td><input id="patronymic_name_en" type="text" name="patronymic_name_en" size="50" value='{$object->patronymic_name_en}'/></td>
	</tr>
	
	<tr>
		<td>Пол</td>
		<td>
		<input {if $object->sex_id=='1'} checked='checked' {/if} type="radio"  name='sex_id' value="1" required="required" /> Мужской
		<input {if $object->sex_id=='2'} checked='checked' {/if} type="radio"  name='sex_id' value="2" required="required" /> Женский
	</td>
	</tr>
	
	<tr>
		<td>Отделение (подразделение)</td>
		<td><input id="departament" type="text" name="departament" size="50" value='{$object->departament}'
			required="required" /></td>
	</tr>
	
	<tr>
		<td>Должность</td>
		<td><input id="status" type="text" name="status" size="50" value='{$object->status}'
			required="required" /></td>
	</tr>
	
	
	
	<tr>
		<td></td>
		<td><input type="submit" value="ОК"
			style="width: 120px; height: 20px"></td>

	</tr>
	<tr>
		<td></td>
		<td>
		<div style="color: red;">{$message}</div>
		</td>

	</tr>


</table>

</form>
{else}

<table class="form">


	<tr>
		<td></td>
		<td>
		<div style="color: green;">{$message}</div>
		</td>

	</tr>


</table>
{/if}</div>







{include file="footer.tpl"}</div>
</body>
</html>
