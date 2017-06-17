/* 
 * item_id - id номера или статьи
 * type:  p - для статей, i - для номеров 
 */
function showAbstarct(abstrId, lang){
	// showAbstract
	// abstract
	var showLabel ="Показать реферат >>";
	var hideLabel ="<< Скрыть реферат";
	if(lang=="kaz"){
		showLabel ="Показать реферат >>";
		hideLabel ="<< Скрыть реферат";
	}else if (lang=="eng") {
		showLabel ="Show abstract >>";
		 hideLabel ="<< Hide abstract";
	}
	try{
		var idForElDiv = "abstract" + abstrId;
		var elDiv = document.getElementById(idForElDiv);
		var elHref = document.getElementById("showAbstract"+abstrId);
		if(elDiv.style.display == "none"){
			elDiv.style.display = "";
			elHref.innerHTML = hideLabel;
		}else{
			elDiv.style.display = "none";
			elHref.innerHTML = showLabel;	
		}
	}catch(e){
		console.log(e);
	}
}

function contClick(item_id, type) {
	// console.log(pubId);
	$.getJSON("ajax.php", // The server URL
	{
		type : type ,
		pub_id : item_id
		
	}, // Data you want to pass to the server.
	show_res // The function to call on completion.
	);
	return false;
}

function show_res(json){
	if(json['errorMessage'] != 0){
		//alert("error: " + json['errorMessage']);
	}
	var str = JSON.stringify(json, null, 2);
	//console.log("json:" + str);
}