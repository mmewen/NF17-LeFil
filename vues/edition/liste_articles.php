<div class="jumbotron">
	<h1>Gestion des articles</h1>
</div>

<?php
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
		<h4 class="list-group-item-heading"><?php echo($article["article_titre"].' - écrit par '.$article["auteur_login"].' - comité éditorial : '.$article["comedit_groupenom"].' - '); ?>

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

				?>

			<a id="truc" style=" color:gray; font-size:10px; margin-left: 20px; cursor:pointer;" onclick="$($(this).parent()[0]).next().slideToggle();">
				Afficher/cacher les options
			</a>
		</h4>
		<p class="options" style="display: none;">
			<br>
			<a href="?module=edition&page=editer_motcles_article&article=<?php echo $article['article_id']; ?>">
	        	<button type="button" class="btn btn-sm btn-default">Gérer les mots-clés de l'article</button>
			</a> 
			<a href="?module=edition&page=editer_rubrique_article&article=<?php echo $article['article_id']; ?>">
	        	<button type="button" class="btn btn-sm btn-default">Éditer les rubriques mères</button>
			</a>
			<a href="?module=edition&page=editer_associations_articles&article=<?php echo $article['article_id']; ?>">
	        	<button type="button" class="btn btn-sm btn-default">Gérer les articles associés</button>
			</a>
			<?php
			if ($article["article_honneur"] != 't'){?>
				<a href="?module=edition&page=fvrgsgfcdvsb&article=<?php echo $article['article_id']; ?>">
		        	<button type="button" class="btn btn-sm btn-default">Mettre à l'honneur</button>
				</a><?php
			} else {?>
				<a href="?module=edition&page=fvrgsgfcdvsb&article=<?php echo $article['article_id']; ?>">
		        	<button type="button" class="btn btn-sm btn-default">Ne plus mettre à l'honneur</button>
				</a><?php
			}
			?>
			<a href="?module=edition&page=cfds&article=<?php echo $article['article_id']; ?>">
	        	<button type="button" class="btn btn-sm btn-success">Editer</button>
			</a>
			<a href="?module=edition&page=cfds&article=<?php echo $article['article_id']; ?>">
	        	<button type="button" class="btn btn-sm btn-primary">Changer de statut</button>
			</a>
	        <button type="button" class="btn btn-sm btn-danger" onclick="alert('Pour l\'instant, ça marche pas :P mais \'faut avouer que le bouton est joli !');">Supprimer</button>
        </p>
	</li>
	<?php
}
// end pour chaque type d'article
?>