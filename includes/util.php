<?php
/**
 * 
 * Выводит содержимое переменной в HTML в удобочитаемом виде
 * @param unknown_type $var
 */
function printInHtml($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

function getFistLetterBig($str){
	$strRet = "";
	$strRet .=  mb_strtoupper (mb_substr($str, 0, 1));
	$strRet .= mb_strtolower (mb_substr($str, 1, mb_strlen($str) ));
	return $strRet;
}


?>