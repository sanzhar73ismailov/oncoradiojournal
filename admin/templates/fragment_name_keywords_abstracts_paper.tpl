<fieldset class="fragment">
<legend>УДК, ключевые слова, резюме и т.д.</legend>
<table class="form">
	<tr>
		<td>Код УДК <button onclick='document.getElementById("code_udk_id").value="-";return false;';>Удк отсутствует</button></td>
		<td><input id='code_udk_id' {$class_req_input} required='required' type='text'
			{$readonly} name='code_udk' value='{$object->code_udk}' size='40'
			placeholder="пример: 517.958" /></td>
	</tr>
	
	
	
	<tr>
		<td>На каком языке публикация?</td>
		<td><input required='required' {if $object->language=='russian'}
		checked='checked' {/if} type="radio" {$disabled} name='language'
		value="russian" />Русский &nbsp&nbsp&nbsp&nbsp&nbsp <input
			required='required' {if $object->language=='kazakh'}
		checked='checked' {/if} type="radio" {$disabled} name='language'
		value="kazakh" />Казахский &nbsp&nbsp&nbsp&nbsp&nbsp <input
			required='required' {if $object->language=='english'}
		checked='checked' {/if} type="radio" {$disabled} name='language'
		value="english" />Английский</td>
	</tr>
	{*
	<tr>
		<td>Резюме-оригинал (аннотация) на языке текста публикуемого <br />
		материала (пример: каз.)</td>
		<td><textarea {$readonly} id='abstract_original' name='abstract_original' cols='62' rows='10'>{$object->abstract_original}</textarea></td>
	</tr>
    *}

	<tr>
		<td>Резюме на казахском
		<br/>
		<input type="checkbox" id="copy_to_abstract_kaz"
				onclick="copyFromOtherInput(this);">
				<span style="font-size: small">вставить из резюме-ориганала</span>
		<textarea  {$class_req_input}
			{$readonly} id='abstract_kaz' name='abstract_kaz' cols='62' rows='10'>{$object->abstract_kaz}</textarea>
		</td>	
		<td>{$object->abstract_kaz_to_check}</td>
	</tr>

	<tr>
		<td>Резюме на русском
		<br/>
		<input type="checkbox" id="copy_to_abstract_rus"
				onclick="copyFromOtherInput(this);">
				<span style="font-size: small">вставить из резюме-ориганала</span>
		<textarea  {$class_req_input}
			{$readonly} id='abstract_rus' name='abstract_rus' cols='62' rows='10'>{$object->abstract_rus}</textarea>
			
		</td>
		<td>{$object->abstract_rus_to_check}</td>
	
	</tr>

	<tr>
		<td>Резюме на английском
		<br/>
		<input type="checkbox" id="copy_to_abstract_eng"
				onclick="copyFromOtherInput(this);">
				<span style="font-size: small">вставить из резюме-ориганала</span>
		<textarea  {$class_req_input}
			{$readonly} id='abstract_eng' name='abstract_eng' cols='62' rows='10'>{$object->abstract_eng}</textarea>
		</td>
		<td>{$object->abstract_eng_to_check}</td>
	</tr>

{*
	<tr>
		<td>Ключевые слова на языке публикуемого<br />
		материала и на русском языке (через запятую)</td>
		<td><textarea {$class_req_input} required='required'
			{$readonly} name='keywords' cols='70' rows='4'>{$object->keywords}</textarea>
		</td>
	</tr>
*}	
	<tr>
		<td colspan="2">Ключевые слова на каз. (через запятую)
		<textarea {$class_req_input} required='required'
			{$readonly} id='keywords_kaz' name='keywords_kaz' cols='80' rows='4'>{$keywords_kaz}</textarea>
		</td>
	</tr>
	
	<tr>
		<td colspan="2">Ключевые слова на рус. (через запятую)
		<textarea {$class_req_input} required='required'
			{$readonly} id='keywords_rus'  name='keywords_rus' cols='80' rows='4'>{$keywords_rus}</textarea>
		</td>
	</tr>
	
	<tr>
		<td colspan="2">Ключевые слова на анг. (через запятую)
		<textarea {$class_req_input} required='required'
			{$readonly} id='keywords_eng'  name='keywords_eng' cols='80' rows='4'>{$keywords_eng}</textarea>
		</td>
	</tr>
		
	<tr>
		<td colspan="2">Объем статьи (страницы)
		С <input {$class_req_input} required='required' type='number'
			{$readonly} min="1" name='p_first' value='{$object->p_first}'
			size='5' maxlength="5" /> страницы &nbsp&nbsp&nbsp&nbspПо <input
			{$class_req_input} required='required' type='number'
			{$readonly} min="1" name='p_last' value='{$object->p_last}' size='5'
			maxlength="5" /> страницу</td>
	</tr>
	{*
	<tr>
		<td>Укажите количество:</td>
		<td>
		<table class="included_table" border="1">
			<tr>
				<td>иллюстраций</td>
				<td>таблиц</td>
				<td>библиографических ссылок</td>
				<td>из них: на казахстанских авторов</td>
			</tr>
			<tr>
				<td><input {$class_req_input} required='required' type='number'
					{$readonly} min="0" max="30" name='number_ilustrations'
					value='{$object->number_ilustrations}' size='80' /></td>
				<td><input {$class_req_input} required='required' type='number'
					{$readonly} min="0" max="50" name='number_tables'
					value='{$object->number_tables}' size='80' /></td>
				<td><input {$class_req_input} required='required' type='number'
					{$readonly} max="100" name='number_references'
					value='{$object->number_references}' size='80' /></td>
				<td><input {$class_req_input} required='required' type='number'
					{$readonly} min="0" max="100" name='number_references_kaz'
					value='{$object->number_references_kaz}' size='80' /></td>
			</tr>
		</table>

		</td>
	</tr>
	*}
	<tr>
		<td colspan="2">Наименование файла
		<input {$class_req_input} required='required' type='text'
			{$readonly} name='file' value='{$object->file}' size='80'
			placeholder="пример: 2011-01" /></td>
	</tr>
</table>
</fieldset>


