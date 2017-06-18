<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>{$title}</title>
{include file="js_include.tpl"}
</head>
<body>
<div id="wrap">{include file="header.tpl"}



<div id="content">

<table class="table_list" id="myTable">
	<thead>
		<tr>
		<th>last_name</th>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
			<th>6</th>
			<th>7</th>
			<th>8</th>
			<th>9</th>
			<th>10</th>
			<th>11</th>
			<th>12</th>
			<th>13</th>
			<th>14</th>
			<th>15</th>
			<th>16</th>
			<th>17</th>
			<th>18</th>
			<th>19</th>
			<th>20</th>
			<th>21</th>
			<th>22</th>
			<th>23</th>
		</tr>
	</thead>
	<tbody>
		{foreach $patients as $item}

		<tr>
		<td>{$item.last_name}</td>
			<td>{if $item.id == null} - {else} + {/if}</td>
			<td>{if $item.last_name == null} - {else} + {/if}</td>
			<td>{if $item.first_name == null} - {else} + {/if}</td>
			<td>{if $item.patronymic_name == null} - {else} + {/if}</td>
			<td>{if $item.sex_id == null} - {else} + {/if}</td>
			<td>{if $item.sex == null} - {else} + {/if}</td>
			<td>{if $item.date_birth_string == null} - {else} + {/if}</td>
			<td>{if $item.year_birth == null} - {else} + {/if}</td>
			<td>{if $item.weight_kg == null} - {else} + {/if}</td>
			<td>{if $item.height_sm == null} - {else} + {/if}</td>
			<td>{if $item.prof_or_other_hazards_yes_no_id == null} - {else} +
			{/if}</td>
			<td>{if $item.prof_or_other_hazards_yes_no == null} - {else} + {/if}</td>
			<td>{if $item.prof_or_other_hazards_discr == null} - {else} + {/if}</td>
			<td>{if $item.nationality_id == null} - {else} + {/if}</td>
			<td>{if $item.nationality == null} - {else} + {/if}</td>
			<td>{if $item.smoke_yes_no_id == null} - {else} + {/if}</td>
			<td>{if $item.smoke_yes_no == null} - {else} + {/if}</td>
			<td>{if $item.smoke_discr == null} - {else} + {/if}</td>
			<td>{if $item.hospital == null} - {else} + {/if}</td>
			<td>{if $item.doctor == null} - {else} + {/if}</td>
			<td>{if $item.comments == null} - {else} + {/if}</td>
			<td>{if $item.user == null} - {else} + {/if}</td>
			<td>{if $item.insert_date == null} - {else} + {/if}</td>
		</tr>


		{/foreach}
	</tbody>
</table>



</div>



{include file="footer.tpl"}</div>
</body>
</html>
