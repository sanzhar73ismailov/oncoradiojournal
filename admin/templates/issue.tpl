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
<script>
function add_section(thisObj){
	var sectionsInput = document.getElementById('sections_id');
	
	var separatorForId = ",";
	var separatorOrEmpty = sectionsInput.value != "" ? separatorForId : "";
	
	

	if(thisObj.checked) {
    	sectionsInput.value = sectionsInput.value + separatorOrEmpty + thisObj.value;
    } else {
    	var arr = sectionsInput.value.split(separatorForId);
    	var index = arr.indexOf(thisObj.value);
    	arr.splice(index,1);
    	sectionsInput.value = arr.join();
    	
    } 
   
   
   
    var label =  thisObj.id.split("^")[1];
   	//var label = "" . nameText  . "</div>";
    var divOfLabels = document.getElementById('selected_sections');
    var textDivOfLabels = divOfLabels.innerHTML;
    var separatorForLabels = "|";  
    separatorOrEmpty = textDivOfLabels != "" ? separatorForLabels : "";
     
    if(thisObj.checked) {
       textDivOfLabels = textDivOfLabels + separatorOrEmpty + label;
    } else {
    	var arrLabels = textDivOfLabels.split(separatorForLabels);
    	var index = arrLabels.indexOf(label);
    	arrLabels.splice(index,1);
    	textDivOfLabels = arrLabels.join(separatorForLabels);
    	
    } 
    divOfLabels.innerHTML = textDivOfLabels;
     console.log("thisObj.checked:" + thisObj.checked);
 }
 
 function clearSections(){
	 try{
		document.getElementById('selected_sections').innerHTML = "";
		document.getElementById('sections_id').value="";
	    var chkbs = document.getElementsByClassName('checkboxes');
		for (var i = 0; i < chkbs.length; ++i) {
		    chkbs[i].checked = false;
		}
	}catch(e){
	  alert(e.message);
	}	
 }
</script>
</head>
<body>


<div id="wrap">{include file="header.tpl"}

<div id="content">
<div class="center_title">{$title}</div>

{include file="fragment_message.tpl"}

<form method="post" action="index.php" onsubmit="return checkform(this)">

<input type="hidden" name="do" value="save" /> 
<input type="hidden" name="page" value="{$entity}" />
<input	type="hidden" name="entity" value="{$entity}" />

{include file="fragment_01_up_form_for_dic.tpl"}
<fieldset class="fragment">
<legend>Организация</legend>

<table class="">
        <tr>
				<td>Год</td>
				<td><input {$readonly} {$class_req_input} required='required' type='text' name='year' id='year_id' value='{$object->year}' size='100'/></td>
		</tr>
        <tr>
				<td>Номер</td>
				<td><input {$readonly} {$class_req_input} required='required' type='text' name='number' id='number_id' value='{$object->number}' size='100'/></td>
		</tr>
        <tr>
				<td>Издание</td>
				<td><input {$readonly} {$class_req_input} required='required' type='text' name='issue' id='issue_id' value='{$object->issue}' size='100'/></td>
		</tr>	
		 <tr>
				<td>Наимен. пдф файла</td>
				<td><input {$readonly} {$class_req_input} required='required' type='text' name='file' id='file_id' value='{$object->file}' size='100'/></td>
		</tr>	
		<tr>
		<td>Разделы<br>{if $edit}<a href="" onclick="clearSections();return false;">Очистить</a>{/if}</td>
		<td>
		<input {$readonly} type='hidden' name='sections' id='sections_id' value='{foreach $object->sections as $a name='sections'}{$a->id}{if not $smarty.foreach.sections.last},{/if}{/foreach}' size='100'/>
				
				<div id="selected_sections">{foreach $object->sections as $a name='sections'}{$a->name_rus}{if not $smarty.foreach.sections.last}|{/if}{/foreach}</div>
	
		</td>
		</tr>
</table>
</fieldset>

<pre>{$debugStr}</pre>
{if $edit}
<table class="table_list" id="myTable">
	<thead>
		<tr>
			<th>Добавить</th>
			<th>Код</th>
			<th>Наименование каз.</th>
			<th>Наименование рус.</th>
			<th>Наименование анг.</th>
		</tr>
	</thead>
	<tbody>
		{foreach $listSections as $item}
		<tr>
		    <td> <input class="checkboxes" type="checkbox" name="checkbox" id='checkbox^{$item->name_rus}' value="{$item->id}" onclick='add_section(this)'; {$item->checked}></td>
			<td>{$item->id}</td>
			<td>{$item->name_kaz}</td>
			<td>{$item->name_rus}</td>
			<td>{$item->name_eng}</td>
		
		</tr>	
			{/foreach}
	
	</tbody>
</table>
{/if}
{include file="fragment_02_down_form.tpl"}

</form>


</div>

{include file="footer.tpl"}</div>

</body>
</html>
