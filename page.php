<?php
/**
 * Created by PhpStorm.
 * User: DassinRock
 * Date: 22/08/2018
 * Time: 19:45
 */
require '_functions.php';
if(!empty(get())){
	require '../php/_database.php';
	$city = $_GET['$city'];
	$req = "SELECT * FROM page WHERE city = $city";
	$presql = $db->prepare($req);
	$presql->execute();
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}
if(!empty($_GET['$city'])){
	require '../php/_database.php';
	$city = $_GET['$city'];
	$req = "SELECT * FROM page WHERE city = $city";
	$presql = $db->prepare($req);
	$presql->execute();
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}

?>