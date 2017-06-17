<fieldset class="fragment">
<legend>Номер, дата охранного документа</legend>


<table class="form">
<!--	<tr>-->
<!--		<td>Наименование изобретения (предпатента или патента) (напр. "Способ прогнозирования клинического течения местнораспространенного рака шейки матки")</td>-->
<!--		<td><textarea {$class_req_input} required='required'-->
<!--			{$readonly} name='name' cols='62' rows='3'>{$object->name}</textarea>-->
<!--	-->
<!--	</tr>-->
	
	
	<tr>
		<td>Номер</td>
		<td><input {$class_req_input} required='required' type="text"
			{$readonly} name="patent_type_number" size="50"
			value="{$object->patent_type_number}" /></td>
	</tr>

	
	
	<tr>
		<td>От какого числа (в формате дд/мм/гггг<br />
		пример: 07/02/1980)</td>
		<td><input {$class_req_input} required='required' type="text"
			{$readonly} name="patent_date" id="patent_date"
			size="50" value="{$object->patent_date}"
			onblur="IsObjDate(this);" onkeyup="TempDt(event,this);" /></td>
	</tr>



</table>
</fieldset>