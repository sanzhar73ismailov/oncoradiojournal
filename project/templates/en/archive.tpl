<h1 class="mb-4">Archive</h1>

<div class="row g-3">

	{foreach from=$journals item=journal}

		<div class="col-md-6 col-lg-4">
			<div class="card h-100 shadow-sm">
				<div class="card-body">

					<h5>{$journal->year}</h5>
					<p class="mb-2">
						Number: {$journal->number}<br>
						Issue: {$journal->issue}
					</p>

					<a class="btn btn-sm btn-outline-danger"
					   onclick="contClick({$journal->id},'i')"
					   href="archive/{$journal->file}"
					   download>
						PDF
					</a>

					{if $journal->is_filled_by_papers}
						<a class="btn btn-sm btn-primary"
						   href="index.php?page=current_issue&id={$journal->id}">
							{$text['content']}
						</a>
					{/if}

				</div>
			</div>
		</div>

	{/foreach}

</div>