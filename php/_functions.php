<?php
/**
 * Created by PhpStorm.
 * User: DassinRock
 * Date: 30/07/2018
 * Time: 18:59
 */
//Sanitizer
if(!function_exists('e')){
    function e($string){
        if ($string) {
            return strip_tags($string);
        }
    }
}
//Check si les champs existent et ne sont pas vides
if(!function_exists('not_empty')){
    function not_empty($fields = []){
        if(count($fields) != 0){
            foreach ($fields as $field) {
                if (empty($_POST[$field]) || trim($_POST[$field]) == "") {
                    return false;
                }
            }
            return true;
        }
    }
}
//Calcule l'age d'une date donnée en paramètre
if (!function_exists('getAge')){
    function getAge($birth){
        $date = $birth;
        if(version_compare(PHP_VERSION, '5.3.0') >= 0){
            $dob = new DateTime($date);
            $now = new DateTime();
            return $now->diff($dob)->y;
        }
        $difference = time() - strtotime($date);
        return floor($difference / 31556926);
    }
}
if (!function_exists('random_main_id')){
    function random_main_id($min, $max){
        if(version_compare(PHP_VERSION, '7.0.1') >= 0){
            $value = random_int($min,$max);
        }else{
			$value = rand($min,$max);
		}
		return $value;
    }
}
//Check si la valeur d'un champ est déjà utilisée
if(!function_exists('is_already_in_use')){
    function is_already_in_use($field, $value, $table){
        global $db;
        $q = $db->prepare("SELECT id FROM $table WHERE $field = ?");
        $q->execute([$value]);
        $count = $q->rowCount();
        $q->closeCursor();
        return $count;
    }
}
//Check si la valeur d'un champ est déjà utilisée avec 2 params
if(!function_exists('is_already_in_use_two')){
	function is_already_in_use_two($field, $value, $table, $fieldy, $result){
		global $db;
		$q = $db->prepare("SELECT id FROM $table WHERE $field = ? AND $fieldy = ?");
		$q->execute([$value, $result]);
		$count = $q->rowCount();
		$q->closeCursor();
		return $count;
	}
}
//Count line of inner join of 2 tables
if(!function_exists('jointure_count')){
	function jointure_count($table1Field, $table1, $table2, $table1ID, $table2FK, $table2Field, $value){
		global $db;
		$q = $db->prepare("SELECT $table1.$table1Field FROM $table1 INNER JOIN $table2 ON $table1.$table1ID = $table2.$table2FK WHERE $table2.$table2Field = ?");
		$q->execute([$value]);
		$count = $q->rowCount();
		$q->closeCursor();
		return $count;
	}
}
if(!function_exists('jointure_count_all')){
	function jointure_count_all($table1, $table2, $table1ID, $table2FK, $table2Field, $value){
		global $db;
		$q = $db->prepare("SELECT * FROM $table1 INNER JOIN $table2 ON $table1.$table1ID = $table2.$table2FK WHERE $table2.$table2Field = ?");
		$q->execute([$value]);
		$count = $q->rowCount();
		$q->closeCursor();
		return $count;
	}
}
//Notification alert flash
if (!function_exists('set_flash')){

    function set_flash($message, $type = ''){
        $_SESSION['notification']['message'] = $message;
        $_SESSION['notification']['type'] = $type;
    }
}
//Redirige vers l'url donnée en paramètre
if (!function_exists('redirect')){
    function redirect($page){
        header('Location: '.$page);
        exit();
    }
}
//Save les données d'un champ en session
if (!function_exists('save_input_data')){
    function save_input_data(){
        foreach ($_POST as $key => $value){
            if (strpos($key, 'password')===false){
                $_SESSION['input'][$key] = $value;
            }
        }
    }
}
//Get les données d'un champ en session
if (!function_exists('get_input_data')){
    function get_input_data($key){
        return !empty($_SESSION['input'][$key])
            ? e($_SESSION['input'][$key])
            : null;
    }
}
//Clean toutes les données des champs en session
if (!function_exists('clear_input_data')){
    function clear_input_data(){
        if (isset($_SESSION['input'])){
            $_SESSION['input'] = [];
        }
    }
}
//Get les données d'une clé sauvée en session
if (!function_exists('get_session')){
	function get_session($key){
		if($key){
			return !empty($_SESSION[$key])
				? e($_SESSION[$key])
				: null;
		}
	}
}
if (!function_exists('get')){
	function get($key){
		if($key){
			return !empty($_GET[$key])
				? e($_GET[$key])
				: null;
		}
	}
}
if (!function_exists('post')){
	function post($key){
		if($key){
			return !empty($_POST[$key])
				? e($_POST[$key])
				: null;
		}
	}
}
//Add la chaine 'active' si le nom du fichier correspond au nom de la page sans son extension
if (!function_exists('set_active')){
    function set_active($page,$title){
       if ($page === $title){
           return true;
       }else{
           return false;
       }
    }
}
//Fetch un objet PDO correspondant au champ en paramètre, sinon retourne le booléen false
if (!function_exists('fetch_pdo_object')){
	function fetch_pdo_object($table,$field,$value){
		if (is_already_in_use($field,$value,$table)){
			global $db;
			$q = $db->prepare("SELECT * FROM $table WHERE $field = ?");
			$q->execute([$value]);
			$object = $q->fetch(PDO::FETCH_OBJ);
			$q->closeCursor();
			return $object;
		}else{
			return false;
		}
	}
}
if (!function_exists('fetch_one_field_pdo_object')){
	function fetch_one_field_pdo_object($table,$field,$value,$fieldy){
		if (is_already_in_use($field,$value,$table)){
			global $db;
			$q = $db->prepare("SELECT $fieldy FROM $table WHERE $field = ?");
			$q->execute([$value]);
			$object = $q->fetch(PDO::FETCH_OBJ);
			$q->closeCursor();
			return $object;
		}else{
			return false;
		}
	}
}
//Fetch un objet PDO d'une jointure, sinon retourne le booléen false
if (!function_exists('fetch_jointure_pdo_object')){
	function fetch_jointure_pdo_object($table1Field, $table1, $table2, $table1ID, $table2FK, $table2Field, $value){
		if (!empty(jointure_count($table1Field, $table1, $table2, $table1ID, $table2FK, $table2Field, $value))){
			global $db;
			$q = $db->prepare("SELECT $table1.$table1Field FROM $table1 INNER JOIN $table2 ON $table1.$table1ID = $table2.$table2FK WHERE $table2.$table2Field = ?");
			$q->execute([$value]);
			$object = $q->fetch(PDO::FETCH_OBJ);
			$q->closeCursor();
			return $object;
		}else{
			return false;
		}

	}
}
if (!function_exists('fetch_jointure_pdo_objects')){
	function fetch_jointure_pdo_objects($table1, $table2, $table1ID, $table2FK, $table2Field, $value){
		if (!empty(jointure_count_all($table1, $table2, $table1ID, $table2FK, $table2Field, $value))){
			global $db;
			$q = $db->prepare("SELECT * FROM $table1 INNER JOIN $table2 ON $table1.$table1ID = $table2.$table2FK WHERE $table2.$table2Field = ?");
			$q->execute([$value]);
			$object = $q->fetch(PDO::FETCH_OBJ);
			$q->closeCursor();
			return $object;
		}else{
			return false;
		}

	}
}

