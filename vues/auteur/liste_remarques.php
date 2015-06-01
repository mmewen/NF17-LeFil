<div class="jumbotron">
	<h1>Remarques sur l'article <?php echo $article['article_titre']; ?></a></h1>
</div>
<p>
Revenir à la <a href="?module=auteur">gestion des articles</a>
	<div class="list-group">
		<?php
		foreach ($remarques as $remarque) {
		?>
			<li class="list-group-item">
				<h4 class="list-group-item-heading">Le <?php echo($remarque["remarque_date"]); ?> lors <?php echo($remarque["remarque_statut"]=="Rejete"?"du rejet":"de la demande de révision"); ?> du comité éditorial</h4>
				<p class="list-group-item-text"><?php echo(nl2br($remarque["remarque_corps"])); ?></p>
			</li>
			<?php
		} ?>
	</div>
</p>
