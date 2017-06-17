<div id="archive">
<h1>Archives</h1>
<table border="0" cellspace="10px" cellpadding="10px" >
<tr  style="background-color:#AABBBB;">
<th>Year</th><th>Number</th><th>Issue</th><th>Download</th><th>{$text['View']}</th>
</tr>

{foreach from=$journals item=journal}
	<tr style="background-color:#DEE;">
		<td>{$journal->year}</td>
		<td>{$journal->number}</td>
		<td>{$journal->issue}</td>
		<td><a onclick=contClick({$journal->id},'i') class="dowloadJournal" href="archive/{$journal->file}" download><img src="img/icon-pdf-small.gif" alt="{$journal->file}" title="{$text['Download']}"/></a></td>
		<td>
		{if $journal->is_filled_by_papers}<a href="index.php?page=current_issue&id={$journal->id}">{$text['content']}</a>{else}-{/if}
		</td>
	</tr>
{/foreach}
</table>


</div>