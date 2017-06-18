<fieldset class="fragment">
<legend>Журнал</legend>
<table class="form">
	
	<input type="hidden" name="journal_id" value="5"/>
	{*
		<tr>
			<td valign="top">Выберите журнал</td>
			<td><select size="10" {$class_req_input} required='required'
				{$disabled} name="journal_id" id="journal_id" style="width: 500px">
				{foreach $journals as $item}
				<option value="{$item->id}" {if $item->id == $object->journal_id}
				selected="selected"{/if} >{$item->value}</option>
				{/foreach}
			</select> 
			{if $edit}
			<input type="checkbox" id="add_journal"
				onclick="showAddAjaxForm(this);">Нет в списке, добавить<br />
             {/if}

			<div id="add_journal_place" style="display: none">

				<fieldset><legend>Новый журнал</legend>
	
					<table>
						<tr>
							<td>Страна издания журнала</td>
							<td><input type='text' name='j_country' id='j_country'
								value='Казахстан' size='80' /></td>
						</tr>
		
						<tr>
							<td>ISSN</td>
							<td><input type='text' name='j_issn' id='j_issn' value='' size='80' /></td>
						</tr>
		
						<tr>
							<td>Полное наименование журнала</td>
							<td><textarea name='j_name' id='j_name' cols='62' rows='2'></textarea><br />
							</td>
						</tr>
		
						<tr>
							<td>Периодичность выхода журнала</td>
							<td><input type='text' min="1" max="12" name='j_periodicity'
								id='j_periodicity' value='' size='80' /></td>
						</tr>
		
						<tr>
							<td>Издательство, место издания журнала</td>
							<td><input type='text' name='j_izdatelstvo_mesto_izdaniya'
								id='j_izdatelstvo_mesto_izdaniya' value='' size='80'
								placeholder="напр. Алматы: Қазақ университеті" /></td>
						</tr>
		
						<tr>
							<td></td>
							<td><input type='submit' name='' id='add_journal_button'
								value='Сохранить'
								onclick="addByAjaxAndSelectItem(this); return false;" /></td>
						</tr>
		
		
		
					</table>
				</fieldset>
			</div>
			</td>
		</tr>
*}
	<tr>
			<td><b>Год, номер, том, выпуск издания</b></td>
			<td>


			<table class="included_table" border="1">
				<tr>
					<td>год</td>
					<td>номер</td>
					<td>том</td>
					<td>выпуск издания</td>
				</tr>
				<tr>
					<td><input {$class_req_input} required='required' type='number'
						{$readonly} min="2011" max="2017" name='year'
						value='{$object->year}' size='80' maxlength="4" placeholder="Год" /></td>
					<td><input {$class_req_input} required='required' type='number'
						{$readonly} min="1" name='number' value='{$object->number}'
						size='80' maxlength="3" placeholder="Номер" /></td>
					<td><input type='number' {$readonly} min="1" name='volume'
						value='{$object->volume}' size='80' maxlength="3"
						placeholder="Том издания" /></td>
					<td><input {$class_req_input} required='required' type='number'
						min="1" name='issue' value='{$object->issue}' size='80'
						maxlength="3" placeholder="Выпуск издания" /></td>
				</tr>
			</table>


			</td>
		</tr>

</table>
</fieldset>


