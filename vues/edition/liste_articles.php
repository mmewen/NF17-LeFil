<div class="jumbotron">
	<h1>Gestion des articles</h1>
</div>

<?php
// Pour chaque catégorie d'article
?>
	<div class="page-header">
		<h1>Articles machin</h1>
	</div>
	<a href="?module=edition&page=editer_motcles_article&article=1">édition tags</a> 
	<a href="?module=edition&page=editer_rubrique_article&article=1">édition rubriques</a>
	<p>
		<?php 
	// Penser à utiliser commentaire_datesuppression + les historiques
		foreach ($comms as $com) {
			echo('<h4>'.$com["commentaire_titre"].' - écrit par '.$com["lecteur_login"].' le '.$com["commentaire_datecreation"].
				' sur l\'article <a href="?module=article&page=afficher_article&article='.$com['commentaire_article'].'">'.$com['article_titre'].'</a> - ');

			if ($com["commentaire_masque"] == 't'){
				echo "<span class='label label-primary'>Masqué</span> ";
			} else {
				echo "<span class='label label-default'>Affichable</span> ";
			}

			if ($com["commentaire_enexergue"] == 't'){
				echo "<span class='label label-info'>En exergue</span> ";
			} else {
				echo "<span class='label label-default'>Pas en exergue</span> ";
			}

			if ($com["commentaire_supprime"] == 't'){
				echo "<span class='label label-warning'>Supprimé</span> ";
			} else {
				echo "<span class='label label-default'>Pas supprimé</span> ";
			}

			echo(' - <a href="?module=moderation&page=editer_commentaire&commentaire='.$com["commentaire_id"].'">Éditer</a></h4>');

			?>
			<div class="well">
	        <p><?php echo(nl2br($com["commentaire_corps"])); ?></p>
	      	</div><br><?php
		}?>
	</p>
	<?php
// end pour chaque type d'article