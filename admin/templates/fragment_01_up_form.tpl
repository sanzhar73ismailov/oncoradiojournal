<div class="fragment">
<table class="form">
	{if $edit}
	<tr>
		<td><input type="submit" value="Сохранить"
			style="width: 120px; height: 30px"></td>
		<td class="req_input">Обязательные поля выделены этим цветом, <br />
		без их заполнения данные не сохранятся!</td>
	</tr>
	{else} {if isset($can_edit)} {if $can_edit==1}
	<tr>
		<td><a
			href="index.php?page={$entity}&id={$object->id}&do=edit&type_publ={$type_publ}">
		<img width="20" height="20" alt="Править" src="images/edit.jpg" /></a>
		<span style="margin: 0 0 0 400px"><a href='index.php?page=publication&issue_id={$issue->id}&type_publ=paper_classik&do=edit'>Добавить публикацию в этот же номер</a></span>
		</td>

	</tr>
	{/if} {else}
	<tr>
		<td><a
			href="index.php?page={$entity}&id={$object->id}&do=edit&type_publ={$type_publ}">
		<img width="20" height="20" alt="Править" src="images/edit.jpg" /></a>
		
		</td>

	</tr>
	{/if} {/if}


	<tr>
		<td>Код записи</td>
		<td>{if $object->id} {$object->id} <input type="hidden" name="id"
			value="{$object->id}" /> {else} <input type="hidden" name="id"
			value="0" />
		<div style="background-color: #d14836">Новая запись</div>
		{/if}</td>

	</tr>
	
	

</table>
</div>
{*
<fieldset class="fragment">
<legend>Автор работы или просто регистратор?</legend>

		<input type="radio" name="coauthor" value="1" required="required" {$disabled} 
		{if isset($object->coauthor) and $object->coauthor==1}checked="checked"{/if}/>
		<b>Автор/соавтор данной работы</b>
		<br/>
		
		<input type="radio" name="coauthor" value="0" required="required" {$disabled} 
		{if isset($object->coauthor) and $object->coauthor==0}checked="checked"{/if}/>
		<b>Просто регистратор</b>

</fieldset>
*}
<input type="hidden" name="coauthor" value="0"/> 
