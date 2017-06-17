function showRowsofPublications(className) {
	try {
		var selected = 0;
		var div = document.getElementById('myTable')
		var allTrs = div.getElementsByTagName('tr')

		// var allTrs = document.getElementsByTagName('tr');
		for (var i = 0; i < allTrs.length; i++) {
			var tr = allTrs[i];
			if (tr.className.startsWith("publ"))
				if (tr.className == ("publ" + className)) {
					tr.style.display = "";
					selected++;
				} else {
					tr.style.display = "none";
				}
		}
		document.getElementById("selected").innerHTML=selected;
		
		var filterRefs = document.getElementsByClassName('filter_publ');
		for (var i = 0; i < filterRefs.length; i++) {
			if(filterRefs[i].id==className){
				filterRefs[i].style.color = "black";
				filterRefs[i].style.backgroundColor = "yellow";
				filterRefs[i].style.textDecoration='none';
			}else{
				filterRefs[i].style.color = "";
				filterRefs[i].style.backgroundColor = "";
				filterRefs[i].style.textDecoration='';
			}
		}
	} catch (e) {
		alert('Ошибка ' + e.name + ":" + e.message);
	}
	return false;

}

function showAllrowsPubs() {
	try {
		var selected = 0;
		var div = document.getElementById('myTable')
		var allTrs = div.getElementsByTagName('tr')
		for (var i = 0; i < allTrs.length; i++) {
			var tr = allTrs[i];
			if (tr.className.startsWith("publ")){
				tr.style.display = "";
				selected++;
			}
		}
		document.getElementById("selected").innerHTML=selected;
		var filterRefs = document.getElementsByClassName('filter_publ');
		for (var i = 0; i < filterRefs.length; i++) {
				filterRefs[i].style.color = "";
				filterRefs[i].style.backgroundColor = "";
				filterRefs[i].style.textDecoration='';
		}
	} catch (e) {
		alert('Ошибка ' + e.name + ":" + e.message + "\n");
	}
	return false;
}

function showAllFilteredList() {
	var reg_a = document.getElementById('registrator_author');
	var reg_nota = document.getElementById('registrator_notauthor');
	var notreg_a = document.getElementById('notregistrator_author');
	var notreg_nota = document.getElementById('notregistrator_notauthor');

	reg_a.checked = true;
	reg_nota.checked = true;
	notreg_a.checked = true;
	notreg_nota.checked = true;
	showFilteredList('all', null);

}

function showFilteredList(type_publ, obj) {
	var url = "index.php";

	var reg_a = document.getElementById('registrator_author');
	var reg_nota = document.getElementById('registrator_notauthor');
	var notreg_a = document.getElementById('notregistrator_author');
	var notreg_nota = document.getElementById('notregistrator_notauthor');

	var reg_a_val = reg_a.checked ? 1 : 0;
	var reg_nota_val = reg_nota.checked ? 1 : 0;
	var notreg_a_val = notreg_a.checked ? 1 : 0;
	var notreg_nota_val = notreg_nota.checked ? 1 : 0;

	if (!reg_a_val && !reg_nota_val && !notreg_a_val && !notreg_nota_val) {
		alert("Хоть один параметр для выборки должен быть указан!");
		document.getElementById(obj.id).checked = true;
		return;

	}

	var params = "?" + "page=list" + "&filter=1" + "&type_publ=" + type_publ
			+ "&registrator_author=" + reg_a_val + "&registrator_notauthor="
			+ reg_nota_val + "&notregistrator_author=" + notreg_a_val
			+ "&notregistrator_notauthor=" + notreg_nota_val;

	// alert(params);
	window.open(url + params, "_self");

}

function downloadFilteredList(type_publ, obj) {
	var url = "index.php";

	var reg_a = document.getElementById('registrator_author');
	var reg_nota = document.getElementById('registrator_notauthor');
	var notreg_a = document.getElementById('notregistrator_author');
	var notreg_nota = document.getElementById('notregistrator_notauthor');

	var reg_a_val = reg_a.checked ? 1 : 0;
	var reg_nota_val = reg_nota.checked ? 1 : 0;
	var notreg_a_val = notreg_a.checked ? 1 : 0;
	var notreg_nota_val = notreg_nota.checked ? 1 : 0;

	if (!reg_a_val && !reg_nota_val && !notreg_a_val && !notreg_nota_val) {
		alert("Хоть один параметр для выборки должен быть указан!");
		document.getElementById(obj.id).checked = true;
		return;

	}

	var params = "?" + "page=list" + "&filter=1" + "&type_publ=" + type_publ
			+ "&registrator_author=" + reg_a_val + "&registrator_notauthor="
			+ reg_nota_val + "&notregistrator_author=" + notreg_a_val
			+ "&notregistrator_notauthor=" + notreg_nota_val + "&download=1";

	// alert(params);
	window.open(url + params, "_self");

}

