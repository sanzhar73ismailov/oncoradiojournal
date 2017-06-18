<?php

// возвращает имя папки хоста со слешом на конце
function log_echo($data, $local_log=0){
	$file = 'C:\OpenServer\domains\localhost\publ\a_logs\pub.log';
	$str = '['.date('D M d H:i:s Y',time()).'] ';
	if(TO_LOG && $local_log){
		//echo "<h3>" . $data . "</h3>";
		file_put_contents($file, $str,FILE_APPEND | LOCK_EX);
	
		if(!is_string($data)){
			$str .= print_r($data,true);
		}else{
			$str .= $data;
		}
		$str .= "\r\n";
		file_put_contents($file, $str, FILE_APPEND | LOCK_EX);
	}
}

function getPublicationsAsArrayPresentation($pubObjectArray){
	global $dao;
	$pub_array = array();

	foreach ($pubObjectArray as $object) {
		$item = array();
		$item['id'] = $object->id;
		
		//$item['name_rus_to_check'] = $object->name_rus_to_check; 
		//$item['name_rus_to_check'] = str_replace("-\r\n","<span style='color:red;font-size:x-large;font-weight: bold;'>*-^</span>",$item['name_rus_to_check']);
		//$object->name_rus
		//$item['name_rus_to_check'];
		
		
		$item['name_kaz'] = $object->name_kaz;
		$item['name_rus'] = $object->name_rus;
		$item['name_eng'] = $object->name_eng;
		$item['authors_array'] = $object->author_orgs_array;
		//$keywordArrayNew = array();
		foreach( $object->keywords_array as $keyword ){
			//$str = $keyword->name;
			$keyword->name = str_replace(" -\r\n","<span style='color:red;font-size:x-large;font-weight: bold;'>*-^</span>",$keyword->name); // меняем " -\r\n "*-^"
			$keyword->name = str_replace("-\r\n","<span style='color:red;font-size:x-large;font-weight: bold;'>-^</span>",$keyword->name); // меняем "-\r\n "-^"
			$keyword->name = str_replace("\r\n","<span style='color:red;font-size:x-large;font-weight: bold;'>^</span>",$keyword->name); // меняем конец строки на жирный, красный ^
			$keyword->name = str_replace("- ","<span style='color:red;font-size:x-large;font-weight: bold;'>-*</span>",$keyword->name); // меняем "- ", красный "-^"
			$keyword->name = str_replace(" ,","<span style='color:red;font-size:x-large;font-weight: bold;'>*,</span>",$keyword->name); // меняем " ,", красный "*,"
			$keyword->name = str_replace(" .","<span style='color:red;font-size:x-large;font-weight: bold;'>*.</span>",$keyword->name); // меняем " .", красный "*."
			
			//$newstr = preg_replace("/,(\S)/", "<span style='color:red;font-size:x-large;font-weight: bold;'>,${1}</span>", $str);
			
			//$keyword->name = preg_replace("/,(\S)/","<span style='color:red;font-size:x-large;font-weight: bold;'>,${1}</span>", $keyword->name); // меняем "- ", красный "-^"
			//$keyword->name = preg_replace("/\.(\S)/","<span style='color:red;font-size:x-large;font-weight: bold;'>.${1}</span>", $keyword->name); // меняем "- ", красный "-^"
			
			//$keyword->name =$keyword->name;
		}
			
		
		$item['keywords_array'] = $object->keywords_array;
		$item['type_publ'] = "";
		$item['type_detail'] = "";
		$item['type'] = "";
		$item['source'] = "Источник не установлен";
		$item['year'] = "no year";
		
		$item['issueObj'] = $object->issueObj;
		$item['p_first'] = $object->p_first;
		$item['p_last'] = $object->p_last;
		if(isset($object->responsible) && isset($object->coauthor)){
			$item['responsible'] = $object->responsible;
			$item['coauthor'] = $object->coauthor;
			$item['your_status'] = getStringStatus($object->responsible, $object->coauthor);
		}

		if(isset($object->user_responsible)){
			$item['user_responsible'] = $object->user_responsible;
		}
		//	if(isset($object->type_detail)){
		//		$item['type_detail'] = $object->type_detail;
		//	}

		//echo("<h3> id: <" . $object->id . ">  type->id: <" . $object->type_id . "</h3>");
		//$item['type_detail'] = 'paper_classik';
		
		switch ($object->type_id){
			case PAPER:
			case ELRES:	
				$item['type_detail'] = 'paper_classik';
				//echo("<h1>case PAPER:" . $object->type_id . "</h1>");
				break;
				
			case BOOK:
				
				$item['type_detail'] = 'book';
				break;
				
			case TEZIS:
				
				if($object->tezis_type == 'paper_spec'){
					
					$item['type_detail'] = 'tezis_paper_spec';
					
				}elseif($object->tezis_type == 'paper'){
					
					$item['type_detail'] = 'tezis_paper';
					
				}elseif($object->tezis_type == 'tezis'){
					
					$item['type_detail'] = 'tezis_tezis';
					
				}else{
					exit("Unknown tezis type in getPublicationsAsArrayPresentation function");
				}
				break;
				
			case PATENT:
				$item['type_detail'] = 'patent';
				break;
				
			case METHOD_RECOM:
				$item['type_detail'] = 'method_recom';
				break;
				
			default:
				$item['type_detail'] = 'paper_classik';
				//echo("<h1>case PAPER:" . $object->type_id . "</h1>");
				//exit("Unknown type publication in getPublicationsAsArrayPresentation function");

		}
		

		switch ($object->type_id){
			case PAPER:
				$item['type_publ'] = "paper_classik";
				$item['type'] = "статья";
				$dicItem = new Journal();
				$dicItem->id =  $object->journal_id;
				$dicItem = $dao->get($dicItem);
				if($dicItem != null){
					$item['source'] = $dicItem->name != null ? $dicItem->name : $item['source'];
				}
				$item['source'] .= ", " . $object->year;
				$item['source'] .= ", N " . $object->number;
				if($object->volume != null){
					$item['source'] .= ", Т " . $object->volume;
				}

				if($object->issue != null){
					$item['source'] .= ", В " . $object->issue;
				}
				$item['source'] .= ", c." . $object->p_first;
				$item['source'] .= "-" . $object->p_last;
				$item['source'] .= ".";
				$item['year'] = $object->year;
				break;

			case BOOK:
				$item['type_publ'] = "book";
				$item['type'] = "монография";
				$item['source'] = $object->izdatelstvo;
				$item['source'] .= " г. " . $object->book_city;
				$item['source'] .= ", " . $object->year;
				$item['source'] .= ", стр. " . $object->book_pages;
				$item['source'] .= ".";
				$item['year'] = $object->year;
				break;

			case TEZIS:
				$item['type_publ'] = "tezis";

				switch ($item['type_detail']){

					case "tezis_paper_spec":
						$item['type'] = "конференция - статья в спец. издании";
						break;
					case "tezis_paper":
						$item['type'] = "конференция - статья";
						break;
					case "tezis_tezis":
						$item['type'] = "конференция - тезис";
						break;
					default:
						exit("Ошибка");
				}

				$dicItem = new Conference();
				$dicItem->id =  $object->conference_id;
				$dicItem = $dao->get($dicItem);

				if($dicItem != null){
					$item['source'] = $dicItem->name;
					$item['source'] .= ", " . $dicItem->country;
					$item['source'] .= ", " . $dicItem->city;
				}
				$item['source'] .= ", c." . $object->p_first;
				$item['source'] .= "-" . $object->p_last;

				if($dicItem != null){
					//var_dump($dicItem->date_start);
					$item['source'] .= ", " . getFormatStringFromDate($dicItem->date_start);
					$item['source'] .= "-" . getFormatStringFromDate($dicItem->date_finish);
				}

				$item['source'] .= ".";
				//var_dump($dicItem->date_start);
				$item['year'] = $dicItem->date_start['year'];
				break;

			case ELRES:
				$item['type_publ'] = "elres";
				$item['type'] = "эл. ресурс";
				$item['year'] = $object->year;
				break;

			case PATENT:
				$item['type_publ'] = "patent";
				$item['type'] = "охранный документ";
				$patentVal = $dao->getDicValues("patent_type");
				foreach ($patentVal as $ob) {
					if($ob->id == $object->patent_type_id){
						$item['source'] = $ob->value;
						break;
					}
				}
				$item['source'] .= " N " . $object->patent_type_number;
				$item['source'] .= ", " . getFormatStringFromDate($object->patent_date);
				$item['source'] .= ".";
				$item['year'] = $object->patent_date['year'];
				break;

			case METHOD_RECOM:
				$item['type_publ'] = "method_recom";
				$item['type'] = "метод. рекомендация";
				$item['source'] = $object->izdatelstvo;
				$item['source'] .= " г. " . $object->book_city;
				$item['source'] .= ", " . $object->year;
				$item['source'] .= ", стр. " . $object->book_pages;
				$item['source'] .= ".";
				$item['year'] = $object->year;
				break;
			default:
				$item['type'] = "не установлен";
				$item['source'] = $object->name;
				$item['year'] = $object->year;
		}
		
		$pub_array[] = $item;

	}
	return $pub_array;
}

