{if $object->electron == 1}
<fieldset class="fragment">
<legend>Данные электронной публикации</legend>


<table class="form">
	<tr>
		<td>URL-адрес электронной публикации</td>
		<td><input {$class_req_input} required='required'
			{$readonly} type="text" id="url" name="url"
					size="50" value="{$object->url}" /></td>
	
	</tr>

	<tr>
		<td>DOI - digital object identifier, цифровой идентификатор объекта</td>
		<td><input {$class_req_input} required='required'
			{$readonly} type="text" id="doi" name="doi"
					size="50" value="{$object->doi}" /></td>
	</tr>

</table>
</fieldset>
{/if}