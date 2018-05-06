<?php
require_once('connexion_bdd.php');
session_start();

if(isset($_POST['ajout_article']))
{
    $titre = $_POST['titre'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $miniature = $_POST['miniature'];
    $date = date('Y/m/d');

    $sql = $connexion -> prepare("INSERT INTO article (titre, content, date_publication, author, miniature) VALUES (:titre, :content, :date_publication, :author, :miniature)");
    $sql -> bindparam(':titre', $titre, PDO::PARAM_STR);
    $sql -> bindparam(':content', $content, PDO::PARAM_STR);
    $sql -> bindparam(':date_publication', $date, PDO::PARAM_STR);
    $sql -> bindparam(':author', $author, PDO::PARAM_STR);
    $sql -> bindparam(':miniature', $miniature, PDO::PARAM_STR);
    $sql -> execute();

    header('Location:index.php');
    exit(0);

}

else
{
    echo '
    <form method="post" action="" id="ajout">
    <input placeholder="Titre article" type="text" name="titre"><br/><br/>
    <textarea name="content" form="ajout" placeholder="Contenu article"></textarea><br/><br/>
    <input placeholder="Auteur" type="text" name="author"><br/><br/>
    <input placeholder="Miniature" type="text" name="miniature"><br/><br/>
    <input type="submit" value="Envoyer" name="ajout_article">
    </form>';
}



?>