<div id="archive">

<h2>{$publication->name}</h2>
{foreach from=$authors item=author name=authors_cycle}
{$author->last_name} {$author->first_name|mb_substr:0:1}.{$author->patronymic_name|mb_substr:0:1}.<sup><b>{$author->org_num}</b></sup>
{if $author->is_contact and $author->email != '' and $author->email != 'no@mail'}(<span style="color: blue">{$author->email}</span>){else}{/if} 
{if $smarty.foreach.authors_cycle.last}{else},{/if} 
{/foreach}
<p/>
{foreach from=$orgs item=org name=foo}
<b>{$smarty.foreach.foo.iteration}.</b> {$org->name}<br/> 
{/foreach}
<p/>
<b>Type:</b> {$publication->section_name}
<p/>
<b>UDK:</b> {$publication->code_udk}
<p/>
<b>Year:</b> {$issue->year} <b>issue:</b> {$issue->issue}  <b>number:</b> {$issue->number} <b>pages:</b> {$publication->p_first}-{$publication->p_last}
<p/>
<b>{$text['abstract']}:</b> {$publication->abstract}
<p/>
<b>{$text['Download']} PDF:</b> <a class="dowloadJournal" onclick=contClick({$publication->id},'p')
			href="archive/papers/{$publication->file}"
			download><img src="img/icon-pdf-small.gif"
			alt="{$publication->file}"
			title="{$text['Download']}" /></a>
<p/>
<b>Keywords:</b> {$publication->keywords}
<p/>
<b>Reference:</b>  
{foreach from=$authors item=author name=authors_cycle}
{$author->last_name|mb_substr:0:1}{($author->last_name|mb_substr:1:($author->last_name|count_characters))|lower} {$author->first_name|mb_substr:0:1}.{$author->patronymic_name|mb_substr:0:1}.
{if $smarty.foreach.authors_cycle.last}{else},{/if} 
{/foreach}
{$publication->name}. {$text['journal_name_short']},
{$issue->year}, {$issue->issue}  ({$issue->number}), {$publication->p_first}-{$publication->p_last}.
</div>
