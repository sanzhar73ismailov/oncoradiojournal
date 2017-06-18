<div id="menu">
			<ul class="menu">
				<li {if $page == 'index'}class="currentActive"{/if}><a class="menuLink" href="?page=index">{$text['journal_menu']}</a></li>
				<li {if $page == 'editorial-board'}class="currentActive"{/if}><a class="menuLink" href="?page=editorial-board">{$text['editorial-board_menu']}</a></li>
				<li {if $page == 'current_issue'}class="currentActive"{/if}><a class="menuLink" href="?page=current_issue">{$text['current_issue_menu']}</a></li>
				<li {if $page == 'search'}class="currentActive"{/if}><a class="menuLink" href="?page=search">{$text['search']}</a></li>
				<li {if $page == 'regulations'}class="currentActive"{/if}><a class="menuLink" href="?page=regulations">{$text['regulations_menu']}</a></li>
				<li {if $page == 'archive'}class="currentActive"{/if}><a class="menuLink" href="?page=archive">{$text['archive_menu']}</a></li>
				<li {if $page == 'contacts'}class="currentActive"{/if}><a class="menuLink" href="?page=contacts">{$text['contacts_menu']}</a></li>

				<!--<li class="item-106"><a href="/index.php/ru/subscription">Подписка</a></li>-->
				<!--<li class="item-108"><a href="/index.php/ru/issues">Текущий	номер</a></li>-->
				<!--<li class="item-110"><a href="/index.php/ru/indexing">Индексирование</a></li>-->
				<!--<li class="item-121"><a href="/index.php/ru/search">Поиск</a></li>-->
				<!--<li class="item-127"><a href="/index.php/ru/submission">Авторский раздел</a></li>-->
			</ul>
		</div>
<!-- end menu -->