function getStringStatus($resp, $coauthor){
	$str = "";
	if($resp == 1 && $coauthor == 1){
		$str = "Регистратор-автор";
	}elseif($resp == 1 && $coauthor == 0){
		$str = "Просто регистратор";
	}elseif($resp == 0 && $coauthor == 1){
		$str = "Просто автор";
	}elseif($resp == 0 && $coauthor == 0){
		$str = "Не регистратор, не автор";
	}else{
		var_dump($resp);
		var_dump($coauthor);
		exit("error in getStringStatus");
	}
	return $str;
}

function folder_host($req_uri){
	$needle   = '/';
	$pos      = strripos($req_uri, $needle);
	//echo "<h1>pos = $pos</h1>";

	return  substr($req_uri, 0, $pos);
}
//}
function mail_utf8($to, $from, $subject, $message)
{
	$subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: $from\r\n";

	return mail($to, $subject, $message, $headers);
}

function open_tpl_to_view_patient($id, $smarty, $dao, $do="view"){

	fill_patient_form_by_dic($smarty, $dao);
	$patient = null;
	$patient =$dao->getPatient($id);
	$investigation =$dao->getInvestigationByPatientId($id);

	if($do == "edit"){
		$smarty->assign('readonly',"");
		$smarty->assign('disabled',"");
		$smarty->assign('class',"");

		$smarty->assign('class_req_input',"class='req_input'");
		$smarty->assign('edit',true);
	}else{
		$smarty->assign('readonly',"readonly='readonly'");
		$smarty->assign('disabled',"disabled='disabled'");
		$smarty->assign('edit',false);
		$smarty->assign('class_req_input',"class='read_only_input'");
		$smarty->assign('class',"class='read_only_input'");
	}
	$smarty->assign('investigation_exist', $investigation != null ? true : false);
	$smarty->assign('patient_exist', $patient != null ? true : false);
	$smarty->assign('object',$patient == null ? new Patient(): $patient);
	$smarty->display('templates/edit_patient.tpl');

}

