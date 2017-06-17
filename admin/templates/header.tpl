<div id="header">
<h1 align="center">{$application_name}</h1>
<div style="float:right; margin: -40px 20px 20px 0px;">
{if isset($user)}
Вы зашли как: {$user.last_name} {$user.first_name} ({$user.role})
{/if}
</div>
<p />

{if $authorized==1}

{/if}

<table border="1">
	<tr>
	{if $authorized==1}
		<td><a href="index.php"><button>На главную страницу</button></a></td>
		<td>
		<a href="index.php?page=listPublications"><button class="button_on_index">Список публикаций</button></a><br/>
		<a href="index.php?page=listAuthors"><button class="button_on_index">Список авторов</button></a><br/>
		<a href="index.php?page=listOrganizations"><button class="button_on_index">Список организаций</button></a><br/>
		<a href="index.php?page=listIssues"><button class="button_on_index">Список номеров журнала</button></a><br/>
		<a href="index.php?page=listSections"><button class="button_on_index">Список секций</button></a><br/>
		</td>
		<td>
		{*
		<a href="index.php?page=add_publication">
		<button class="button_on_index" style="background-color :#597de8;">
		           Добавить публикацию
		</button>
		</a>
		*}
		{* <a href="index.php?page=add_publication_authors_organizations"><button class="button_on_index" style="background-color :#597de8;">Добавить публикацию</button></a><br/> *}
		<a href="index.php?page=listIssues"><button class="button_on_index" style="background-color :#597de8;">Добавить публикацию</button></a><br/>
		</td>
		<td>
		<a href="index.php?page=author&do=edit"><button class="button_on_index">Добавить автора</button></a><br/>
		<a href="index.php?page=organization&do=edit"><button class="button_on_index">Добавить организацию</button></a>
		<a href="index.php?page=issue&do=edit"><button class="button_on_index">Добавить номер</button></a>
		<a href="index.php?page=section&do=edit"><button class="button_on_index">Добавить секцию</button></a>
		</td>
		
		<td>
		</td>

	{else}
	<td><a href="index.php?page=register"><button>Регистрация</button></a></td>
		<td><a href="index.php?page=login"><button>Войти</button></a></td>
	{/if}	

		
		
		<td><a href="index.php?page=contacts"><button>Контакты</button></a></td>
		<td><a href="index.php?page=feedback"><button>Обратная связь</button></a></td>
		
	{if $authorized}
		<td><a href="index.php?page=logout"><button>Выход</button></a></td>
	{/if}	
	

	</tr>
</table>

</div>

