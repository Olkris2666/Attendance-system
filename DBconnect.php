<?php
$user="root";
$pwd="";
try{
    $db = new PDO('mysql:host=localhost;dbname=cetras attendence', $user, $pwd);
    echo "> Succesfully connected to database";
} catch(PDOexception $e){
    echo "> Failed to connect to database, ", $e->getMessage();
    die();
}
?>
