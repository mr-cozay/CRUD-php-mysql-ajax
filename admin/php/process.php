<?php 
session_start();
require '_database.php';
$field1 = '';
$field2 = '';

$update = false;
$id = 0;
if(isset($_POST['save'])){
    $field1 = $_POST['field1'];
    $field2 = $_POST['field2'];
    try{
        $q = $db->prepare("INSERT INTO tab_test(field1, field2)
                                        VALUES(:field1, :field2)");
			$q->execute([
				'field1'=>$field1,
				'field2'=>$field2
            ]);
            $_SESSION["message"] = "Les champs ont été inséré avec success!";
            $_SESSION["msg_type"] = "success";
            header("Location: ../index.php");
    }catch(PDOException $e){
        $_SESSION["message"] = "Les champs n'ont pas été inséré!";
        $_SESSION["msg_type"] = "error";
    }
}
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    try{
        $q = $db->prepare("DELETE FROM tab_test WHERE id=$id");
            $q->execute();
            $_SESSION["message"] = "Les champs ont été supprimé avec success!";
            $_SESSION["msg_type"] = "danger";
    }catch(PDOException $e){
        $_SESSION["message"] = "Les champs n'ont pas été supprimé!";
        $_SESSION["msg_type"] = "error";
    }
}
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    try{
        $req = $db->prepare("SELECT * FROM article WHERE id=$id");
        $req->execute();
                while ($row = $req->fetch()):
                     //var_dump($req);
                     $field1 = $row['field1'];
                     $field2 = $row['field2'];
                     $field3 = $row['field3'];
                     $field4 = $row['field4'];
                endwhile;
    }catch(PDOException $e){
        $_SESSION["message"] = "Echec lors de la sélection!";
        $_SESSION["msg_type"] = "error";
    }
}
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $field1 = $_POST['field1'];
    $field2 = $_POST['field2'];
    $field3 = $row['field3'];
    $field4 = $row['field4'];
    try{
        $q = $db->prepare("UPDATE article SET field1='$field1', field2='$field2', field3='$field3', field4='$field4' WHERE id='$id'");
			$q->execute();
            $_SESSION["message"] = "Les champs ont été inséré avec success!";
            $_SESSION["msg_type"] = "warning";
            header("Location: ../index.php");
    }catch(PDOException $e){
        $_SESSION["message"] = "Les champs n'ont pas été inséré!";
        $_SESSION["msg_type"] = "error";
    }
}

?>