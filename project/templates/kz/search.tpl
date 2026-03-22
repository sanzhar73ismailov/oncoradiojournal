<h2 class="mb-3">Іздеу</h2>

<form class="mb-4" action="index.php" method="post">
	<input type="hidden" name="page" value="search"/>

	<div class="mb-3">
		<input class="form-control" type="text" name="search" value="{$search_text}" placeholder="Сұранысты енгізіңіз...">
	</div>

	<div class="mb-3">
		<b>Іздеу:</b><br>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="fn" value="author" {if $search_criteria eq 'author'}checked{/if}>
			<label class="form-check-label">Автор</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="fn" value="title" {if $search_criteria eq 'title'}checked{/if}>
			<label class="form-check-label">Атауы</label>
		</div>
	</div>

	<button class="btn btn-primary">Іздеу</button>
</form>

{if $search_text neq ''}
	<p>Табылған: {$publs|@count}</p>
{/if}

{foreach from=$publs item=publ name=foo}

	<div class="mb-3 p-3 border rounded">

		<div class="small text-muted">
			{$publ->year}, {$publ->issue}, №{$publ->number}, {$publ->p_first}-{$publ->p_last}
		</div>

		<div><i>{$publ->authors}</i></div>

		<div class="fw-bold">{$publ->name}</div>

		<a href="#" onclick="showAbstarct({$publ->id},'{$lang}');return false;">
			{$showAbstractLabel}
		</a>

		<div style="display:none;" id="abstract{$publ->id}">
			{$publ->abstract}
		</div>

	</div>

{/foreach}