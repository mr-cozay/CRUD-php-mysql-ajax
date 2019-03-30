<?php
/**
 * Created by PhpStorm.
 * User: DassinRock
 * Date: 30/07/2018
 * Time: 18:28
 *
 *
 */
    $dbhost = 'localhost';
    $dbname = 'test_api_db';
    $dbuser = 'root';
    $dbpswd = '';

    try{
        $db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname,$dbuser,$dbpswd, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    }catch(PDOException $e){
        die("Une erreur est survenue lors de la connexion à la base de donnée");
    }




