function isInt(n) {
   return typeof n === 'number' && n % 1 == 0;
}
function add_natinality() {
	var placeForInput = document.getElementById("pole_for_add_nationality");
	// placeForInput.style.color = 'blue';
	var inputTextNew = document.createElement("input");
	inputTextNew.setAttribute("type", "text");
	inputTextNew.setAttribute("size", "20");
	inputTextNew.setAttribute("id", "nationalityNew");
	inputTextNew.setAttribute("name", "nationalityNew");

	var btnAdd = document.createElement("button");
	btnAdd.innerHTML = "Добавить";
	// inputTextNew.setAttribute("size", "20");
	btnAdd.setAttribute("id", "btnAdd");
	btnAdd.setAttribute("name", "btnAdd");
	btnAdd.setAttribute("onclick",
			"return add_natinality_btn('nationalityNew');");

	placeForInput.appendChild(inputTextNew);
	placeForInput.appendChild(btnAdd);

	// placeForInput.innerHTML = "test";

	// alert(1111);

}

function add_natinality_btn(elementId) {

	///console.log(777);
	var valueNew = document.getElementById(elementId).value;
	//console.log(valueNew);

	$.getJSON("ajax_add_row.php", // The server URL
	{
		pole : valueNew
	}, // Data you want to pass to the server.
	show // The function to call on completion.
	);

	return false;

}

function show(json) {
	//console.log("sss:" + json);

	if (json.id == 0) {
		alert(json.id + " " + json.value);
		return;
	}

	var select = document.getElementById("nationality_id");
	var optionElement = document.createElement("option");
	optionElement.setAttribute("value", json.id);
/*
	for (loop = select.childNodes.length - 1; loop >= 0; loop--) {
		if (select.options[loop].selected) {
			select.options[loop].selected = false;
		}
	}
*/
	if ( select.selectedIndex != -1)
	{
	  //Если есть выбранный элемент, отобразить его значение (свойство value)
	  
	 // select.options[select.selectedIndex].selected=false;
	  select.options[select.selectedIndex].removeAttribute("selected");
	}

	optionElement.setAttribute("selected", "selected");
	optionElement.appendChild(document.createTextNode(json.value));
	select.appendChild(optionElement);

}


function check_publ_exist(obj) {
	
	var publName  = document.getElementById(obj.id).value;
	//alert(publName);
	
	var valueNew = publName;
	//console.log(valueNew);

	$.getJSON("ajax_check_publ_exist.php", // The server URL
	{
		pub_name : valueNew
	}, // Data you want to pass to the server.
	show_res // The function to call on completion.
	);

	return false;
}
// получаем id организации по автору 
function select_org(obj) {
	
    var e = document.getElementById(obj.id);
	var aut_id = e.options[e.selectedIndex].value;
	//console.log(aut_id);

	$.getJSON("ajax_get_org_id_of_author.php", // The server URL
	{
		author_id : aut_id
	}, // Data you want to pass to the server.
	select_organization // The function to call on completion.
	);

	return false;
}

//select_org refresh_selects
function refresh_selects(issue_id) {
	
    //var e = document.getElementById(obj.id);
	//var aut_id = e.options[e.selectedIndex].value;
	//console.log(issue_id);

	$.getJSON("ajax_refresh_selects.php", // The server URL
	{
		issue_id : issue_id
	}, // Data you want to pass to the server.
	refresh_selects_call_back // The function to call on completion.
	);

	return false;
}
function select_organization(json){
	//alert(json); return;
	var org_id = json;
	//var selectElementOrg = document.getElementById('organization_id');
	$('#organization_id').val(org_id);
	
}

function  refresh_selects_call_back(json){
	var idOfElement = "";
	var jsonArray  = "";
	
	idOfElement = '#'+'section_id';
	jsonArray  = json.sections;
	var e = document.getElementById("section_id");
	var sectionValue = "";
	if(e.selectedIndex != -1) {
		sectionValue = e.options[e.selectedIndex].value;
	}
	
	$(idOfElement).empty();
	for(var i=0; i < jsonArray.length; i++){
		var selected = "";
		if(jsonArray[i].id == sectionValue){selected = "selected";}
		$(idOfElement).append('<option value="' + jsonArray[i].id + '"' + selected + '>' + jsonArray[i].name_rus + '</option>');
	}
	
	idOfElement = '#'+'author_id';
	jsonArray  = json.authors;
	$(idOfElement).empty();
	for(var i=0; i < jsonArray.length; i++){
		var author_name = jsonArray[i].last_name_rus + ' ' + jsonArray[i].first_name_rus + ' ' + jsonArray[i].patronymic_name_rus;  
		$(idOfElement).append('<option value="' + jsonArray[i].id + '">' + author_name + '</option>');
	}
	
	idOfElement = '#'+'organization_id';
	jsonArray  = json.organizations;
	$(idOfElement).empty();
	for(var i=0; i < jsonArray.length; i++){
		$(idOfElement).append('<option value="' + jsonArray[i].id + '">' + jsonArray[i].name_rus + '</option>');
	}

	//console.log(json); return;
	
}
function show_res(json){
	//alert(json); return;
	if(json.length > 0){
		document.getElementById('papers_founded_block').style.display = "inline";
		var papers_foundedEl  = document.getElementById('papers_founded');
		papers_foundedEl.innerHTML = "";
	
		for ( var i = 0; i < json.length; i++) {
			var item = json[i];
			var aut_str = (i+1) + ". ";
			var str = "";
			
			//console.log(item);
			
			
			for (var j = 0; j < item.authors_array.length; j++) {
				var author = item.authors_array[j];
				aut_str += author.last_name + ' ' +  author.first_name + '. ';
			}
			
			var aut_node = document.createTextNode(aut_str);
			
			papers_foundedEl.appendChild(aut_node);
			str = item.name + " (" + item.type + ")" + "//" + item.source;
			papers_foundedEl.appendChild(document.createTextNode(str));
			
			
			//http://localhost/publ/index.php?page=publication&id=120&ce=1&type_publ=tezis_paper_spec
			//$item['type_detail']
			viewEl = document.createElement("a");
			var hrefStr = "index.php?page=publication&id="+item.id +"&ce=0&type_publ="+item.type_detail;
			viewEl.setAttribute("href", hrefStr);
			viewEl.setAttribute("target", "_blank");
			viewEl.appendChild(document.createTextNode('Просмотр в отдельном окне'));
			papers_foundedEl.appendChild(viewEl);
			papers_foundedEl.appendChild(document.createElement("br"));
			papers_foundedEl.appendChild(document.createElement("hr"));
			
		}
			
	}else{
		document.getElementById('papers_founded_block').style.display = "none";
	}
	
}

function hideBlock(block){
	document.getElementById(block).style.display = "none";
}

