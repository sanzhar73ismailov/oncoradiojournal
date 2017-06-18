<fieldset class="fragment">
<legend>Выберите конференцию</legend>
<table class="form">



	<tr>
		
		<td>
		<b>Конференция:</b> <span id="conference_id_text"></span>
		
		<select size="10" {$class_req_input} required='required'
			{$disabled} name="conference_id" id="conference_id"
			style="width: 100%"  onclick="showFullSelectedLabe(this);">
			{foreach $conferences as $item}
			<option value="{$item->id}" {if $item->id == $object->conference_id}
			selected="selected"{/if} >{$item->value}</option>
			{/foreach}
		</select> 
		<br/>
		{if $edit}
		<input type="checkbox" id="add_conference"
			onclick="showAddAjaxForm(this);">Нет в списке, добавить<br />
         {/if}

		<div id="add_conference_place" style="display: none">

		<fieldset><legend>Новая конференция (съезд)</legend>

		<table>

			<tr>
				<td>Название конференции(семинара, симпозиума)</td>
				<td><textarea id='conference_name' name='conference_name' cols='62'
					rows='3' placeholder="например: III Международная научно-практическая конференция 'Оценка эффективности деятельности государственных органов'"
					></textarea>
			
			</tr>
			
			<tr>
				<td>Название сборника (материалов)</td>
				<td><textarea id='sbornik_name' name='sbornik_name' cols='62'
					rows='3' placeholder="например: Материалы III Международной научно-практической конференции-семинара 'Оценка эффективности деятельности государственных органов'"></textarea>
			
			</tr>
			
			<tr>
				<td>Город проведения</td>
				<td><input type="text" id="conference_сity" name="conference_сity"
					size="50" value="" /></td>
			</tr>

			<tr>
				<td>Страна проведения</td>
				<td><input type="text" id="conference_country"
					name="conference_country" size="50" value="" /></td>
			</tr>

			<tr>
				<td>Вид мероприятия</td>
				<td><select id="conference_type_id" name="conference_type_id">
					<option value="">Выбрать вариант</option>
					{foreach $conference_types as $item}
					<option value="{$item->id}">{$item->value}</option>
					{/foreach}
				</select></td>
			</tr>

			<tr>
				<td>Уроверь мероприятия</td>
				<td><select id="conference_level_id" name="conference_level_id">
					<option value="">Выбрать вариант</option>
					{foreach $conference_levels as $item}
					<option value="{$item->id}">{$item->value}</option>
					{/foreach}
				</select></td>
			</tr>

			<tr>
				<td>Дата начала (в формате дд/мм/гггг<br />
				пример: 07/02/1980)</td>
				<td><input type="text" name="conference_date_start"
					id="conference_date_start" size="50" value=""
					onblur="IsObjDate(this);" onkeyup="TempDt(event,this);" /></td>
			</tr>

			<tr>
				<td>Дата окончания (в формате дд/мм/гггг<br />
				пример: 07/02/1980)</td>
				<td><input type="text" name="conference_date_finish"
					id="conference_date_finish" size="50" value=""
					onblur="IsObjDate(this);" onkeyup="TempDt(event,this);" /></td>
			</tr>

			<tr>
				<td>Дополнительная информация</td>
				<td><textarea id='add_info' name='add_info' cols='62'
					rows='3'></textarea>
			
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' name='add_conference_button'
					id='add_conference_button' value='Сохранить'
					onclick="addByAjaxAndSelectItem(this); return false;" /></td>
			</tr>


		</table>
		</fieldset>
		</div>


		</td>
	</tr>
	
</table>
</fieldset>


