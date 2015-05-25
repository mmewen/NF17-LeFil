<div class="jumbotron">
	<h1>Page par défaut du module "article"</h1>
	<p>'faut un peu d'imagination</p>
</div>
<?php
var_dump($rubriques);
if ($articles_honneur){
	?>
	<div class="page-header">
		<h1>À l'honneur</h1>
	</div>
	<p>
		On dit là ya plein d'articles bien, genre celui-là : <a href="?module=article&page=afficher_article&article=1">><</a>

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