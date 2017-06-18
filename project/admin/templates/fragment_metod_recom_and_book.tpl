<fieldset class="fragment">
<legend>Город, год и т.д. </legend>
<table class="form">
		<!--<tr>
		<td>Название</td>
		<td><textarea {$class_req_input} required='required'
			{$readonly} name='name' cols='62' rows='3'>{$object->name}</textarea>
	
	</tr>
	

	--><tr>
		<td>Город</td>
		<td><input {$class_req_input} required='required' type="text"
			{$readonly} name="book_city" size="50"
			value="{$object->book_city}" /></td>
	</tr>

	<tr>
		<td>Количество страниц</td>
		<td><input {$class_req_input} required='required' type="number" min = "1"
			{$readonly} name="book_pages" size="50"
			value="{$object->book_pages}" /></td>
	</tr>
	
	<tr>
		<td>Издательство</td>
		<td><input  type="text"
			{$readonly} name="izdatelstvo" size="50"
			value="{$object->izdatelstvo}" /></td>
	</tr>
	
	
<tr>
		<td>Год издания</td>
		<td><input {$class_req_input} required='required' type="number" min = "1945"
			{$readonly} name="year" size="50"
			value="{$object->year}" /></td>
	</tr>

<tr>
		<td>Удк</td>
		<td><input {$class_req_input} required='required' type="text" 
			{$readonly} name="code_udk" size="50"
			value="{$object->code_udk}" /></td>
	</tr>

<tr>
		<td>ББК</td>
		<td><input {$class_req_input} required='required' type="text" 
			{$readonly} name="method_recom_bbk" size="50"
			value="{$object->method_recom_bbk}" /></td>
	</tr>

<tr>
		<td>ISBN</td>
		<td><input type="text" 
			{$readonly} name="isbn" size="50"
			value="{$object->isbn}" /></td>
	</tr>

<tr>
		<td>Под редакцией</td>
		<td><input type="text" 
			{$readonly} name="method_recom_edited" size="50"
			value="{$object->method_recom_edited}" /></td>
	</tr>

<tr>
		<td>Утвержден(а/ы) ...(например, утвержден(а/ы) на Ученом Совете Казахского НИИ онкологии и радиологии, протокол №14 от 6 декабря 2012г.)</td>
			<td><textarea {$class} 
			{$readonly} name='method_recom_stated' cols='62' rows='3'>{$object->method_recom_stated}</textarea>
			</td>
	</tr>
	
<tr>
		<td>Одобрен(а/ы) ...(например, одобрен(а/ы) Экспертным Советом по вопросам развития здравоохранения МЗ РК, протокол №21 от 14 декабря 2012 года.)</td>
			<td><textarea {$class} 
			{$readonly} name='method_recom_approved' cols='62' rows='3'>{$object->method_recom_approved}</textarea>
			</td>
	</tr>

<tr>
		<td>Издано при поддержке ...(например, распечатано при поддержке ТОО 'Юмгискор Холдинг' или изданы при поддержке Представительства АО 'Берлин-Хеми АГ' в РК)</td>
			<td><textarea {$class} 
			{$readonly} name='method_recom_published_with_the_support' cols='62' rows='3'>{$object->method_recom_published_with_the_support}</textarea>
			</td>
	</tr>
	
	<tr>
		<td>Краткая аннотация и для кого предназначено</td>
			<td><textarea {$class_req_input} required='required'
			{$readonly} name='abstract_original' cols='62' rows='3'>{$object->abstract_original}</textarea>
			</td>
	</tr>
	
	<tr>
		<td>Рецензенты</td>
		<td><textarea {$class_req_input} required='required'
			{$readonly} name='method_recom_reviewers' cols='62' rows='3'>{$object->method_recom_reviewers}</textarea>
			</td>
	
<tr>
		<td>Количество таблиц</td>
		<td><input {$class_req_input} required='required' type="number" min = "0"
			{$readonly} name="number_tables" size="50"
			value="{$object->number_tables}" /></td>
	</tr>
	
	<tr>
		<td>Количество иллюстраций</td>
		<td><input {$class_req_input} required='required' type="number" min = "0"
			{$readonly} name="number_ilustrations" size="50"
			value="{$object->number_ilustrations}" /></td>
	</tr>

</table>
</fieldset>



