<div class="jumbotron">
	<h1>Edition d'un commentaire</h1>
</div>

<p>
	<?php 
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

	echo(' </h4>');

	?>
	<div class="well">
    	<p><?php echo(nl2br($com["commentaire_corps"])); ?></p>
  	</div>
<?php
	if ($com["commentaire_masque"] == 't'){
		echo "<a href='?module=moderation&page=demasquer&commentaire=".$com["commentaire_id"]."'><span class='btn btn-lg btn-default'>Afficher</span></a> ";
	} else {
		echo "<a href='?module=moderation&page=masquer&commentaire=".$com["commentaire_id"]."'><span class='btn btn-lg btn-default'>Masquer</span></a> ";
	}

	if ($com["commentaire_enexergue"] == 'f'){
		echo "<a href='?module=moderation&page=exerguer&commentaire=".$com["commentaire_id"]."'><span class='btn btn-lg btn-default'>Mettre en exergue</span></a> ";
	}

	if ($com["commentaire_supprime"] == 'f'){
		echo "<a href='?module=moderation&page=supprimer&commentaire=".$com["commentaire_id"]."'><span class='btn btn-lg btn-warning'>Supprimer</span></a> ";
	}
?>
</p>