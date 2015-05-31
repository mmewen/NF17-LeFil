<div class="jumbotron">
	<h1>Gestion des articles</h1>
</div>

<a href="?module=edition&page=editer_motcles_article&article=1">édition tags</a> 
<a href="?module=edition&page=editer_rubrique_article&article=1">édition rubriques</a>
<a href="?module=edition&page=editer_associations_articles&article=1">édition articles associés</a>


<?php
var_dump($articles);
$previous_status = null;
// Pour chaque catégorie d'article
foreach ($articles as $article) {
	if($previous_status != $article['statut'])
	{
		if(!empty($previous_status)){
			echo ('</div>'); // ferme le div list-group
		}
		$previous_status = $article['statut'];
		?>
		<div class="page-header">
			<h1> Article(s)
				<?php
				switch ($article['statut']) {
					case 'En_redaction':
						echo "en cours de redaction";
						break;
					case 'Soumis':
						echo "soumis";
						break;
					case 'En_relecture':
						echo "en relecture";
						break;
					case 'A_reviser':
						echo "à réviser";
						break;
					case 'Rejete':
						echo "rejeté(s)";
						break;
					case 'Valide':
						echo "validé(s)";
						break;
				}
				?>
			</h1>
		</div>
		<div class="list-group">
		<?php
	}?>
	<li class="list-group-item">
		<h4 class="list-group-item-heading"><?php echo($article["article_titre"].' - écrit par '.$article["auteur_login"].' - '); ?>

			<?php 

				// Penser à utiliser les historiques

				if ($article["article_publie"] == 't'){
					echo "<span class='label label-primary'>Publié</span> ";
				} else {
					echo "<span class='label label-default'>Non publié</span> ";
				}

				if ($article["article_honneur"] == 't'){
					echo "<span class='label label-info'>À l'honneur</span> ";
				} else {
					echo "<span class='label label-default'>Pas à l'honneur</span> ";
				}

				if ($article["article_supprime"] == 't'){
					echo "<span class='label label-warning'>Supprimé</span> ";
				} else {
					echo "<span class='label label-default'>Pas supprimé</span> ";
				}

				echo(' - <a href="?module=edition&page=editer_article&article='.$article["article_id"].'">Éditer</a></h4>');

				?>
		</h4>
		<hr>
		plouf
	</li>
	<?php
}
// end pour chaque type d'article
?>