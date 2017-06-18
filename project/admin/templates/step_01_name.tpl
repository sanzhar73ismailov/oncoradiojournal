<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>{$title}</title>
{include file="js_include.tpl"} {if isset($generate_script) }
{$generate_script} {/if}
<script src="jscript/publForm.js"></script>

</head>
<body>


<div id="wrap">{include file="header.tpl"}



<div id="content">
<div class="center_title">{$title}</div>

{if isset($message) }

<h2>
<div style="color: green;">{$message}</div>
</h2>

{/if}

<form method="post" action="index.php" onsubmit="return checkform(this)">
<input type="hidden" name="do" value="save" />
<input type="hidden" name="page" value="{$entity}" /> 
<input type="hidden" name="entity" value="{$entity}" />
<input type="hidden" name="type_id" value="{$object->type_id}" />
<input type="hidden" name="type_publ" value="{$type_publ}" />
<input type="hidden" name="step" value="step_01_name">	
	


<table class="form">
	
	<tr>
		<td>Код публикации</td>
		<td>{if $object->id} {$object->id} <input type="hidden" name="id"
			value="{$object->id}" /> {else} <input type="hidden" name="id"
			value="0" />
		<div style="background-color: #d14836">Новый</div>
		{/if}</td>

	</tr>
	
	<tr>
		<td>Название публикации</td>
		<td><textarea {$class_req_input} required='required'
			{$readonly} name='name' cols='62' rows='3'>{$object->name}</textarea>
	
	</tr>
	
	<tr>
		<td>Название публикации</td>
		<td><textarea {$class_req_input} required='required'
			{$readonly} name='name' cols='62' rows='3'>{$object->name}</textarea>
	
	</tr>
	
	<tr>
		<td>Ключевые слова на языке публикуемого<br />
		материала и на русском языке (через запятую)</td>
		 <td>
		 <textarea {$class_req_input} required='required' {$readonly} name='keywords' cols='60' rows='2'>{$object->keywords}</textarea>
		</td>
	</tr>
	
		<tr>
		<td> Резюме (аннотация) на языке текста 
		публикуемого <br/>материала (пример: каз.)</td>
		<td><textarea  {$class_req_input} required='required' {$readonly} name='abstract_original' cols='62'
			rows='10'>{$object->abstract_original}</textarea></td>
	</tr>


	<tr>
		<td> Резюме на казахском</td>
		<td><textarea {$class_req_input} required='required' {$readonly} name='abstract_kaz' cols='62' 
		rows='10'>{$object->abstract_kaz}</textarea>
	
	</tr>

	<tr>
		<td> Резюме на русском</td>
		<td><textarea {$class_req_input} required='required' {$readonly} name='abstract_rus' cols='62' 
		rows='10'>{$object->abstract_rus}</textarea>
	
	</tr>

	<tr>
		<td> Резюме на английском</td>
		<td><textarea {$class_req_input} required='required' {$readonly} name='abstract_eng' cols='62' 
		rows='10'>{$object->abstract_eng}</textarea>
	
	</tr>
	
	<tr>
			
			<td valign="top" colspan="2">
			<button style="width: 100px">Назад</button><button style="width: 100px">Далее</button>
			</td>
		</tr>



</table>



</form>


</div>

{include file="footer.tpl"}</div>

</body>
</html>
