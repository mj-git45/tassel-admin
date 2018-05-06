<?php

session_start();
require_once("connexion_bdd.php");

if ($_SESSION['logged'] === FALSE)
{
	header('Location:../index.php');
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

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="description" content="CSS UI - Dashboard">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../../img/logo.png"/>
	<title>CSS UI - Dashboard</title>

	<!-- CSS styles -->
	<link rel="stylesheet" href="../../styles/style.backoffice.css">
	<link rel="stylesheet" href="../../styles/style.responsive.theme.css">
	<link rel="stylesheet" href="../../styles/edit_article.css">
</head>
<body id="dash">
	<!-- navigation -->
	<div class="nav">

		<!-- click menu -->
		<div class="click">
			<i class="fa fa-bars menu" aria-hidden="true"></i>
		</div>

		<!-- sidebar -->
		<div class="sidebar">

			<!-- sidebar title -->
			<div class="title">
				<img src="../../img/logo.png">
			</div>

			<div class="responsive">

				<!-- sidebar menu -->
				<ul class="menu">

					<!-- languages -->


					<!-- dashboard -->
					<li class="dashboard menu">
						<span class="clear">
							<span class="float left">Overview</span>
							<span class="float right"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
						</span>
						<ul>
						    	<li><a href=""><i class="fa fa-circle-o icon" aria-hidden="true"></i>Accueil</a></li>
							<li><a href=""><i class="fa fa-circle-o icon" aria-hidden="true"></i>Paramètres</a></li>
							<li><a href=""><i class="fa fa-circle-o icon" aria-hidden="true"></i>Notifications</a></li>
						</ul>
					</li>

					<!-- blog -->
					<li>
						<span class="clear">
							<span class="float left">Blog</span>
							<span class="float right"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
						</span>
						<ul>
						    	<li><a href="">Add</a></li>
							<li><a href="">List</a></li>
						</ul>
					</li>

					<!-- mmmbers -->
					<li>
						<span class="clear">
							<span class="float left">Membres</span>
							<span class="float right"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
						</span>
						<ul>
						    	<li><a href="">Registred</a></li>
							<li><a href="">Banned</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<!-- header and content wrapper -->
	<div class="wrapping">
		<div class="header">
			<div class="clear">

				<!-- dashboard menu -->
				<div class="float left">
					<ul class="header-menu">
						<li><a href="" class="current"><i class="fa fa-home" aria-hidden="true"></i><span>Home</span></a></li>
						<li><a href=""><i class="fa fa-cog" aria-hidden="true"></i><span>Settings</span></a></li>
						<li><a href=""><i class="fa fa-bell-o" aria-hidden="true"></i><span>Notification<span class="notifications">3</span></span></a></li>
					</ul>
				</div>

				<!-- user panel -->
				<div class="float right user panel">

					<!-- user and gravatar -->
					<div class="float left logged in">
						<ul class="clear">
							<li class="user float left"><?php echo 'Logged in as ' . $compte['username'];  ?></li>
							<li class="gravatar float left"><img src=<?php echo '"../../img/' . $compte['profile_pic'] . '"'; ?> alt="user"></li>
						</ul>
					</div>

					<!-- dropdown menu -->
					<div class="float left">
						<div class="dropdown">

							<!-- dropdown menu click -->
							<div class="clear">
								<a class="employ-toggle click float right" href="#">
									<i class="fa fa-ellipsis-v " aria-hidden="true"></i>
								</a>
							</div>

							<!-- show or hide menu -->
							<ul class="expand-dropdown">
								<li><a href="#" class="top">Profile</a></li>
								<li><a href="control/logout.php" class="bottom">Logout</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- content -->
		<div class="content">
			<?php

			$_POST['id_article_edit'] ? $a = $_POST['id_article_edit'] : $a = $_GET['id_article'];

			//On recherche l'article sur la bdd
			$sql = $connexion -> prepare("SELECT * FROM article WHERE id_article = $a");
			$sql  -> execute();
			$article = $sql -> fetch(PDO::FETCH_OBJ);

			echo '<h4 style="margin:0;">Currently editing : '. $article -> titre.'</h4>';

			?>

			<div class="content-box">
		
			<?php

			$date = date('Y-m-d');

			?>

			<form method="post" action="control/edit_article.php" id="form_edit" target="_blank" enctype="multipart/form-data">
				<input type="hidden" value="<?php echo $article -> id_article; ?>" name="id_article">
				<input type="hidden" value="<?php echo $date; ?>" name="date_modification">
				<input type="file" name="miniature" id="upload_minia" accept="image/x-png,image/gif,image/jpeg,image/jpg" onchange="preview_minia()" style="display:none"> 
			</form>

			<table class="full width">
				<colgroup>
					<col width="20%">
					<col width="40%">
					<col width="40%">
				</colgroup>
				<tr>
					<th><input type="reset" value="Réinitialiser le formulaire" form="form_edit" onclick="reset_preview()" style="margin:0"></th>
					<th>Old</th>
					<th>New</th>
				</tr>
				
				<tr class="tr hover">
					<td>Title</td>
					<td><?php echo $article -> titre; ?></td>
					<td><button class="reset_btn" onclick="reset_title()"><i class="fa fa-times"></i></button><div class="clear"></div><input type="text" maxlength="100" name="new_title" form="form_edit" placeholder="Le nouveau titre de l'article" style="width:500px" id="new_title"></td>
				</tr>
				<tr class="tr hover">
					<td>Thumbnail</td>
					<td><img src="../../img/articles/<?php echo $article -> miniature; ?>"></td>
					<td>
						<button class="reset_btn" onclick="reset_minia()"><i class="fa fa-times"></i></button>
						<div class="clear"></div>
						<img src="" alt="Preview miniature" id="preview_minia" >
						<button id="btn_input" onclick="document.getElementById('upload_minia').click()">Change Thumbnail</button>
					</td>
				</tr>
				<tr class="tr hover">
					<td>Content</td>
					<td id="content_article"><?php echo $article -> content; ?></td>
					<td><button class="reset_btn" onclick="reset_content()"><i class="fa fa-times"></i></button><div class="clear"></div><textarea rows="10" cols="5" form="form_edit" placeholder="Le nouveau contenu de l'article" id="new_content" name="new_content"></textarea></td>
				</tr>
			</table>

			<div class="tooltip">
				<input type="submit" name="send_edit" value="Send modifications" class="full width" form="form_edit" style="font-weight:bold;">
				<span class="tooltiptext"><strong>Warning : </strong>These changes are <strong>NOT</strong> reversible</span>
			</div>

			</div>
			</div>
		</div>
	</div>

	<!-- javascript libraries and plugins  -->
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/jquery.responsive.menu.js"></script>
	<script src="../../js/jquery.dropdown.menu.js"></script>
	<script src="../../js/nanobar.min.js"></script>
	<script src="../../js/custom.js"></script>
	<script src="../../js/edit_article.js"></script>
</body>
</html>
