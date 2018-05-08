<?php

session_start();
require_once("../connexion_bdd.php");

if ($_SESSION['logged'] === FALSE)
{
	header('Location:../../index.php');
	exit(0);
} 

if(isset($_POST['send_delete']))
{
    $id_article = $_POST['id_article'];

    $sql = $connexion -> prepare ('DELETE FROM article WHERE id_article = :id_article');
    $sql -> bindParam(':id_article', $id_article, PDO::PARAM_INT);
    $sql -> execute();

    header('Location:../index.php');
    exit(0);
}

else
{
    header('Location:../index.php');
    exit(0);
}

?>