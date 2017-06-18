
<fieldset class="fragment">
<legend>Фильтр</legend>
<table class="panel">
<tr>
		<td colspan="6" align="center"><input type="submit" name="submit"
			value="Выгрузить текущий список в файл" style="width:500px;"
			onclick="downloadFilteredList('{$type_publ}', this );"></td>
	</tr>
</table>

<table class="filter">
  
	
	<tr>
		<td>Я регистратор-автор</td>
		<td>Я просто регистратор</td>
		<td>Я просто автор</td>
		<td>Статьи других</td>

		<td rowspan="2">Найдено: {$nums_selected} из {$nums_all}</td>
	</tr>

	<tr>
		<td><input type="checkbox" id="registrator_author"
			name="registrator_author" {if $registrator_author
			eq 1} checked="checked"
			{/if}  onclick="showFilteredList('{$type_publ}', this);"></td>
		<td><input type="checkbox" id="registrator_notauthor"
			name="registrator_notauthor" {if $registrator_notauthor
			eq 1} checked="checked"
			{/if}  onclick="showFilteredList('{$type_publ}', this);"></td>
		<td><input type="checkbox" id="notregistrator_author"
			name="notregistrator_author" {if $notregistrator_author
			eq 1} checked="checked"
			{/if}  onclick="showFilteredList('{$type_publ}', this);"></td>
		<td><input type="checkbox" id="notregistrator_notauthor"
			name="notregistrator_notauthor" {if $notregistrator_notauthor
			eq 1} checked="checked"
			{/if}  onclick="showFilteredList('{$type_publ}', this);"></td>
	</tr>
</table>

<table class="panel">
	<tr>

		<td>{if $type_publ eq "all"} <span class="selected_tab">Все</span>
		{else} <a class="not_selected_tab"
			href="javascript: showFilteredList('all', this);">Все</a> {/if}</td>

		<td>{if $type_publ eq "paper"} <span class="selected_tab">Статьи</span>
		{else} <a class="not_selected_tab"
			href="javascript: showFilteredList('paper', this);">Статьи</a> {/if}</td>

		<td>{if $type_publ eq "book"} <span class="selected_tab">Книги</span>
		{else} <a class="not_selected_tab"
			href="javascript: showFilteredList('book', this);">Книги</a> {/if}</td>

		<td>{if $type_publ eq "tezis"} <span class="selected_tab">Материалы конференций</span>
		{else} <a class="not_selected_tab"
			href="javascript: showFilteredList('tezis', this);">Материалы конференций</a> {/if}</td>

		<!--<td>{if $type_publ eq "elres"} <span class="selected_tab">Электр.
		публикации</span> {else} <a class="not_selected_tab"
			href="javascript: showFilteredList('elres', this);">Электр. публикации</a>
		{/if}</td>

		-->
		<td>{if $type_publ eq "patent"} <span class="selected_tab">Охранные документы</span>
		{else} <a class="not_selected_tab"
			href="javascript: showFilteredList('patent', this);">Охранные документы</a>
		{/if}</td>

		<td>{if $type_publ eq "method_recom"} <span class="selected_tab">Метод.
		рекомендации</span> {else} <a class="not_selected_tab"
			href="javascript: showFilteredList('method_recom', this);">Метод.
		рекомендации</a> {/if}</td>


	</tr>
	
	<tr>
		<td colspan="6" align="center"><input type="submit" name="submit"
			value="Сбросить фильтр (показать всё)" style="width:500px;"
			onclick="showAllFilteredList();"></td>
	</tr>
	
</table>
</fieldset>	
	
	
	