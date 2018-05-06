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
			<h4>Overview</h4>
			<div class="content-box">
				<h4>Articles</h4>
				<table class="full width">
					<tr>
						<th style="display:none"></style>>#</th>
						<th>Username</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
					<tr class="tr hover">
						<td style="display:none">1</td>
						<td>Root</td>
						<td>root@domain.com</td>
						<td>
							<a href="" class="action-button edit"><i class="fa fa-pencil"></i></a>
							<a href="" class="action-button delete"><i class="fa fa-trash"></i></a>
							<a href="#root" class="action-button detail"><i class="fa fa-search"></i></a>
						</td>
					</tr>
					<tr class="tr hover">
						<td style="display:none">2</td>
						<td>Admin</td>
						<td>admin@domain.com</td>
						<td>
							<a href="" class="action-button edit"><i class="fa fa-pencil"></i></a>
							<a href="" class="action-button delete"><i class="fa fa-trash"></i></a>
							<a href="#admin" class="action-button detail"><i class="fa fa-search"></i></a>
						</td>
					</tr>
					<tr class="tr hover">
						<td style="display:none">3</td>
						<td>User</td>
						<td>user@domain.com</td>
						<td>
							<a href="" class="action-button edit"><i class="fa fa-pencil"></i></a>
							<a href="" class="action-button delete"><i class="fa fa-trash"></i></a>
							<a href="#user" class="action-button detail"><i class="fa fa-search"></i></a>
						</td>
					</tr>
				</table>
				<!-- Les articles -->

				<?php

				//On recherche tous les articles sur la bdd
				$sql = $connexion -> prepare("SELECT * FROM article");
				$sql -> execute();
				$articles = $sql -> fetchAll(PDO::FETCH_OBJ);

				
				?>

				<h4>Articles</h4>
				<table class="full width">
					<tr>
						<th>Title</th>
						<th>Author</th>
						<th>Thumbnail</th>
						<th>Last Modified</th>
						<th>Action</th>
					</tr>
					<?php

					foreach($articles as $article)
					{
						echo '<tr class="tr hover">';

						foreach($article as $key => $value)
						{
							if($key == 'date_modification')
							{
								if(empty($value))
								{
									$value = $article -> date_publication;
								}

								$date = DateTime::createFromformat('Y-m-d', $value);
								$value = $date -> format('d/m/y');
							}

							if($key != 'id_article' && $key != 'date_publication' && $key != 'content')
							{
								if($key == 'miniature')
								{
									echo '<td><img src="../../img/articles/'. $value .'" style="max-height:75px"></td>';
								}

								else
								{
									echo '<td>' . $value . '</td>';
								}
								
							}
						}

						echo '
							<td>							
								<form action="edit_article.php" method="post" target="_blank" id="form_edit_article_'. $article -> id_article .'">
									<input type="hidden"  value="'. $article -> id_article .'" name="id_article_edit">
									<input type="submit" value="send_edit" name="send edit" style="display:none">
								</form>
								<form action="delete_article.php" method="post" target="_blank" id="form_delete_article_'. $article -> id_article .'">
									<input type="hidden"  value="'. $article -> id_article .'" name="id_article_delete">
									<input type="submit" value="send_delete" name="send delete" style="display:none">
								</form>
								<div class="action-button edit" onclick="submit_edit_form('. $article -> id_article .')"><i class="fa fa-pencil"></i></div>
							<div class="action-button delete" onclick="submit_delete_form('. $article -> id_article .')"><i class="fa fa-trash"></i></div>
								<div class="action-button detail"><i class="fa fa-search"></i></div>

							</td>';

						echo '</tr>';
					}

					?>
				</table>
			</div>

				<!-- modal window -->
				<div id="root" class="modal">
					<div>
						<a href="#close" title="Close" class="close align center"><i class="fa fa-times" aria-hidden="true"></i></a>
						<h2>Root</h2>
						<p>root@domain.com</p>
					</div>
				</div>
				<div id="admin" class="modal">
					<div>
						<a href="#close" title="Close" class="close align center"><i class="fa fa-times" aria-hidden="true"></i></a>
						<h2>Admin</h2>
						<p>admin@domain.com</p>
					</div>
				</div>
				<div id="user" class="modal">
					<div>
						<a href="#close" title="Close" class="close align center"><i class="fa fa-times" aria-hidden="true"></i></a>
						<h2>User</h2>
						<p>user@domain.com</p>
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
	<script>
		var nanobar = new Nanobar(); nanobar.go(100);
	</script>
</body>
</html>