function open_tpl_to_view_investigation($patient_id, $smarty, $dao, $do="view"){

	$patient = $dao->getPatient($patient_id);
	//var_dump($patient);

	if($patient == null){
		exit("Исследование добавляется только имеющемуся пациенту");
	}



	fill_investigation_form_by_dic($smarty, $dao);
	$investigation = null;
	$investigation =$dao->getInvestigationByPatientId($patient_id);
	//echo "patient_id=$patient_id<p>";

	//var_dump($dao->getPatient((int) $_REQUEST["patient_id"]));
	if($investigation == null){
		$do = 'edit';
		$investigation = new Investigation();
		$investigation->patient_id = $patient_id;
	}

	if($do == "edit"){
		$smarty->assign('readonly',"");
		$smarty->assign('disabled',"");
		$smarty->assign('class',"");

		$smarty->assign('class_req_input',"class='req_input'");
		$smarty->assign('edit',true);
	}else{
		$smarty->assign('readonly',"readonly='readonly'");
		$smarty->assign('disabled',"disabled='disabled'");
		$smarty->assign('edit',false);
		$smarty->assign('class_req_input',"class='read_only_input'");
		$smarty->assign('class',"class='read_only_input'");
	}
	$smarty->assign('object',$investigation);
	$smarty->assign('patient',$patient);
	$smarty->assign('patient_exist', true);

	$smarty->display('templates/edit_investigation.tpl');


}



