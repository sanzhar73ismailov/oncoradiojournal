<div id="archive">

<table border="0" cellspace="10px" cellpadding="10px">
	<tr
		style="background-color: #AABBBB; font-size: 14px; text-align: center; padding: 10px;">
		<td colspan="3"><b>{$issue->year} год, выпуск {$issue->issue}, номер {$issue->number}</b></td>
	</tr>
	{foreach from=$issue->section_array item=section}
	<tr style="background-color: #DEE; text-align: center; padding: 10px;">
		<td colspan="3">{$section->name|upper}</td>
	</tr>
	{foreach from=$section->publication_array item=publ}
	<tr style="">
		<td><nobr>{$publ->p_first} - {$publ->p_last}</nobr></td>
		<td><i>{$publ->authors}</i><br />
		<a href="index.php?page=abstract&id={$publ->id}">{$publ->name}</a></td>
		<td><a class="dowloadJournal" onclick=contClick({$publ->id},'p');
			href="archive/papers/{$publ->file}"
			download><img src="img/icon-pdf-small.gif"
			alt="{$publ->file}"
			title="{$text['Download']}"/></a>
			</td>
		{/foreach} {/foreach}

</table>
</div>
