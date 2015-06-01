<div class="jumbotron">
	<h1><?php echo $article['article_titre']; ?></h1>
</div>

<p><a href="?module=edition&page=gerer_articles">Retourner à la gestion des articles</a></p>


<p>
	<?php 
	foreach ($textes as $t) {
		echo('<h2>'.$t["texte_titre"].'</h2>');
		echo nl2br($t["texte_corps"]);
	}
	?>
</p>
<br>
<a href="?module=edition&page=editer_article&article=<?php echo $article['article_id']; ?>">
	<button type="button" class="btn btn-sm btn-success">Éditer</button>
</a>

<strong>
<p>
<br>
	<h4>Auteur : <?php echo $auteur['personne_prenom'].' '.$auteur['personne_nom']; ?></h4>
</p>
</strong>
