<?php
// Pour les rubriques actuelless
?>
<p><a href="?module=edition&page=gerer_articles">Retourner à la gestion des articles</a></p>
<div class="page-header"><h1><?php echo($article['article_titre']); ?> - gestion des rubriques</h1>

<div class="page-header"><h3>Rubriques actuelless</h3></div>
	<p style="opacity:0.5; font-style:italic;">Cliquez sur une des rubriques pour la supprimer</p>
<?php

foreach ($rubriques as $rubrique) {
	if (intval($rubrique["article_id"]) == $id_article){
		echo(" <a href='?module=edition&page=supprimer_rubrique_article&article=".$id_article."&id_rubrique=".$rubrique["rubrique_id"]."' title='Supprimer le mot-clé'>");
		echo("<button type='button' class='btn btn-lg btn-info'>".$rubrique["rubrique_nom"]."</button>");
		echo("</a>");
	}
}

// Pour en ajouter une
?>

<div class="page-header"><h3>Ajouter l'article à une autre rubrique</h3></div>
<div style="width:25%;">
	<form action="?module=edition&page=ajouter_rubrique_article&article=<?php echo($id_article); ?>" method="POST">
		<div class="form-group">
			<select class="form-control" id="id_rubrique" name="id_rubrique">
				<?php 
				foreach ($rubriques as $rubrique) {
					if (intval($rubrique["article_id"]) != $id_article)
					echo("<option value='".$rubrique["rubrique_id"]."'>".$rubrique["rubrique_nom"]."</option>");
				}?>
			</select>
		</div>
		<button type="submit" class="btn btn-default">Ajouter l'appartenance</button>
	</form>
</div>
</div>
<?php
?>