function checkFileSize(files) {
	// {pdfFile: 15, wordFile: 5}
	var toReturn = true;

	for ( var key in files) {
		var input = document.getElementById(key);
		var file = input.files[0];
		var idForMessage = key + 'Big';
		var messageDiv = document.getElementById(idForMessage);
		if (typeof file != 'undefined'
				&& file.size > (files[key] * 1024 * 1024)) {
			toReturn = false;
			if (messageDiv == null) {
				messageDiv = document.createElement("div");
				messageDiv.setAttribute("id", idForMessage);
				messageDiv.appendChild(document
						.createTextNode("Файл превышает допустимый размер ("
								+ files[key] + " МБ)"));
				messageDiv.style.color = "red";
				input.parentNode.appendChild(messageDiv);
			}
		} else {
			if (messageDiv != null) {
				input.parentNode.removeChild(messageDiv);
			}
		}
	}
	return toReturn;
}

function checkRegisterForm(form) {
	var isNoPass = false;
	var pass1Val = document.getElementById('password1').value;
	var pass2Val = document.getElementById('password2').value;
	var elements = form.elements;
	for (i = 0; i < elements.length; i++) {
		// if(elements[i].className =='req_input'){
		if (elements[i].value == '') {
			isNoPass = true;
		}
		// }
	}

	if (!(/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/
			.test(form.username_email.value))) {
		alert("Ошибка в E-mail!");
		form.username_email.focus();
		return false;
	}
	;

	if (isNoPass) {
		alert('Не заполнены все обязательные поля!');
		return false;
	}

	if (pass1Val != pass2Val) {
		alert('Пароли не совпадают!');
		return false;
	}

	if (!(/^[a-zA-Z0-9]+$/.test(pass1Val))) {
		alert('Пароль должен состоять из комбинации латинских букв и арабских цифр!');
		form.password.focus();
		return false;
	}
	;

	if (pass1Val.length < 6) {
		alert('Пароль должен быть 6-х символов и более!');
		form.password.focus();
		return false;
	}
	;

	return true;
}

