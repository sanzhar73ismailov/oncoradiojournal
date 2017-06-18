<fieldset class="fragment">
<legend>Список библиографических ссылок на казахстанских авторов</legend>

<fieldset><legend>Пример:</legend> <input type="checkbox" id="raz"
	class="del" /><label for="raz" class="del">Показать/Скрыть пример</label>
<div>
<table>

	<tr>
		<td>Статья из периодического издания:</td>
		<td>1. Аксартов Р. М., Айзиков М. И., Расулова С. А. Метод
		количественного определения леукомизина // Вестн. КазНУ. Сер. хим –
		2003. – Т. 1. № 8. - С. 40-41</td>
	</tr>

	<tr>
		<td>Книга:</td>
		<td>2. Курмуков А. А. Ангиопротекторная и гиполипидемическая
		активность леуомизина. – Алматы: Бастау, 2007. – С. 35-37</td>
	</tr>

	<tr>
		<td>Публикация из материалов конференции<br />
		(семинара, симпозиума), сборников трудов:</td>
		<td>3. Абимульдина С. Т., Сыдыкова Г. Е., Оразбаева Л. А.
		Функционирование и развитие инфраструктуры сахарного производства //
		Инновация в аграрном секторе Казахстана: Матер. Междунар. конф., Вена,
		Австрия, 2009. – Алматы, 2010. – С. 10-13</td>
	</tr>

	<tr>
		<td>Электронный ресурс:</td>
		<td>4. Соколовский Д. В. Теория синтеза самоустанавливающихся
		кулачковых механизмов приводов [Электрон. ресурс]. – 2006. – URL:
		http://bookchamber.kz/stst_2006.htm (дата обращения: 12.03.2009</td>
	</tr>
</table>
</div>
</fieldset>

<table class="form">
	<tr>
		<th>Тип публикации</th>

		<th>Название</th>

		<th>
		{if $edit}
		<a onclick="addItem('last_reference'); return false;">
		<button>Добавить ссылку</button>
		</a>
		{/if}
		</th>
	</tr>

	{foreach $object->references_array as $ref_item}
	<tr {if $ref_item@last}id='last_reference'{/if}>

		<td><input type='hidden' name='c19_list_references_id[]'
			value='{$ref_item->id}' /> <select
			{$class} {$disabled} name="reference_kaz_type_id[]"
			style="width: 300px">
			{foreach $types as $item}
			<option {if $item->id == $ref_item->type_id} selected="selected"
			{/if} value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>

		<td><textarea {$class_req_input} required='required'
			{$readonly} name='c19_list_references_kazakh[]' cols='60' rows='3'> {$ref_item->name}</textarea>
		</td>
		<td>{if $ref_item@first}-{else}<a onclick="delFunct(this);">
		<button>Удалить</button>
		</a>{/if}</td>

	</tr>
	{foreachelse}
	<tr id='last_reference'>
		<td><select {$class} {$disabled} name="reference_kaz_type_id[]"
			style="width: 300px">
			{foreach $types as $item}
			<option value="{$item->id}">{$item->value}</option>
			{/foreach}
		</select></td>

		<td><textarea {$readonly} name='c19_list_references_kazakh[]'
			cols='60' rows='3'></textarea></td>
		<td>-</td>

	</tr>
	{/foreach}


</table>
</fieldset>


