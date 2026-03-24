<div class="container py-3 border-bottom">

	<div class="row align-items-center">

		<!-- Логотип -->
		<div class="col-md-2 text-center text-md-start mb-2 mb-md-0">
			<img src="img/2012.jpg" class="img-fluid" style="max-height:120px;">
		</div>

		<!-- Заголовок -->
		<div class="col-md-7 text-center text-md-start">
			<h1 class="h4 mb-1">{$text['title_journal_name']}</h1>
			<div class="text-muted small">
				{$text['created_in_year']}<br>
			</div>
			<div class="text-muted small">
				ISSN: 1684-93X | {$text['journal.periodicity']}
			</div>
		</div>



		<!-- Языки -->
		<div class="col-md-3 text-center text-md-end">
			{if $lang == 'kz'}
				<span class="fw-bold">КАЗ</span>
			{else}
				<a href="?page={$page}&id={$id}&language=kaz">КАЗ</a>
			{/if}
			|
			{if $lang == 'ru'}
				<span class="fw-bold">РУС</span>
			{else}
				<a href="?page={$page}&id={$id}&language=rus">РУС</a>
			{/if}
			|
			{if $lang == 'en'}
				<span class="fw-bold">ENG</span>
			{else}
				<a href="?page={$page}&id={$id}&language=eng">ENG</a>
			{/if}
		</div>

	</div>

	{if $statistics_on == 0}
		<div class="alert alert-warning mt-2 p-2 small">
			statistics off | include_metrica: {$include_metrica} | server: {$server_name}
		</div>
	{/if}

</div>