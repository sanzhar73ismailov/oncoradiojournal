<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="admin_style.css">
<title>{$title}</title>
</head>

<body>

<h1>{$title}</h1>

<table width="100%">
	<tr>
		<td>{include file="header.tpl"}</td>
		<tr>
			<tr>
				<td>

				<table border="1" width="1200px">
					<tr>
						<td width="200px" valign="top"><!--	lefter		 --> {include file="lefter.tpl"}</td>

						<td width="1000px">
						
						<!-- --content start---- --> 
						
						{if isset($columns)}
						<table border="1">
							<tr>
								{foreach $columns as $colname }
								<td>{$colname}</td>
								{/foreach}
							</tr>

							{foreach $rows as $row }
							<tr>
								{foreach $row as $item }
								<td>{$item}</td>
								{/foreach}
							</tr>
							{/foreach}
						</table>
						{/if}
						</td>
						
						<!-- --content end---- -->

					</tr>
				</table>


				</td>
				<tr>
					<tr>
						<td>{include file="footer.tpl"}</td>

						<tr>

</table>

</body>
</html>
