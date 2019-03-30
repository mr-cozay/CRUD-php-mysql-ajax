<?php 
session_start();
require '_database.php';
$field1 = '';
$field2 = '';
$field3 = '';
$field4 = '';

$update = false;
$id = 0;
if(isset($_POST['save'])){
    $field1 = $_POST['field1'];
    $field2 = $_POST['field2'];
    $field3 = $_POST['field3'];
    $field4 = $_POST['field4'];
    try{
        $q = $db->prepare("INSERT INTO article(name, price, noprice, img)
                                        VALUES(:field1, :field2, :field3, :field4)");
			$q->execute([
				'field1'=>$field1,
                'field2'=>$field2,
                'field3'=>$field3,
                'field4'=>$field4
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
        $q = $db->prepare("DELETE FROM article WHERE id=$id");
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
                     $field1 = $row['name'];
                     $field2 = $row['price'];
                     $field3 = $row['noprice'];
                     $field4 = $row['img'];
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
    $field3 = $_POST['field3'];
    $field4 = $_POST['field4'];
    try{
        $q = $db->prepare("UPDATE article SET name='$field1', price='$field2', noprice='$field3', img='$field4' WHERE id='$id'");
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