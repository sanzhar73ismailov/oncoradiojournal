<?php
// the message
$msg = "TESTMAIL";
$headers = "From: test@oncojournal.kz" . "\r\n";
//$rr = mail("test@oncojournal.kz","My subject",$msg, $headers);
$rr = mail("javajan@mail.ru","My subject",$msg, $headers);
print_r(error_get_last());
print_r($rr);
var_dump($rr);
?>