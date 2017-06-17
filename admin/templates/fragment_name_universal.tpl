<fieldset class="fragment"><legend>Название работы</legend>
<table class="form">


	<tr>
	    <td>На казахском</td>
		<td><textarea {* onblur="check_publ_exist(this);" *} {$class_req_input} required='required'
			{$readonly} type='text' id='name_kaz' name='name_kaz' cols='102' rows='3'>{$object->name_kaz}</textarea></td>
	</tr>
	
	<tr>
		<td>На русском</td>
		<td><textarea {* onblur="check_publ_exist(this);" *} {$class_req_input} required='required'
			{$readonly} type='text' id='name_rus' name='name_rus' cols='102' rows='3'>{$object->name_rus}</textarea></td>
	</tr>
	<tr>
		<td>На английском</td>
		<td><textarea {* onblur="check_publ_exist(this);" *} {$class_req_input} required='required'
			{$readonly} type='text' id='name_eng' name='name_eng' cols='102' rows='3'>{$object->name_eng}</textarea></td>
	</tr>
</table>
<div id="papers_founded_block" style="display:none">
<span style="color:red; font-weight: bold;">
Внимание! В базе данных найдены работы которые по названию имеют сходство с публикацией, что вы вводите.
Внимательно просмотрите список, нет ли среди них уже такой.  

</span>
<div id="papers_founded">

</div>
<button onclick="hideBlock('papers_founded_block');return false;">Скрыть (такой не имеется в списке)</button>
</div>
</fieldset>


