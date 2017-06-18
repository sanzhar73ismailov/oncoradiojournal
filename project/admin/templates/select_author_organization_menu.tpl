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
<div class="center_title">{$title}</div>
<div class="center_small_title">Номер журнала: Год {$issue->year}, номер {$issue->number}, выпуск {$issue->issue} </div>
<form method="get" action="index.php" onsubmit="return checkSelectAuthorsOrgForm(this)">
<input type="hidden" name="page" value="publication">
<input type="hidden" name="do" value="edit">
<input type="hidden" name="type_publ" value="paper_classik"/>
<input type="hidden" name="issue_id" value="{$issue->id}"/>
{* <input type="text" name="authors_orgs" value=""/> *}

<table class="table_on_publ_add">

	<tbody>
<tr>
			<td valign="top">Выберите раздел</td>
			<td>
			
			<select size="10"  required='required'
				name="section_id" id="section_id" style="width: 500px">
				{foreach $sections as $item}
				<option value="{$item->id}" 
				{if $item->id == $object->section_id} selected="selected" {/if}> 
				{$item->name_rus}</option>
				{/foreach}
			</select>
			</td>
</tr>
	
<tr>
<td>Добавление авторов и организаций</td>
<td>
	<table>
		<tr>
			<td valign="top">Выберите автора
						
						<select size="10"
							name="author_id" id="author_id" style="width: 200px">
							{foreach $authors as $item}
							<option value="{$item->id}" 
							{* {if $item->id == $object->journal_id} *}
							{if $item->id == 12313123}selected="selected"{/if}> 
							
							{$item->last_name_rus} {$item->first_name_rus} {$item->patronymic_name_rus}</option>
							{/foreach}
						</select>
			</td>
			<td valign="top">Выберите организацию
						<select size="10"
							name="organization_id" id="organization_id" style="width: 500px">
							{foreach $organizations as $item}
							<option value="{$item->id}" 
							{* {if $item->id == $object->journal_id} *}
							{if $item->id == 12313123}selected="selected"{/if}> 
							
							{$item->name_rus} {$item->name_rus}</option>
							{/foreach}
						</select>
						
						</td>
<tr><td>-</td><td><button  style="width: 300px" name='add_but' onclick='return selectAuthorAndOrg();'>Добавить в список</button></td></tr>				
<tr><td>-</td><td><button  style="width: 300px" name='add_but' onclick='return selectAuthorAndKazniiOrg();'>Добавить в список как автора изКазНИИ ОиР</button></td></tr>		
		</tr>
	</table>
</td>
</tr>



	<tr>
			<td valign="top">Выбранные</td>
			<td style='border:solid 1px; border-color: #008a77;padding: 5px;'>
			<div id='selected' >
			{foreach $object->authors_array as $item}
							<div id="{$item->author_id}^{$item->organization_id}" style="border: 1px dotted rgb(0, 0, 255);">АВТОР: {$item->author_name} 
							ОРГАНИЗАЦИЯ:{$item->organization_name} 
							<input name="authors_orgs[]" type="hidden" value="{$item->author_id}^{$item->organization_id}">
							<button class="button_authors" value="{$item->author_id}^{$item->organization_id}" onclick="delThisDiv(this);">Удалить</button><br></div>
			{/foreach}
			</div>
			</td>
	</tr>	

		<tr>
			<td valign="top" colspan="3">
			<button style="width: 100px">Далее</button>
			</td>
		</tr>





	</tbody>
</table>
</form>

{include file="footer.tpl"}</div>

<script>
function delThisDiv(obj){
	//var placeForAdd = document.getElementById('selected');
	var divToBeDeleted = document.getElementById(obj.value);
	divToBeDeleted.remove();
	//divToBeDeleted.

}

/**
функция проверяет наличие такого автора в списке выбранных
*/
function checkIfAuthorAlreadyExist(autId){
	var buttonAuthorsElemnts = document.getElementsByClassName("button_authors");
	console.log("----------");
	
	for(var i = 0; i < buttonAuthorsElemnts.length; i++){
		
		console.log(i+") buttonAuthorsElemnts"+buttonAuthorsElemnts[i].value);
		var autIdOfElement = buttonAuthorsElemnts[i].value.split("^")[0];
		if(autId == autIdOfElement){
			return true;
		}
	}
	return false;
}

function selectAuthorAndOrg(){
		var orgElement = document.getElementById('organization_id');
		return selectAuthorAndOrgByElement(orgElement);
}

function selectAuthorAndKazniiOrg(){
		var orgElement = document.getElementById('organization_id');
		var orgId = 1;
		for(var i=0; i < orgElement.options.length; i++){
			if(orgElement.options[i].value == orgId){
				orgElement.selectedIndex = i;
				break;
			}
		}
		return selectAuthorAndOrgByElement(orgElement);
}

function selectAuthorAndOrgByElement(orgElement){
 try {
	    var placeForAdd = document.getElementById('selected');
		var authorElement = document.getElementById('author_id');
		
		if(authorElement.selectedIndex == -1 || orgElement.selectedIndex == -1){
			throw "Необходимо выбрать автора и организацию!";
		}
		
		var orgId = orgElement.options[orgElement.selectedIndex].value;
		var orgLabel = orgElement.options[orgElement.selectedIndex].text;
		
		var authId = authorElement.options[authorElement.selectedIndex].value;
		var authLabel = authorElement.options[authorElement.selectedIndex].text;
		
		if(checkIfAuthorAlreadyExist(authId)){
			throw "Такой автор уже существует в списке выбранных";
		}
		
		var authIdAndOrgId = authId + "^" + orgId;
		
		var divToBeAdded = document.createElement("div");
		divToBeAdded.setAttribute("id", authIdAndOrgId);
		
		placeForAdd.appendChild(divToBeAdded);
		divToBeAdded.appendChild(document.createTextNode("АВТОР: " + authLabel + "" + ". ОРГАНИЗАЦИЯ: " + orgLabel));
		
		var inputHidden = document.createElement("input");
		inputHidden.setAttribute("name","authors_orgs[]");
		inputHidden.setAttribute("type","hidden");
		inputHidden.value = authIdAndOrgId;
		
		divToBeAdded.appendChild(inputHidden);
		divToBeAdded.style.border = "1px dotted #0000FF";
		
		var deleteBut = document.createElement("button");
		deleteBut.setAttribute("class","button_authors");
		deleteBut.appendChild(document.createTextNode("Удалить"));
		deleteBut.value = authIdAndOrgId;
		deleteBut.setAttribute("onclick", "delThisDiv(this);");
		
		divToBeAdded.appendChild(deleteBut);
		divToBeAdded.appendChild(document.createElement("br"));
    	orgElement.selectedIndex = -1;
} catch (e) {
  	alert(e);
 }
	return false;
}

</script>
</body>
</html>
