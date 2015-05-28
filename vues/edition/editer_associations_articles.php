<p><a href="?module=edition&page=gerer_articles">Retourner à la gestion des articles</a></p>
<div class="page-header"><h1><?php echo($article['article_titre']); ?> - gestion des articles associés</h1>

<div class="page-header"><h3>Associations actuelles</h3></div>
	<p style="opacity:0.5; font-style:italic;">Cliquez sur un des articles associés pour supprimer le lien</p>
<?php

foreach ($assoc_articles as $key => $assoc) {
	$art_en_lien = false;

	if (intval($assoc["id_art_1"]) == $id_article){
		$id_art2 = $assoc["id_art_2"];
		$nom_art2 = $assoc["titre_art_2"];
		$art_en_lien = true;
	}

	if (intval($assoc["id_art_2"]) == $id_article){
		$id_art2 = $assoc["id_art_1"];
		$nom_art2 = $assoc["titre_art_1"];
		$art_en_lien = true;
	}

	if ($art_en_lien && !empty($id_art2)) {
		echo(" <a href='?module=edition&page=supprimer_assoc_article&article=".$id_article."&article2=".$id_art2."' title='Supprimer le lien avec cet article'>");
		echo("<button type='button' class='btn btn-lg btn-info'>$nom_art2</button>");
		echo("</a>");
		unset($assoc_articles[$key]);
		
		// on unset aussi les lignes où art2 est "à gauche" :
		foreach ($assoc_articles as $keyb => $assocb) {
			if (intval($assocb["id_art_1"]) == $id_art2){
				unset($assoc_articles[$keyb]);
			}
		}
	}
}

foreach ($assoc_articles as $keyc => $assocc) {
	if ((intval($assocc["id_art_1"]) == $id_article) || (intval($assocc["id_art_2"]) == $id_article)){
		unset($assoc_articles[$keyc]);
	}
}

?>

<div class="page-header"><h3>Ajouter un article associé</h3></div>
<?php
if(count($assoc_articles) != 0){ ?>
	<div style="width:25%;">
		<form action="?module=edition&page=ajouter_assoc_article&article=<?php echo($id_article); ?>" method="POST">
			<div class="form-group">
				<select class="form-control" id="article2" name="article2">
					<?php 
					foreach ($assoc_articles as $assoc) {
						echo("<option value='".$assoc["id_art_1"]."'>".$assoc["titre_art_1"]."</option>");
					}?>
				</select>
			</div>
			<button type="submit" class="btn btn-default">Ajouter l'appartenance</button>
		</form>
	</div><?php
} else {
	echo("<p>Pas d'article disponible pour être associé avec celui-ci !</p>");
}
?>
</div>