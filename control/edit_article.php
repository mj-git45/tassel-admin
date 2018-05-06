<?php

session_start();
require_once("../connexion_bdd.php");

if ($_SESSION['logged'] === FALSE)
{
	header('Location:../../index.php');
	exit(0);
} 

else
{
	unset($_SESSION['compte'] -> password);
	foreach ($_SESSION['compte'] as $key => $value)
				{
					$compte[$key] = $value;
				}
}

if (isset($_POST['send_edit']))
{
    //Si une nouvelle miniature est upload
    if($_FILES['miniature']['error'] === 0)
    {
        $folder = '../../../img/articles/';
        $miniature = $folder . basename($_FILES['miniature']['name']);
        $extension = pathinfo($miniature, PATHINFO_EXTENSION);
        $max_size = 5000000;
        $size = $_FILES['miniature']['size'];
        $error = FALSE;
        
        //Test si le fichier est une image
        $x = getimagesize($_FILES["miniature"]["tmp_name"]);
        if($x === 0)
        {
            $_SESSION['erreur_up'] = 'getimagesize()';
            header('Location:../edit_article.php?id_article='. $_POST['id_article']);
            $error = TRUE;
            exit(0);
        }

        //Limiter la taille du fichier a 5 Mo
        
        if(($size > $max_size))
        {
            $_SESSION['erreur_up'] = '> 5 Mo';
            $_SESSION['taille'] = $_FILES['miniature']['size'];
            $_SESSION['oui'] = $max_size;
            header('Location:../edit_article.php?id_article='. $_POST['id_article']);
            $error = TRUE;
            exit(0);
        }

        //Autorise seulement les fichiers jpg, jpeg, png et gif
        if($extension !== 'jpg' && $extension !== 'JPG' && $extension !== 'jpeg' && $extension !== 'JPEG' && $extension !== 'png' && $extension !== 'PNG' && $extension !== 'gif' && $extension !== 'GIF')
        {
            $_SESSION['erreur_up'] = 'mauvais format';
            $_SESSION['format'] = $extension;
            header('Location:../edit_article.php?id_article='. $_POST['id_article']);
            $error = TRUE;
            exit(0);
        }

        //Si erreur random
        if($error)
        {
            $_SESSION['erreur_up'] = 'erreur random';
            header('Location:../edit_article.php?id_article='. $_POST['id_article']);
            $error = TRUE;
            exit(0);
        }

        else
        {
            $path = $folder . 'minia_a' . $_POST['id_article'] . '.' . $extension;
            move_uploaded_file($_FILES['miniature']['tmp_name'], $path);

            $sql = $connexion -> prepare('UPDATE article SET miniature = :minia, date_modification = :date_modif WHERE id_article = :id_article');

            $minia = 'minia_a' . $_POST['id_article'] . '.' . $extension;
            $date_modif = $_POST['date_modification'];
            $id_article = $_POST['id_article'];

            $sql -> bindParam(':minia', $minia, PDO::PARAM_STR);
            $sql -> bindParam(':date_modif', $date_modif, PDO::PARAM_STR);
            $sql -> bindParam(':id_article', $id_article, PDO::PARAM_INT);
            $sql -> execute();

            $width = getimagesize($path)[0];
            $height = getimagesize($path)[1];
            $name = 'minia_a' . $_POST['id_article'];

            
            $gallerie = $connexion -> prepare('UPDATE gallerie SET extension = :extension, size = :size, width = :width, height = :height WHERE name = :miniature');

            $gallerie -> bindParam(':extension', $extension, PDO::PARAM_STR);
            $gallerie -> bindParam(':size', $size, PDO::PARAM_INT);
            $gallerie -> bindParam(':width', $width, PDO::PARAM_INT);
            $gallerie -> bindParam(':height', $height, PDO::PARAM_INT);
            $gallerie -> bindParam(':miniature', $name, PDO::PARAM_STR);

            $gallerie -> execute();
        }
    }

    $id = $_POST['id_article'];
    $date = $_POST['date_modification'];

    if(isset($_POST['new_title']))
    {
        $title = $_POST['new_title'];

        $sql = $connexion -> prepare('UPDATE article SET titre = :title, date_modification = :date_modif WHERE id_article = :id');

        $sql -> bindParam(':title', $title, PDO::PARAM_STR);
        $sql -> bindParam(':date_modif', $date, PDO::PARAM_STR);
        $sql -> bindParam(':id', $id, PDO::PARAM_INT);

        $sql ->execute();
    }

    if(isset($_POST['new_content']))
    {
        $content = $_POST['new_content'];

        $sql = $connexion -> prepare('UPDATE article SET content = :content, date_modification = :date_modif WHERE id_article = :id');

        $sql -> bindParam(':content', $content, PDO::PARAM_STR);
        $sql -> bindParam(':date_modif', $date, PDO::PARAM_STR);
        $sql -> bindParam(':id', $id, PDO::PARAM_INT);

        $sql -> execute();
    }

    header('Location:../index.php');
    exit(0);
}

else
{
    header("Location:../index.php");
    exit(0);
}

?>