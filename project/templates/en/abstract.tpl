<div class="card shadow-sm">
	<div class="card-body">

		<h2 class="mb-3">{$publication->name}</h2>

		<!-- Authors -->
		<p class="mb-2">
			{foreach from=$authors item=author name=authors_cycle}
				{$author->last_name} {$author->first_name|mb_substr:0:1}.{$author->patronymic_name|mb_substr:0:1}.
				<sup>{$author->org_num}</sup>
				{if $author->is_contact and $author->email != '' and $author->email != 'no@mail'}
					(<a href="mailto:{$author->email}">{$author->email}</a>)
				{/if}
				{if !$smarty.foreach.authors_cycle.last}, {/if}
			{/foreach}
		</p>

		<!-- Organizations -->
		<p class="text-muted small">
			{foreach from=$orgs item=org name=foo}
		<div><b>{$smarty.foreach.foo.iteration}.</b> {$org->name}</div>
		{/foreach}
		</p>

		<hr>

		<!-- Metadata -->
		<div class="row mb-3">
			<div class="col-md-6">
				<b>Type:</b> {$publication->section_name}<br>
				<b>UDC:</b> {$publication->code_udk}
			</div>
			<div class="col-md-6">
				<b>Year:</b> {$issue->year}<br>
				<b>Issue:</b> {$issue->issue} ({$issue->number})<br>
				<b>Pages:</b> {$publication->p_first}-{$publication->p_last}
			</div>
		</div>

		<!-- Abstract -->
		<h5>{$text['abstract']}</h5>
		<p>{$publication->abstract}</p>

		<!-- PDF -->
		<a class="btn btn-danger mb-3"
		   onclick="contClick({$publication->id},'p')"
		   href="archive/papers/{$publication->file}"
		   download>
			📄 {$text['Download']} PDF
		</a>

		<!-- Keywords -->
		<p><b>{$text['keywords']}:</b> {$publication->keywords}</p>

		<!-- Citation -->
		<div class="mt-3 p-3 bg-light border rounded small">
			<b>{$text['Citation']}:</b><br>
			{foreach from=$authors item=author name=authors_cycle}
				{$author->last_name|mb_substr:0:1}{($author->last_name|mb_substr:1:($author->last_name|count_characters))|lower}
				{$author->first_name|mb_substr:0:1}.{$author->patronymic_name|mb_substr:0:1}.
				{if !$smarty.foreach.authors_cycle.last}, {/if}
			{/foreach}
			{$publication->name}. {$text['journal_name_short']},
			{$issue->year}, {$issue->issue} ({$issue->number}), {$publication->p_first}-{$publication->p_last}.
		</div>

	</div>
</div>