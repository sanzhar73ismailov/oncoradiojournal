<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>{$title}</title>
{include file="js_include.tpl"} 
{if isset($generate_script) }
{$generate_script} {/if}
<script src="jscript/publForm.js"></script>

</head>
<body>


<div id="wrap">{include file="header.tpl"}



<div id="content">
<div class="center_title">{$title}</div>

{include file="fragment_message.tpl"}

<form method="post" action="index.php" onsubmit="return checkform(this)">

{include file="fragment_hidden_input.tpl"}

{include file="fragment_01_up_form.tpl"}

{include file="fragment_electron_url_doi.tpl"}

{include file="fragment_name_universal.tpl"}

{include file="fragment_patent_type.tpl"}

{include file="fragment_patent_name_number_date.tpl"}

{include file="fragment_authors.tpl"}

{include file="fragment_02_down_form.tpl"}

</form>


</div>

{include file="footer.tpl"}</div>

</body>
</html>
