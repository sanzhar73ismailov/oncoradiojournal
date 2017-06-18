<?php
include_once 'includes/model.php';
// include_once 'includes/stat.php';
include_once 'includes/global.php';
$respArray = array ();
$respArray ['errorMessage'] = 1;
try {
	$respArray ['statistics_on'] = isset ( $statistics_on ) ? $statistics_on : '$statistics_on is not isset';
	if ($statistics_on) {
		$type = trim ( $_GET ['type'] );
		$model = new Model ();
		$pub_id = trim ( $_GET ['pub_id'] );
		$ip = getRealIpAddr ();
		$userAgent = getUserAgent ();
		//$x = 12/0;
		$insertId = $model->insertPublStatistics ( $type, $pub_id, "-", $ip, $userAgent, "download" );
		$respArray ['errorMessage'] = 0;
		$respArray ['type'] = $type;
		$respArray ['pub_id'] = $pub_id;
		$respArray ['ip'] = $ip;
		$respArray ['userAgent'] = $userAgent;
		$respArray ['action'] = "download";

  }
} catch ( Exception $e ) {
	$respArray ['errorMessage'] = $e->getMessage ();
}

echo json_encode ( $respArray );

?>