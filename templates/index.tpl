<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="shortcut icon" href="img/2012.png" type="image/png">
<title>{$title}</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="jscript/myscript.js"></script>
<script type="text/javascript" src="jscript/jquery-1.11.0.min.js"></script>
</head>
<body>
	<div id="container">
	{include file="header.tpl"}
		
		<div id="navigation">
		<div id="nabigButtons">
		<!--  
			<span id="btl-panel-login" class="btl-modal">Войти</span>
			<span id="btl-panel-registration" class="btl-modal">Регистрация</span>
		-->
		</div>
		</div>
		<!-- end navigation -->

		{include file="menu.tpl"}
		
		<div id="content">
			{include file="$contentPage.tpl"}

		</div>
		<div id="clear"></div>
		<!-- end content -->
		{include file='footer.tpl'}
		</div>
	<!-- end container -->
</body>
</html>