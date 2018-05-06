<?php

$server = "lesitedersaut.mysql.db";
$user = "lesitedersaut";
$mdp = "scTBpwhcc2OPoIJit5AN";
$db = "lesitedersaut";

try
{
    $connexion = new PDO("mysql:host=$server;dbname=$db", $user, $mdp);

    $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo '<script> console.log("Connected successfully to the database"); </script>';
}

catch(PDOException $e)
{
    echo $e -> getMessage();
}

?>