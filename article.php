<?php
/**
 * Created by PhpStorm.
 * User: DassinRock
 * Date: 22/08/2018
 * Time: 20:02
 */

require 'php/_functions.php';
if(!empty(get('category'))){
	require_once 'php/_database.php';
	$category = get('category');
	$req = "SELECT * FROM article WHERE category = ?";
	$presql = $db->prepare($req);
	$presql->execute([$category]);
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}else{
	require_once 'php/_database.php';
	$req = "SELECT * FROM article";
	$presql = $db->prepare($req);
	$presql->execute();
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}