function checkPublicform(form) {
	try {
		var isEmpty = false;
		var elements = form.elements;

		var elementRefKazakh = form.number_references_kaz;
		var kazRefEls = document
				.getElementsByName("c19_list_references_kazakh[]");
		var numKazRef = kazRefEls.length;

		// -3 Корректировка названий
		var elemNameKaz = document.getElementById("name_kaz");
		var elemNameRus = document.getElementById("name_rus");
		var elemNameEng = document.getElementById("name_eng");

		elemNameKaz.value = removeRnAndChangeBySpace(elemNameKaz.value);
		elemNameRus.value = removeRnAndChangeBySpace(elemNameRus.value);
		elemNameEng.value = removeRnAndChangeBySpace(elemNameEng.value);

		// -2 Корректировка абстрактов
		var elemAbstractKaz = document.getElementById("abstract_kaz");
		var elemAbstractRus = document.getElementById("abstract_rus");
		var elemAbstractEng = document.getElementById("abstract_eng");

		elemAbstractKaz.value = removeRnAndChangeBySpace(elemAbstractKaz.value);
		elemAbstractRus.value = removeRnAndChangeBySpace(elemAbstractRus.value);
		elemAbstractEng.value = removeRnAndChangeBySpace(elemAbstractEng.value);
		
		// временно для уже сохраненных статей с проблемами
		//elemAbstractKaz.value = removeTereProbel(elemAbstractKaz.value);
		//elemAbstractRus.value = removeTereProbel(elemAbstractRus.value);
		//elemAbstractEng.value = removeTereProbel(elemAbstractEng.value);

		// -1 Корректировка ключевых слов
		var elemKeywordsKaz = document.getElementById("keywords_kaz");// keywords_kaz
		var elemKeywordsRus = document.getElementById("keywords_rus");// keywords_kaz
		var elemKeywordsEng = document.getElementById("keywords_eng");// keywords_kaz
		if (elemKeywordsKaz.value == '' || elemKeywordsRus.value == ''
				|| elemKeywordsEng.value == '') {
			alert('Ключевые слова не заполнены');
			return false;
		}
		elemKeywordsKaz.value = getTrimedWithoutComma(elemKeywordsKaz.value);
		elemKeywordsRus.value = getTrimedWithoutComma(elemKeywordsRus.value);
		elemKeywordsEng.value = getTrimedWithoutComma(elemKeywordsEng.value);
		
		elemKeywordsKaz.value = removeRnAndChangeBySpace(elemKeywordsKaz.value);
		elemKeywordsRus.value = removeRnAndChangeBySpace(elemKeywordsRus.value);
		elemKeywordsEng.value = removeRnAndChangeBySpace(elemKeywordsEng.value);
		
		var lengthKaz = elemKeywordsKaz.value.split(",");
		var lengthRus = elemKeywordsRus.value.split(",");
		var lengthEng = elemKeywordsEng.value.split(",");
		if (lengthKaz.length != lengthRus.length) {
			alert('Разное количество ключевых слов для казахского и русского языков');
			return false;
		}
		if ((lengthKaz.length != lengthEng.length)) {
			alert('Разное количество ключевых слов для для казахского и английского языков');
			return false;
		}

		if ((lengthRus.length != lengthEng.length)) {
			alert('Разное количество ключевых слов для для русского и английского языков');
			return false;
		}
		// 0
		var elements = document.getElementsByName("authors_orgs[]");
		// console.log(elements.length);
		if (elements.length == 0) {
			alert('Необходимо выбрать хоть одного автора');
			return false;
		}

		// 1
		/*
		 * if(elementRefKazakh.value > 0){ if(elementRefKazakh.value !=
		 * numKazRef){ alert('Количество библиографических ссылок (' +numKazRef + ')
		 * на казахстанских авторов (п. 18) и количество перечисленных
		 * ('+elementRefKazakh.value+') (п.19) не сходится!\n Исправьте или
		 * количество или добавьте/удалите сами ссылки'); return false; }
		 * 
		 * for ( var i = 0; i < kazRefEls.length; i++) { if(kazRefEls[i].value ==
		 * ''){
		 * 
		 * alert('Поля библиографических ссылок на казахстанских авторов (п. 19)
		 * не должны быть пустыми!'); return false; } } }else{ for ( var i = 0;
		 * i < kazRefEls.length; i++) { if(kazRefEls[i].value != ''){
		 * 
		 * alert('В поле "количество библиографических ссылок на казахстанских
		 * авторов" (п. 18) указано 0, а ссылки есть ('+numKazRef+') (п.19),
		 * исправьте!'); return false; } } }
		 */
		for (i = 0; i < elements.length; i++) {
			if (elements[i].className == 'req_input') {
				if (elements[i].value == '') {
					isEmpty = true;
				}
			}
		}
		if (isEmpty) {
			alert('Не заполнены все обязательные поля!');
			return false;
		}
	} catch (e) {
		alert("Ошибка: " + e.message);
		return false;
	}
	return true;
}

function checkSelectAuthorsOrgForm(form) {
	var elements = document.getElementsByName("authors_orgs[]");
	console.log(elements.length);
	if (elements.length == 0) {
		alert('Необходимо выбрать хоть одного автора');
		return false;
	}
	return true;
}
function checkform(form) {
	var isEmpty = false;
	var elements = form.elements;
	for (i = 0; i < elements.length; i++) {
		if (elements[i].className == 'req_input') {
			if (elements[i].value == '') {
				isEmpty = true;
			}
		}
	}
	if (isEmpty) {
		alert('Не заполнены все обязательные поля!');
		return false;
	}
	return true;
}

