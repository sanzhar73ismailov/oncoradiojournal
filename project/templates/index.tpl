<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="shortcut icon" href="img/2012.png" type="image/png">
<title>{$title}</title>
{*<link rel="stylesheet" type="text/css" href="css/style.css" />*}
<script type="text/javascript" src="jscript/myscript.js"></script>
<script type="text/javascript" src="jscript/jquery-1.11.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
	{include file="header.tpl"}
		
		<!--
			<span id="btl-panel-login" class="btl-modal">Войти</span>
			<span id="btl-panel-registration" class="btl-modal">Регистрация</span>
		-->
		<!-- end navigation -->

		{include file="menu.tpl"}

	    <div class="container my-4">
			{include file="$contentPage.tpl"}
		</div>

	    {include file='footer.tpl'}

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>