<div class="row">

	<!-- Основной блок -->
	<div class="col-lg-8">

		<!-- Hero -->
		<div class="p-4 mb-4 bg-light rounded shadow-sm">
			<h1 class="h4 mb-3">{$text['title_journal_name']}</h1>
			<p>
				Научно-практический журнал, посвящённый проблемам онкологии и радиологии,
				основанный в 2002 году.
			</p>
			<p>
				Уважаемые читатели,
			</p>
			<p>
				Представляем вашему вниманию архив старых выпусков журнала за период с 2010 по 2017 годы. Данный ресурс позволяет ознакомиться с материалами прошлых выпусков и рефератами, которые не сохранились на современном официальном сайте.
			</p>
			<p>
				Современная версия журнала доступна по следующей ссылке:
				<a href="https://ojs.oncojournal.kz/index.php" target="_blank" rel="noopener noreferrer">https://ojs.oncojournal.kz/index.php</a>.
			</p>
			<p>
				Надеемся, что архив будет полезен исследователям, преподавателям и всем, кто интересуется публикациями журнала.
			</p>
		</div>

		<!-- Быстрые действия -->
		<div class="row g-3 mb-4">

			<div class="col-md-4">
				<a href="?page=current_issue" class="text-decoration-none">
					<div class="card h-100 text-center shadow-sm">
						<div class="card-body">
							<div class="fs-1">📖</div>
							<div>Последний номер архива</div>
						</div>
					</div>
				</a>
			</div>

			<div class="col-md-4">
				<a href="?page=archive" class="text-decoration-none">
					<div class="card h-100 text-center shadow-sm">
						<div class="card-body">
							<div class="fs-1">📚</div>
							<div>Архив</div>
						</div>
					</div>
				</a>
			</div>

			<div class="col-md-4">
				<a href="?page=search" class="text-decoration-none">
					<div class="card h-100 text-center shadow-sm">
						<div class="card-body">
							<div class="fs-1">🔍</div>
							<div>Поиск статей</div>
						</div>
					</div>
				</a>
			</div>

		</div>

		<!-- О журнале -->
		<div class="card shadow-sm mb-4">
			<div class="card-body">
				<h5>О журнале</h5>
				<p>
					Журнал является одним из ведущих научных изданий Республики Казахстан.
					Учредителем выступает {$text['kaznii_name']}.
				</p>
				<p>
					Этот сайт представляет архив выпусков журнала за 2010–2017 годы.
					Здесь доступны полные тексты статей и аннотации на казахском, русском и английском языках, которых нет на современном официальном сайте.
				</p>
				<p>
					Современная версия журнала публикуется регулярно и доступна по ссылке:
					<a href="https://ojs.oncojournal.kz/index.php" target="_blank" rel="noopener noreferrer">https://ojs.oncojournal.kz/index.php</a>.
				</p>
			</div>
		</div>

	</div>

	<!-- Сайдбар -->
	<div class="col-lg-4">

		<!-- Последний выпуск -->
		<div class="card shadow-sm mb-4">
			<div class="card-body">
				<h5>Последний выпуск</h5>
				<p class="mb-2">
					{$text['current_issue_menu']}
				</p>
				<a href="?page=current_issue" class="btn btn-primary btn-sm">
					Смотреть
				</a>
			</div>
		</div>

		<!-- Контакты -->
		<div class="card shadow-sm">
			<div class="card-body">
				<h5>Контакты</h5>
				<a href="?page=contacts" class="btn btn-outline-secondary btn-sm">
					Перейти
				</a>
			</div>
		</div>

	</div>

</div>