function fill_patient_form_by_dic($smarty, $dao){
	$yes_no_vars = $dao->getDicValues("yes_no");
	$smarty->assign('sexvals',$dao->getDicValues("sex"));
	$smarty->assign('yesnovals',$yes_no_vars);
	$smarty->assign('nationalityvals', $dao->getDicValues("nationality"));

}


function fill_investigation_form_by_dic($smarty, $dao){
	$yes_no_vars = $dao->getDicValues("yes_no");
	$smarty->assign('yesnovals',$yes_no_vars);
	$smarty->assign('intestinum_crassum_part_vals',$dao->getDicValues("intestinum_crassum_part"));
	$smarty->assign('colon_part_vals',$dao->getDicValues("colon_part"));
	$smarty->assign('rectum_part_vals',$dao->getDicValues("rectum_part"));
	$smarty->assign('status_gene_kras_vals',$dao->getDicValues("status_gene_kras"));
	$smarty->assign('depth_of_invasion_vals',$dao->getDicValues("depth_of_invasion"));
	$smarty->assign('stage_vals',$dao->getDicValues("stage"));
	$smarty->assign('tumor_histological_type_vals',$dao->getDicValues("tumor_histological_type"));
	$smarty->assign('tumor_differentiation_degree_vals',$dao->getDicValues("tumor_differentiation_degree"));




}


function getDateFromSqlDate($input_val){

	$pattern = "#^\d\d\d\d-\d\d-\d\d#";
	if(strlen($input_val) == 0){
		return null;
	}
	if(!preg_match($pattern, $input_val)){
		die("Неправильный формат даты: " . $input_val);
	}
	$parts = explode('-', $input_val);
	$d = $parts[2];
	$m = $parts[1];
	$y = $parts[0];
	if(checkdate($m, $d, $y)){
		return  array("day" => $d, "month" => $m, "year"=>$y);
	}else{
		return null;
		//die("Неправильная дата: " . $input_val);
	}

}

function getSqlDateFromDate($date){
	if($date == null){
		return null;
	}
	if(checkdate($date['month'], $date['day'],  $date['year'])){
		return  sprintf("%04d-%02d-%02d", $date['year'], $date['month'],$date['day']);
	}else{
		return null;
		//die("Неправильная дата SQL: " . $date['day'] . "-" . $date['month'] . "-" . $date['year']);
	}


}

function getFormatStringFromDate($date){
	if($date == null){
		return "";
	}
	if(checkdate($date['month'], $date['day'],  $date['year'])){
		return  sprintf("%02d/%02d/%04d", $date['day'], $date['month'], $date['year']);
	}else{
		return null;
		//die("Неправильная дата: " . $date['day'] . "-" . $date['month'] . "-" . $date['year']);
	}

}

function getDateFromFormatDate($input_val){
	$pattern = "#^\d\d/\d\d/\d\d\d\d#";
	if(strlen($input_val) == 0){
		return null;
	}
	if(!preg_match($pattern, $input_val)){
		return null;
		//die("Неправильный формат даты in getDateFromFormatDate: " . $input_val);
	}

	$parts = explode('/', $input_val);
	$d = $parts[0];
	$m = $parts[1];
	$y = $parts[2];
	if(checkdate($m, $d, $y)){
		return  array("day" => $d, "month" => $m, "year"=>$y);
	}else{
		//die("Неправильная дата: " . $input_val);
		return null;
	}

}



?>