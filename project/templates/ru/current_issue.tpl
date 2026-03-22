<h2 class="mb-4">
	{$issue->year} — выпуск {$issue->issue} (№{$issue->number})
</h2>

{foreach from=$issue->section_array item=section}

	<h4 class="mt-4 border-bottom pb-2">{$section->name}</h4>

	{foreach from=$section->publication_array item=publ}

		<div class="mb-3 p-3 border rounded">

			<div class="small text-muted">
				{$publ->p_first}–{$publ->p_last}
			</div>

			<div><i>{$publ->authors}</i></div>

			<div class="fw-bold">
				<a href="index.php?page=abstract&id={$publ->id}">
					{$publ->name}
				</a>
			</div>

			<a class="btn btn-sm btn-outline-danger mt-2"
			   onclick="contClick({$publ->id},'p')"
			   href="archive/papers/{$publ->file}"
			   download>
				PDF
			</a>

		</div>

	{/foreach}
{/foreach}