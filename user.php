<?php
/**
 * Created by PhpStorm.
 * User: DassinRock
 * Date: 22/08/2018
 * Time: 20:02
 */
require '_database.php';
require '_functions.php';
if(!empty(get('country'))){
	require_once '../php/_database.php';
	$coutry = get('country');
	$req = "SELECT * FROM user WHERE city = ?";
	$presql = $db->prepare($req);
	$presql->execute([$country]);
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}
elseif(!empty(get('city'))){
	require_once '../php/_database.php';
	$city = get('city');
	$req = "SELECT * FROM user WHERE city = ?";
	$presql = $db->prepare($req);
	$presql->execute([$city]);
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}
elseif(!empty(get('area'))){
	require_once '../php/_database.php';
	$area = get('area');
	$req = "SELECT * FROM user WHERE area = ?";
	$presql = $db->prepare($req);
	$presql->execute([$area]);
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}
elseif(!empty(get('phone'))){
	require_once '../php/_database.php';
	$phone = get('phone');
	$req = "SELECT * FROM user WHERE phone = ?";
	$presql = $db->prepare($req);
	$presql->execute([$phone]);
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}
elseif(!empty(get('gender'))){
	require_once '../php/_database.php';
	$gender = get('gender');
	$req = "SELECT * FROM user WHERE gender = ?";
	$presql = $db->prepare($req);
	$presql->execute([$gender]);
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}
elseif(!empty(get('orientation'))){
	require_once '../php/_database.php';
	$orientation = get('orientation');
	$req = "SELECT * FROM user WHERE orientation = ?";
	$presql = $db->prepare($req);
	$presql->execute([$orientation]);
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}
elseif(!empty(get('single'))){
	require_once '../php/_database.php';
	$single = get('single');
	$req = "SELECT * FROM user WHERE single = ?";
	$presql = $db->prepare($req);
	$presql->execute([$single]);
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}
elseif(!empty(get('online'))){
	require_once '../php/_database.php';
	$online = get('online');
	$req = "SELECT * FROM user WHERE online = ?";
	$presql = $db->prepare($req);
	$presql->execute([$online]);
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}
else{
	require_once '../php/_database.php';
	$req = "SELECT * FROM user";
	$presql = $db->prepare($req);
	$presql->execute();
	$list = $presql->fetchAll(PDO::FETCH_ASSOC);
	header("Content-Type:application/json");
	echo (json_encode($list));
}