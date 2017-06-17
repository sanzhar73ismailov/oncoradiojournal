<fieldset class="fragment">
<legend>Страницы</legend>


<table class="form">
	<!--<tr>
		<td>Название публикации (доклада)</td>
		<td><textarea {$class_req_input} required='required'
			{$readonly} name='name' cols='62' rows='3'>{$object->name}</textarea>
	
	</tr>

	--><tr>
		<td>Страницы</td>
		<td>С <input {$class_req_input} required='required' type='number'
			{$readonly} min="1" name='p_first' value='{$object->p_first}'
			size='5' maxlength="5" /> &nbsp&nbsp&nbsp&nbspПо <input
			type='number'
			{$readonly} min="1" name='p_last' value='{$object->p_last}' size='5'
			maxlength="5" /></td>
	</tr>

</table>
</fieldset>