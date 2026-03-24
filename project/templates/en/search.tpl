<h2 class="mb-3">{$text['searchPage.title']}</h2>

<form class="mb-4" action="index.php" method="post">
	<input type="hidden" name="page" value="search"/>

	<div class="mb-3">
		<input class="form-control" type="text" name="search" value="{$search_text}" placeholder="{$text['searchPage.placeholder']}">
	</div>

	<div class="mb-3">
		<b>{$text['searchPage.searchIn']}:</b><br>

		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="fn" value="author" {if $search_criteria eq 'author'}checked{/if}>
			<label class="form-check-label">{$text['searchPage.author']}</label>
		</div>

		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="fn" value="title" {if $search_criteria eq 'title'}checked{/if}>
			<label class="form-check-label">{$text['searchPage.titleField']}</label>
		</div>

		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="fn" value="abstract" {if $search_criteria eq 'abstract'}checked{/if}>
			<label class="form-check-label">{$text['searchPage.abstract']}</label>
		</div>

		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="fn" value="keywords" {if $search_criteria eq 'keywords'}checked{/if}>
			<label class="form-check-label">{$text['searchPage.keywords']}</label>
		</div>
	</div>

	<div class="mb-3">
		<b>{$text['searchPage.sorting']}:</b><br>

		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="sortby" value="asc" {if $sortby eq 'asc'}checked{/if}>
			<label class="form-check-label">{$text['searchPage.sortAsc']}</label>
		</div>

		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="sortby" value="desc" {if $sortby eq 'desc'}checked{/if}>
			<label class="form-check-label">{$text['searchPage.sortDesc']}</label>
		</div>
	</div>

	<button class="btn btn-primary">{$text['searchPage.button']}</button>
</form>

{if $search_text neq ''}
	<p>{$text['searchPage.found']}: {$publs|@count}</p>
{/if}

{foreach from=$publs item=publ}

	<div class="mb-3 p-3 border rounded shadow-sm">

		<div class="small text-muted mb-1">
			<a href="index.php?page=abstract&id={$publ->id}" target="_blank">
				{$publ->year}, {$publ->issue}, №{$publ->number}, {$publ->p_first}-{$publ->p_last}
			</a>
		</div>

		<div><i>{$publ->authors}</i></div>

		<div class="fw-bold mb-2">{$publ->name}</div>

		<div class="d-flex gap-3 flex-wrap">

			<a href="#" onclick="showAbstarct({$publ->id},'{$lang}');return false;">
				{$showAbstractLabel}
			</a>

			<a href="index.php?page=abstract&id={$publ->id}" target="_blank">
				{$text['searchPage.openPage']}
			</a>

			<a class="text-danger"
			   onclick="contClick({$publ->id},'p');"
			   href="archive/papers/{$publ->file}"
			   download>
				{$text['searchPage.downloadPdf']}
			</a>

		</div>

		<div class="mt-2" style="display:none;" id="abstract{$publ->id}">
			{$publ->abstract}
		</div>

	</div>

{/foreach}