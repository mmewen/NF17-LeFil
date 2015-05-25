<div class="jumbotron">
	<h1><?php echo($nomRubriqueMere); ?></h1>
</div>
<?php
if (!empty($rubriques)){
	?>
	<div class="page-header">
		<h1>Sous-rubriques</h1>
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
	<h1>Articles de cette rubrique</h1>
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