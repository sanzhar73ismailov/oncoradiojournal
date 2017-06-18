<fieldset class="fragment">
<legend>Автор(ы) публикации</legend>
<table class="numerated-table" id="authors">
	<tr>
		<th>N</th>
		<th>Вставить мои данные</th>
		<th>Фамилия (полностью)</th>
		<th>Имя<br />
		(инициал, без точки)</th>
		<th>Отчество<br />
		(инициал, без точки)</th>
		<th>8. Место работы автора(ов) <br />
		(полное название организации)<br />
		например: Национальная инженерная академия <br />
		или КазНУ им. аль-Фараби</th>
		<th>
		{if $edit}
		<a onclick="addItem('last_author'); return false;">
		<button>Добавить автора</button>
		</a>
		{/if}
		</th>
	</tr>
	<tbody>


		{foreach $object->authors_array as $item}
		<tr {if $item@last}id='last_author'{/if}>
			<td><input type='hidden' name='c07_authors_id[]' value='{$item->id}' /></td>

			<td><input {$disabled} class="my_publ" id="c07_authors_me1{{"
				1"|mt_rand:1000000}}" type="checkbox" name='c07_authors_me[]'
				onclick="checkOnlyOneSelected(this);" /></td>

			<td><input {$class_req_input} required='required' type='text'
				{$readonly} name='c07_authors_lastname[]' value='{$item->last_name_rus}'
				size='30' /></td>
			<td><input {$class_req_input} required='required' type='text'
				{$readonly} name='c07_authors_firstname[]'
				value='{$item->first_name_rus}' size='2' maxlength="1" /></td>
			<td><input {$class_req_input} required='required' type='text'
				{$readonly} name='c07_authors_patrname[]'
				value='{$item->patronymic_name_rus}' size='2' maxlength="1" /></td>

			<td><textarea {$class_req_input} required='required'
				{$readonly} name='c08_place_working_authors[]' cols='45' rows='3'>{$item->organization_name_rus}</textarea></td>


			<td>{if $item@first}-{else}<a onclick="delFunct(this);">
			<button>Удалить</button>
			</a>{/if}</td>
		</tr>


		{foreachelse}
		<tr id='last_author'>
			<td></td>

			<td><input  class="my_publ" id="c07_authors_me1" type="checkbox"
				name='c07_authors_me[]' value='0'
				onclick="checkOnlyOneSelected(this);" /></td>

			<td><input {$class_req_input} required='required' type='text'
				{$readonly} name='c07_authors_lastname[]' value='' size='30' /></td>
			<td><input {$class_req_input} required='required' type='text'
				{$readonly} name='c07_authors_firstname[]' value='' size='2'
				maxlength="1" /></td>
			<td><input {$class_req_input} required='required' type='text'
				{$readonly} name='c07_authors_patrname[]' value='' size='2'
				maxlength="1" /></td>
			<td><textarea {$class_req_input} required='required'
				{$readonly} name='c08_place_working_authors[]' cols='45' rows='3'>Казахский научно-исследовательский институт онкологии и радиологии МЗ РК</textarea></td>
			<td>-</td>
		</tr>
		{/foreach}


	</tbody>
</table>
</fieldset>


