<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
	<div class="container">

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="menu">
			<ul class="navbar-nav me-auto">

				<li class="nav-item">
					<a class="nav-link {if $page == 'index'}active{/if}" href="?page=index">
						{$text['journal_menu']}
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link {if $page == 'editorial-board'}active{/if}" href="?page=editorial-board">
						{$text['editorial-board_menu']}
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link {if $page == 'current_issue'}active{/if}" href="?page=current_issue">
						{$text['current_issue_menu']}
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link {if $page == 'search'}active{/if}" href="?page=search">
						{$text['search']}
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link {if $page == 'regulations'}active{/if}" href="?page=regulations">
						{$text['regulations_menu']}
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link {if $page == 'archive'}active{/if}" href="?page=archive">
						{$text['archive_menu']}
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link {if $page == 'contacts'}active{/if}" href="?page=contacts">
						{$text['contacts_menu']}
					</a>
				</li>

			</ul>
		</div>
	</div>
</nav>