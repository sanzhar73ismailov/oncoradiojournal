<html>
<head>
<title>Info</title>
</head>
<body>
<pre>
{$title|default:"no title"}
</pre>

<pre>
User Information:

Name: {$name}
Address: {$address}
</pre>
<hr/>
<pre>
User Information:

Name: {$name|capitalize}
Addr: {$address|escape}
Date: {$smarty.now|date_format:"%b %e, %Y"}
</pre>

<select name=user>
{html_options values=$id output=$names selected="5"}
</select>

<table>
{foreach $names as $name}
{strip}
   <tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
      <td>{$name}</td>
   </tr>
{/strip}
{/foreach}
</table>

<table>
{foreach $users as $user}
{strip}
   <tr bgcolor="{cycle values="#aaaaaa,#bbbbbb"}">
      <td>{$user.name}</td>
      <td>{$user.phone}</td>
   </tr>
{/strip}
{/foreach}
</table>



</body>
</html>