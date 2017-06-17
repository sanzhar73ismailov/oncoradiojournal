<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>{$title}</title>
{include file="js_include.tpl"} 
{if isset($generate_script) }
{$generate_script} {/if}
<script src="jscript/publForm.js"></script>

</head>
<body>


<div id="wrap">{include file="header.tpl"}



<div id="content">
<div class="center_title">{$title}</div>

{include file="fragment_message.tpl"}

<form method="post" action="index.php" onsubmit="return checkform(this)">

<input type="hidden" name="do" value="save" />
<input type="hidden" name="page" value="{$entity}" />
<input	type="hidden" name="entity" value="{$entity}" />

{include file="fragment_01_up_form_for_dic.tpl"}
<fieldset class="fragment">
<legend>Автор</legend>
<div id="message_id" style="color:red;"></div>
<table class="">
{if $edit}
 <tr><td colspan="2">пример: 'Петров С.И.'<input id="add_author_id" value="{if isset($smarty.get.searchFullname)}{$smarty.get.searchFullname}{/if} " size="80"/><button onclick="add_auto();return false;">Раскидать по полям</button></td> </tr>
 {/if}
        <tr><td>Язык</td>
        <td><table border="0" width="100%"><tr><td width="33%">Фамилия</td><td width="33%">Имя</td><td width="33%">Отчество</td></tr></table></td>
        <tr>
					<td>Казахский</td>
					<td><input {$readonly} {$class_req_input} required='required' type='text' name='last_name_kaz' id='last_name_kaz_id' value='{$object->last_name_kaz}' size='20' />
					<input {$readonly} {$class_req_input} required='required' type='text' name='first_name_kaz' id='first_name_kaz_id' value='{$object->first_name_kaz}' size='20' />
					<input {$readonly} type='text' name='patronymic_name_kaz' id='patronymic_name_kaz_id' value='{$object->patronymic_name_kaz}' size='20' /></td>
		</tr>
		<tr>
					<td>Русский</td>
					<td><input {$readonly} {$class_req_input} required='required' type='text' name='last_name_rus' id='last_name_rus_id' value='{$object->last_name_rus}' size='20' />
					<input {$readonly} {$class_req_input} required='required' type='text' name='first_name_rus' id='first_name_rus_id' value='{$object->first_name_rus}' size='20' />
					<input {$readonly} type='text' name='patronymic_name_rus' id='patronymic_name_rus_id' value='{$object->patronymic_name_rus}' size='20' /></td>
		</tr>
		
		<tr>
					<td>Английский</td>
					<td><input {$readonly} {$class_req_input} required='required' type='text' name='last_name_eng' id='last_name_eng_id' value='{$object->last_name_eng}' size='20' />
					<input {$readonly} {$class_req_input} required='required' type='text' name='first_name_eng' id='first_name_eng_id' value='{$object->first_name_eng}' size='20' />
					<input {$readonly} type='text' name='patronymic_name_eng' id='patronymic_name_eng_id' value='{$object->patronymic_name_eng}' size='20' /></td>
		</tr>
		<tr>
			<td>Эл. почта</td>
			<td><input {$readonly} type='email' name='email' id='email_id' value='{$object->email}' size='70' /></td>
		</tr>
		
		<tr>
			<td>Ученая степень</td>
			<td><input {$readonly} type='text' name='degree' id='degree_id' value='{$object->degree}' size='70' /></td>
		</tr>
		
		<tr>
			<td valign="top">Выберите организацию</td>
			<td>
			<select size="10" {$class_req_input} required='required'
				{$disabled} name="organization_id" id="organization_id" style="width: 500px">
				{foreach $organizations as $item}
				<option value="{$item->id}" {if $item->id == $object->organization_id}
				selected="selected"{/if} >{$item->name_rus}</option>
				{/foreach}
			</select><br/>
			{if $edit}
			<input id="search_org_id" value="" size="70"/><button onclick="search_org_in_select();return false;">Найти организацию</button><br/>
			<button onclick="select_kaznii();return false;">Выбрать КазНИИ ОиР</button>
			{/if}
			
			</td>
		</tr>			
		

</table>
</fieldset>
{include file="fragment_02_down_form.tpl"}

</form>


</div>

{include file="footer.tpl"}</div>

</body>
</html>
