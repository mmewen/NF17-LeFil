<div class="jumbotron">
	<h1><?php echo($nomRubriqueMere); ?></h1>
</div>

<form action="?module=article&page=rechercher" method="POST">
	<div class="form-group">
		<input type="text" class="form-control" id="recherche" name="recherche" placeholder="Rechercher un article ou une rubrique" <?php
		if (isset($_POST["recherche"]) && !empty($_POST["recherche"])){
			echo("value=".$_POST["recherche"]);
		}
		?>>
	</div>
	<button type="submit" class="btn btn-default">Rechercher</button>
</form>

<hr>


<?php
if (!empty($rubriques)){
	?>
	<div class="page-header">
		<h1>Rubriques</h1>
	</div>
	<p>
		<div class="list-group"><?php
			foreach ($rubriques as $rubrique) {
				?>
				<a href="?module=article&page=rubriques&rubrique=<?php echo($rubrique["id_sous_rubrique"]); ?>" class="list-group-item">
					<h4 class="list-group-item-heading"><?php echo($rubrique["nom_sous_rubrique"]); ?></h4>
				</a>
				<?php
			} ?>
		</div>
	</p>
	<?php
}
?>

<div class="page-header">
	<h1>Articles</h1>
</div>
<?php

echo ('<p>');
	if ($articles){
		echo ('<div class="list-group">');
		foreach ($articles as $article) {
		?>
			<a href="?module=article&page=afficher_article&article=<?php echo($article["article_id"]); ?>" class="list-group-item">
				<h4 class="list-group-item-heading"><?php echo($article["article_titre"]); ?></h4>
				<p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
			</a>
		<?php
			// echo nl2br($t["texte_corps"]);
		}
		echo ('</div>');
	} else {
		echo("Aucun article valable à afficher !");
	}
	?>
</p>