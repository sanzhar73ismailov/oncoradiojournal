<div id="search" style="text-align:left;width:1000px;line-height:2;">

<form action="index.php" method="post">
<input type="hidden" name="page" value="search"/>
<h3>Bibliography search</h3>
<INPUT TYPE=TEXT  SIZE="100" NAME="search" style="border-style:solid;" VALUE="{$search_text}"> <br/>

<table>
<tr><td>

<b>Search by:</b> 
<input type="radio" required name="fn" value="author" {if $search_criteria eq 'author'}checked{/if}>author's name &nbsp;
<input type="radio" required name="fn" value="title" {if $search_criteria eq 'title'}checked{/if}>title &nbsp;
<input type="radio" required name="fn" value="abstract" {if $search_criteria eq 'abstract'}checked{/if}>abstract(any language)
<nobr><input type="radio" required name="fn" value="keywords" {if $search_criteria eq 'keywords'}checked{/if}>keywords</nobr><Br/>

</td></tr>
<tr><td>
<b>Sorting:</b> 
<input type="radio" required name="sortby" value="asc" {if $sortby eq 'asc'}checked{/if}>newest first &nbsp;
<input type="radio" required name="sortby" value="desc" {if $sortby eq 'desc'}checked{/if}>oldest first &nbsp;
</td></tr>
</table>

<INPUT TYPE=SUBMIT style="width:60px;height:23px;background-color:#DDD;border-style:solid;" VALUE="Search"> 
</form>


{if $search_text neq ''}Found : {$publs|@count}{/if}

<table border="0" cellspace="10px" cellpadding="10px" style="font-size: 14px;">
	{foreach from=$publs item=publ name=foo}
	<tr style="background-color: #DEE; text-align: center; padding: 10px;">
		<td><nobr>{$smarty.foreach.foo.iteration}</nobr></td>
		<td style="text-align: left; padding: 10px;">
		<i>{$publ->authors}</i><br/>{$publ->name}
		<br/>
		<a href="" id="showAbstract{$publ->id}" onclick="showAbstarct({$publ->id},'{$lang}');return false;">{$showAbstractLabel} >></a>
		<div style="display:none; background-color: #EFF6FE;" id="abstract{$publ->id}">{$publ->abstract}</div>
		</td>
        <td><a href="index.php?page=abstract&id={$publ->id}" target="_blank"><nobr>{$publ->year}, {$publ->issue}, №{$publ->number}, {$publ->p_first}-{$publ->p_last}</nobr></a></td>
		<td><a class="dowloadJournal" onclick=contClick({$publ->id},'p');
			href="archive/papers/{$publ->file}"
			download><img src="img/icon-pdf-small.gif"
			alt="{$publ->file}"
			title="{$text['Download']}"/></a>
			</td>
	{/foreach}

</table>
</div>