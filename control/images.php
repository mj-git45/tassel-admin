<pre>

<?php

require_once('../connexion_bdd.php');

$minia_a1_1 = pathinfo('../../../img/articles/minia_a1.jpg');

$minia_a2_1 = pathinfo('../../../img/articles/minia_a2.jpg');

$minia_a3_1 = pathinfo('../../../img/articles/minia_a3.jpg');

$minia_a1_2 = getimagesize('../../../img/articles/minia_a1.jpg');
$minia_a2_2 = getimagesize('../../../img/articles/minia_a2.jpg');
$minia_a3_2 = getimagesize('../../../img/articles/minia_a3.jpg');

$name = $minia_a2_1['filename'];
$extension = $minia_a2_1['extension'];
$path = '/' . basename($minia_a2_1['dirname']); // basename(direname("file")) = file parent dir only
$size = filesize('../../../img/articles/minia_a2.jpg');
$width = $minia_a2_2[0];
$height = $minia_a2_2[1];


$sql = $connexion -> prepare('INSERT INTO gallerie (name, extension, path, size, width, height) VALUES (:name, :extension, :path, :size, :width, :height)');

$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':extension', $extension, PDO::PARAM_STR);
$sql -> bindParam(':path', $path, PDO::PARAM_STR);
$sql -> bindParam(':size', $size, PDO::PARAM_INT);
$sql -> bindParam(':width', $width, PDO::PARAM_INT);
$sql -> bindParam(':height', $height, PDO::PARAM_INT);

echo $sql -> execute();


?>

</pre>