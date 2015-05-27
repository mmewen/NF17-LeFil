<div class="jumbotron">
	<h1>Liste des articles</h1>
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
if ($articles_honneur){
	?>
	<div class="page-header">
		<h1>À l'honneur</h1>
	</div>
	<p>
		<div class="list-group"><?php
			foreach ($articles_honneur as $article) {
				?>
				<a href="?module=article&page=afficher_article&article=<?php echo($article["article_id"]); ?>" class="list-group-item">
					<h4 class="list-group-item-heading"><?php echo($article["article_titre"]); ?></h4>
					<p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
				</a>
				<?php
				// echo nl2br($t["texte_corps"]);
			} ?>
		</div>
	</p>

	<div class="page-header">
		<h1>Pas à l'honneur</h1>
	</div>
	<?php
}

echo ('<p>');
	if ($articles_pas_honneur){
		echo ('<div class="list-group">');
		foreach ($articles_pas_honneur as $article) {
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