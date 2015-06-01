<?php

function afficher_li_article($article, $trier_par){ ?>
	<li class="list-group-item">
		<h4 class="list-group-item-heading"><?php

			echo($article["article_titre"].' </h4>écrit par '.$article["auteur_login"]." - le ".$article["date"].' - comité éditorial : '.$article["comedit_groupenom"].' - ');

			if ($trier_par != "statut"){
				echo "<span class='label label-warning'> Statut : ";
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
						echo "rejeté";
						break;
					case 'Valide':
						echo "validé";
						break;
				}
				echo "</span> ";
			}

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
			<div style="float: right;">
				<a id="truc" style=" color:gray; font-size:10px; margin-left: 20px; cursor:pointer;" onclick="$($(this).parents()[0]).next().slideToggle();">
					Afficher/cacher les options
				</a>
			</div>
		<!-- </h4> -->
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
				<a href="?module=edition&page=mettre_article_honneur&article=<?php echo $article['article_id']; ?>">
		        	<button type="button" class="btn btn-sm btn-default">Mettre à l'honneur</button>
				</a><?php
			} else {?>
				<a href="?module=edition&page=enlever_article_honneur&article=<?php echo $article['article_id']; ?>">
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
	</li><?php
}






// ===================== DÉBUT RÉEL DE LA PAGE ==============================


?>
<div class="jumbotron">
	<h1>Gestion des articles</h1>
</div>
Trier par
<?php if ($trier_par != "auteur") { ?><a href="?module=edition&page=gerer_articles&trier_par=auteur">auteur</a> <?php }; ?>
<?php if ($trier_par != "date") { ?><a href="?module=edition&page=gerer_articles&trier_par=date">date</a> <?php }; ?>
<?php if ($trier_par != "statut") { ?><a href="?module=edition&page=gerer_articles&trier_par=statut">statut</a> <?php }; ?>
<?php
$previous_status = null;
// Pour chaque catégorie d'article
if ($trier_par == "statut") {
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
		}

		afficher_li_article($article, $trier_par);
	}
	// end pour chaque type d'article
} else if ($trier_par == "auteur") {
	echo '<hr><div class="list-group">';
	foreach ($articles as $article) {
		afficher_li_article($article, $trier_par);
	}
	echo '</div>';
} else if ($trier_par == "date") {
	echo '<hr><div class="list-group">';
	foreach ($articles as $article) {
		afficher_li_article($article, $trier_par);
	}
	echo '</div>';
}
?>