if (!function_exists('fetch_pdo_object_two')){
	function fetch_pdo_object_two($table,$field,$value,$fieldy,$result){
		if (is_already_in_use($field,$value,$table)){
			global $db;
			$q = $db->prepare("SELECT * FROM $table WHERE $field = ? AND $fieldy = ?");
			$q->execute([$value,$result]);
			$object = $q->fetch(PDO::FETCH_OBJ);
			$q->closeCursor();
			return $object;
		}else{
			return false;
		}
	}
}
if (!function_exists('isset_others')){
	function isset_others($table, $field, $value, $fieldy, $valor){
		global $db;
		$q = $db->prepare("SELECT id FROM $table WHERE $field != ? AND $fieldy = ?");
		$q->execute([$value,$valor]);
		$count = $q->rowCount();
		$q->closeCursor();
		return $count;
	}
}

if (!function_exists('get_others')){
	function get_others($table, $field, $value, $fieldy, $valor) {
		if (isset_others($table,$field,$value,$fieldy,$valor)){
			global $db;
			$req = $db->prepare("SELECT * FROM $table WHERE $field != ? AND $fieldy = ?");
			$req->execute([$value,$valor]);
			$results = array();
			while ($rows = $req->fetchObject()) {
				$results[] = $rows;
			}
			return $results;
		}else{
			return false;
		}
	}
}
if (!function_exists('get_others_just')){
	function get_others_just($table, $field, $value) {
		global $db;
		$req = $db->query("SELECT * FROM $table WHERE $field != $value");
		$results = array();
		while ($rows = $req->fetchObject()) {
			$results[] = $rows;
		}
		return $results;
	}
}
//Fetch des objets PDO correspondant à la table en paramètre, sinon retourne le booléen
if (!function_exists('fetch_pdo_objects')){
	function fetch_pdo_objects($table){
		global $db;
		$q = $db->query("SELECT * FROM $table");
		$results = array();
		while ($rows = $q->fetchObject()) {
			$results[] = $rows;
		}
		if(!empty($results)){
			return $results;
		}else{
			return false;
		}

	}
}
//UPDATE un champ de type DATETIME en temps actuel
if (!function_exists('set_time_now')){
	function set_time_now($time, $field, $value, $table){
		global $db;
		$sec_time = time();
		$q = $db->prepare("UPDATE $table SET $time = $sec_time WHERE $field = ?");
		$q->execute([$value]);
	}
}
//UPDATE un champ en '1' à l'instant
if (!function_exists('set_on')){
	function set_on($on, $time, $field, $value, $table){
		set_time_now($time, $field, $value, $table);
		global $db;
		$q = $db->prepare("UPDATE $table SET $on = '1' WHERE $field = ?");
		$q->execute([$value]);
	}
}
//UPDATE un champ en '0' à l'instant
if (!function_exists('set_off')){
	function set_off($off, $time, $field, $value, $table){
		set_time_now($time, $field, $value, $table);
		global $db;
		$q = $db->prepare("UPDATE $table SET $off = '0' WHERE $field = ?");
		$q->execute([$value]);
	}
}
//Update
if (!function_exists('update_fieldy')){
	function update_fieldy($fieldy, $result, $field, $value, $table){
		global $db;
		$q = $db->prepare("UPDATE $table SET $fieldy = '$result' WHERE $field = ?");
		$q->execute([$value]);
	}
}
if (!function_exists('get_session_auth')){
function get_session_auth($session_key, $get_key, $redirect_page){
	if (!empty(get_session($session_key))&&(!empty($_GET[$get_key]))){
		if ((get_session($session_key)) != ($_GET[$get_key])){
			redirect($redirect_page);
			exit();
		}else{

		}
	}else{
		redirect($redirect_page);
		exit();
	}
}
}
/**
if (!function_exists('not_xxxORx00')){
	function not_xxxORx00($int){
		if($int == 111 || $int == 200 || $int == 222 || $int == 300 || $int == 333 ||
		   $int == 400 || $int == 444 || $int == 500 || $int == 555 || $int == 600 ||
		   $int == 666 || $int == 700 || $int == 777 || $int == 800 || $int == 888 ||
		   $int == 900){
			not_xxxORx00($int);
		}else{
			return $int;}
		return $int;
	}
}
if (!function_exists('matricule')){
	function matricule($string,$min,$max){
		$rand = random_int($min,$max);$val = not_xxxORx00($rand);
		$abc = array('a','b','c','d','e','f','g','h','j','k','m','n','p','r','s','t','u',
			'v','x','y','z');
		$randabc = array_rand($abc);
		$arrandabc = $abc[$randabc];
		$randabcd = array_rand($abc);
		$arrandabcd = $abc[$randabcd];
		$randabcde = array_rand($abc);
		$arrandabcde = $abc[$randabcde];
		return strtolower($string.$arrandabc.$arrandabcd.$val.$arrandabcde);
	}
}
if (!function_exists('set_matricule')){
	function set_matricule($matricule,$valor, $field, $value, $table){
		global $db;
		$q = $db->prepare("UPDATE $table SET $matricule = :$matricule  WHERE $field = :$field");
		$q->execute([
			$matricule=>$valor,
			$field=>$value]);
	}
}
**/
