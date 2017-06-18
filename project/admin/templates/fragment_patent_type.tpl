<fieldset class="fragment">
<legend>Вид охранного документа</legend>
<table class="form">
	
	
		<tr>
			<td valign="top">Выберите тип документа</td>
			<td><select size="10" {$class_req_input} required='required'
				{$disabled} name="patent_type_id" id="patent_type_id" style="width: 500px">
				{foreach $patent_types as $item}
				<option value="{$item->id}" {if $item->id == $object->patent_type_id}
				selected="selected"{/if} >{$item->value}</option>
				{/foreach}
			</select> 
			{if $edit}
			<input type="checkbox" id="add_patent_type"
				onclick="showAddAjaxForm(this);">Нет в списке, добавить<br />
             {/if}

			<div id="add_patent_type_place" style="display: none">

			<fieldset><legend>Новый вид охранного документа</legend>

			<table>
				<tr>
					<td>Наименование</td>
					<td><input type='text' name='patent_type' id='patent_type'
						value='' size='80' /></td>
				</tr>

				<tr>
					<td></td>
					<td><input type='submit' name='' id='add_patent_type_button'
						value='Сохранить'
						onclick="addByAjaxAndSelectItem(this); return false;" /></td>
				</tr>



			</table>
			</fieldset>
			</div>
			</td>
		</tr>

</table>
</fieldset>


