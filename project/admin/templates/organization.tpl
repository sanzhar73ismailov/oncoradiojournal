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
<legend>Организация</legend>

<table class="">
        <tr>
				<td>Наименование каз.</td>
				<td><input {$readonly} {$class_req_input} required='required' type='text' name='name_kaz' id='name_kaz_id' value='{$object->name_kaz}' size='100'/></td>
		</tr>
        <tr>
				<td>Наименование рус.</td>
				<td><input {$readonly} {$class_req_input} required='required' type='text' name='name_rus' id='name_rus_id' value='{$object->name_rus}' size='100'/></td>
		</tr>
        <tr>
				<td>Наименование анг.</td>
				<td><input {$readonly} {$class_req_input} required='required' type='text' name='name_eng' id='name_eng_id' value='{$object->name_eng}' size='100'/></td>
		</tr>	
</table>
</fieldset>

{include file="fragment_02_down_form.tpl"}

</form>


</div>

{include file="footer.tpl"}</div>

</body>
</html>