function ChN(xN) // это целое число без знака ?
{
	var num = "0123456789";
	ret = true;
	for (i = 0; i < xN.length; i++) {
		if (num.indexOf(xN.charAt(i)) < 0) {
			ret = false;
			break;
		}
	}
	return ret;
}
function isObjDouble(obj) {
	obj.value = Trim(obj.value);
	obj.value = obj.value.replace(",", ".");
	if (obj.value == '')
		return 1;
	if (isNaN(obj.value)) {
		alert('Неверное число !');
		SetTimeFocus(obj.id);
		return 0;
	} else {
		return 1;
	}
}
function IsDate(dt) { // это дата "dd/mm/year" ?
	var ret = false, dd, mm, gg;
	dm = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

	if (dt.charAt(2) != '/' || dt.charAt(5) != '/')
		return ret;
	if (dt.length == 10) {
		dd = dt.substring(0, 2); // день
		mm = dt.substring(3, 5); // месяц
		gg = dt.substring(6, 10); // год
		if (!ChN(dd) || !ChN(mm) || !ChN(gg))
			return ret;

		if (gg == (100 * Math.floor(gg / 100))) {
			if (gg == (400 * Math.floor(gg / 400)))
				dm[1] = 29;
		} else {
			if (gg == (4 * Math.floor(gg / 4)))
				dm[1] = 29;
		}
		if (0 < mm && mm < 13) {
			if (0 < dd && dd <= dm[mm - 1])
				ret = true;
		}
	}
	return ret;
}
function IsObjDate(obj) { // Ввели дату "dd/mm/year" или "" ?
	obj.value = Trim(obj.value);
	if (obj.value == '')
		return 1;
	if (!IsDate(obj.value)) {
		alert('Неверная дата !');
		SetTimeFocus(obj.id);
		return 0;
	} else {
		return 1;
	}
}
// Функция установки фокуса по событию onBlur
function SetTimeFocus(id) {
	setTimeout('document.getElementById("' + id + '").focus()', 200);
}
// вернуть строку без пробелов с краёв
function Trim(str) {
	str = str.replace(/^\s+/, ''); // Удаляем все пробелы слева
	str = str.replace(/\s+$/, ''); // Удаляем все пробелы справа
	return str;
}
function TempDt(event, obj) {
	if (event.keyCode == 8)
		return false;
	var v = obj.value, l = v.length;
	if (l == 2)
		obj.value = v + "/";
	if (l == 5)
		obj.value = v + "/";
	return true;
}

function sendFindForm(beanObject) {

	var form = document.getElementById("findFormId");
	// adding page input
	var input = document.createElement('input');
	input.type = 'hidden';
	input.name = 'page';
	input.value = beanObject.page;
	form.appendChild(input);

	document.getElementById('entityFindId').value = beanObject.entity;

	if (beanObject.toFind == null || beanObject.toFind.length == 0) {
		var findInput = document.getElementById("toFindFindId");
		findInput.parentNode.removeChild(findInput);
	} else {
		document.getElementById('toFindFindId').value = beanObject.toFind;
	}

	if (beanObject.entity == 'student') {
		document.getElementById('lastNameRuFindId').value = beanObject.lastNameRu;
		document.getElementById('firstNameRuFindId').value = beanObject.firstNameRu;
		document.getElementById('commentsFindId').value = beanObject.comments;
		document.getElementById('emailFindId').value = beanObject.email;
	} else if (beanObject.entity == 'organization') {
		document.getElementById('rnnFindId').value = beanObject.rnn;
		document.getElementById('nameFindId').value = beanObject.name;
	}

	form.submit();
}
function myFunction() {
	alert("Привет!!!");
}

function confirmDelete() {
	if (confirm("Вы подтверждаете удаление?")) {
		return true;
	} else {
		return false;
	}
}

function setTheSameInSelect(s1, s2) {

	var val1 = document.getElementById(s1).selectedIndex;
	document.getElementById(s2).selectedIndex = val1;
}

function setTheSameInInput(s1, s2) {
	var val1 = document.getElementById(s1).value;
	document.getElementById(s2).value = val1;
}

// возвращает подстроку без пробелов и запятых по бокам и без точки в конце
function getTrimedWithoutComma(val) {
	val = val.trim();
	// убираем двойные пробелы между словами
	val = val.replace(/  +/g, ' ');
	// меняем точку с запятой на запятую
	val = val.replace(/;/g, ',');

	if (val.startsWith(",")) {
		val = val.substr(1, val.length);
	}
	if (val.endsWith(",")) {
		val = val.substr(0, val.length - 1);
	}
	if (val.endsWith(".")) {
		val = val.substr(0, val.length - 1);
	}
	val = val.trim();
	return val;
}



// меняет все переносы в тексте на пробелы, все двойные (множественные) пробелы
// меняет на одинарные, пробелы по бокам убирает.
function removeRnAndChangeBySpace(str) {
	str = str.replace(/-\r?\n/g, ""); //убираем знак -\r\n на ничто, обычно это переносы
	str = str.replace(/\r?\n/g, " ");
	str = str.replace(/  +/g, ' ');
	str = str.replace(/¬/g, ""); // убираем знак ¬ (видимо в пдф образуется из мягкого переноса) 
	str = str.trim();
	return str;
}

// функция для статей уже занесенных в базу с проблемами (временная)
function removeTereProbel(str) {
	str = str.replace(/(\S)- /g,"$1"); //убираем знак "- " (впереди нет пробела) на ничто, обычно это переносы
	str = str.replace(/¬ /g, ""); // убираем знак "¬ " (видимо в пдф образуется из мягкого переноса) 
	str = str.replace(/¬/g, ""); // убираем знак "¬" (видимо в пдф образуется из мягкого переноса) 
	str = str.trim();
	return str;
}