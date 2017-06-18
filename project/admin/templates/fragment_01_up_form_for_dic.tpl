<div class="fragment">
<table class="form">
	{if $edit}
	<tr>
		<td><input type="submit" value="Сохранить"
			style="width: 120px; height: 30px"></td>
		<td class="req_input">Обязательные поля выделены этим цветом, <br />
		без их заполнения данные не сохранятся!</td>
	</tr>
	{else}
	
	{*$entity*}
	{* <h3>{$object->id|default:"no object->id"}</h3> *}
	{*$type_publ*}
		
	 
	
	{if isset($can_edit)} 
	{if $can_edit==1}
	<tr>
		<td><a href="index.php?page={$entity}&id={$object->id}&do=edit"><img width="20" height="20" alt="Править" src="images/edit.jpg" /></a></td>
	</tr>
	{/if} 
	
	{else}
	<tr>
		<td>can_edit==0<a
			href="index.php?page={$entity}&id={$object->id}&do=edit">
		<img width="20" height="20" alt="Править" src="images/edit.jpg" /></a></td>

	</tr>
	
	{/if}
	
	{/if}
	
	<tr>
		<td>Код записи</td>
		<td>{if $object->id} <span style='font-size: 1.17em;font-weight: 600;'>{$object->id}</span> <input type="hidden" name="id"
			value="{$object->id}" /> {else} <input type="hidden" name="id"
			value="0" />
		<div style="background-color: #d14836">Новая запись</div>
		{/if}</td>

	</tr>
	
	

</table>
</div>

