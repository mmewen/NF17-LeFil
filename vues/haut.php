<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Le Fil numérique | Site NF17</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
	    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
	    <link href="css/theme.css" rel="stylesheet">
	</head>
	<body role="document">

		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="?">Le Fil</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<?php
						if (!empty($_GET['module'])){
							$module = $_GET['module'];
						} else {
							$module = "accueil";
						}
					?>
					<ul class="nav navbar-nav">
						<li<?php if($module=="accueil") echo ' class="active"'; ?>><a href="?">Accueil</a></li>
						<li<?php if($module=="article") echo ' class="active"'; ?>><a href="?module=article">Articles</a></li>
						<li<?php if($module=="article") echo ' class="active"'; ?>><a href="?module=article&page=rubriques">Rubriques</a></li>
					<?php
					if (isset($_SESSION['Administrateur']) && $_SESSION['Administrateur']){
						echo ('<li '.(($module=="administration")?'class="active"':'').' >');
						echo ('<a href="?module=administration">Administration</a></li>');
					}
					if (isset($_SESSION['Auteur']) && $_SESSION['Auteur']){
						echo ('<li '.(($module=="auteur")?'class="active"':'').' >');
						echo ('<a href="?module=auteur">Auteur</a></li>');
					}
					if (isset($_SESSION['Editeur']) && $_SESSION['Editeur']){
						echo ('<li '.(($module=="edition")?'class="active"':'').' >');
						echo ('<a href="?module=edition">Edition</a></li>');
					}
					if (isset($_SESSION['Moderateur']) && $_SESSION['Moderateur']){
						echo ('<li '.(($module=="moderation")?'class="active"':'').' >');
						echo ('<a href="?module=moderation">Moderation</a></li>');
					}
					?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php
							if (isset($_SESSION['login'])){ ?>
								<li><a>Connecté en tant que <?php echo $_SESSION['login']; ?></a></li>
								<li><a href="?module=connexion&page=deconnexion">Déconnexion</a></li>
							<?php } else { ?>
								<li><a href="?module=connexion">Connexion</a></li>
							<?php }
						?>
					</ul>
				</div>
			</div>
	    </nav>

	    <div class="container theme-showcase main" role="main">