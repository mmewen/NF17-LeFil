<?php
// Pour les mots clés actuels
?>
<p><a href="?module=edition&page=gerer_articles">Retourner à la gestion des articles</a></p>
<div class="page-header"><h1><?php echo($article['article_titre']); ?></h1>

<div class="page-header"><h3>Mots clés actuels</h3></div>
	<p style="opacity:0.5; font-style:italic;">Cliquez sur un des mots-clés pour le supprimer</p>
<?php

foreach ($motscles as $motcle) {
	if (intval($motcle["indexart_article"]) == $id_article){
		echo(" <a href='?module=edition&page=supprimer_mot_cle&article=".$id_article."&id_mot_cle=".$motcle["motsclefs_id"]."' title='Supprimer le mot-clé'>");
		echo("<button type='button' class='btn btn-lg btn-info'>".$motcle["motsclefs_corps"]."</button>");
		echo("</a>");
	}
}

// Pour en ajouter un
?>

<div class="page-header"><h3>Ajouter un mot clé</h3></div>
<div style="width:25%;">
	<form action="?module=edition&page=ajouter_mot_cle&article=<?php echo($id_article); ?>" method="POST">
		<div class="form-group">
			<select class="form-control" id="id_mot_cle" name="id_mot_cle">
				<?php 
				foreach ($motscles as $motcle) {
					if (intval($motcle["indexart_article"]) != $id_article)
					echo("<option value='".$motcle["motsclefs_id"]."'>".$motcle["motsclefs_corps"]."</option>");
				}?>
			</select>
		</div>
		<button type="submit" class="btn btn-default">Ajouter le mot clé</button>
	</form>
</div>
</div>
<?php
?>