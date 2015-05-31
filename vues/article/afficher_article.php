<div class="jumbotron">
	<h1><?php echo $article['article_titre']; ?></h1>
</div>

<p>
	<?php 
	foreach ($textes as $t) {
		echo('<h2>'.$t["texte_titre"].'</h2>');
		echo nl2br($t["texte_corps"]);
	}
	?>
</p>

<strong>
<p>
<br>
	<h4>Auteur : <?php echo get_auteur($article["article_id"]); ?></h4>
	Commité éditorial : <?php echo get_comite($article["article_id"]); ?><br>
	Articles associés : 
	<?php
	$articles_asso = get_article_asso($article["article_id"],$article["article_titre"]);
		foreach($articles_asso as $li){
					if($li["assocartart_article1"]==$article["article_id"]){
						echo('<a href="?module=article&page=afficher_article&article='.$li["assocartart_article2"].'"">'.$li["article_titre"].'</a> ');
					}
					if($li["assocartart_article2"]==$article["article_id"]){
						echo('<a href="?module=article&page=afficher_article&article='.$li["assocartart_article1"].'"">'.$li["article_titre"].'</a> ');
					}
				}			
	?>

</p>
</strong>

<p>
	<br>
	<?php
		if ($tags){
			echo ('<h3>Tags</h3>');

			foreach ($tags as $tag) {
				echo '<h4><span class="label label-default">'.nl2br($tag["motsclefs_corps"].'</span></h4>');
			}
		} else {
			echo ('Cet article ne possède pas encore de tag.');
		}
	?>
</p>


<div class="page-header">
	<h2>Commentaires</h2>
</div>
<p>
	<?php
	if ($commsEnExergue){
		echo ('<h3>Commentaires mis en avant</h3>');

		foreach ($commsEnExergue as $com) {
			echo('<h4>'.$com["commentaire_titre"].' - écrit par '.$com["commentaire_createur"].' le '.$com["commentaire_datecreation"].'</h4>');
			echo '<p>'.nl2br($com["commentaire_corps"].'</p>');
		}
		echo '<hr>';
	}
	if ($commsAutres){
		foreach ($commsAutres as $com) {
			echo('<h4>'.$com["commentaire_titre"].' - écrit par '.$com["commentaire_createur"].' le '.$com["commentaire_datecreation"].'</h4>');
			echo '<p>'.nl2br($com["commentaire_corps"].'</p>');
		}
	}

	if(isset($_SESSION['Lecteur']) && $_SESSION['Lecteur'] > 0){
		// Alors on a le droit de commenter :
		?>
		<h2>Poster un commentaire</h2>
		<form action="?module=article&page=commenter&article=<?php echo($article["article_id"]); ?>" method="POST">
			<div class="form-group">
				<label for="titre">Titre du commentaire</label>
				<input type="text" class="form-control" id="titre" name="titre" placeholder="Dites quelque chose de gentil :)">
			</div>
			<div class="form-group">
				<label for="com">Contenu du commentaire</label>
				<textarea class="form-control" id="com" name="com" placeholder="Dites aussi un truc sympa"></textarea>
			</div>
			<button type="submit" class="btn btn-default">Poster un commentaire</button>
		</form>
		<?php
	}?>
</p>