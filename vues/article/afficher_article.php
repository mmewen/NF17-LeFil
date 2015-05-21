<div class="jumbotron">
	<h1><?php echo $article['article_titre']; ?></h1>
	<p>truc</p>
</div>

<p>
	<?php echo nl2br($article['texte_corps']); ?>
</p>

<p>
	Auteur
</p>

<p>
	Article associé
	<?php var_dump($article); ?>
</p>


<div class="page-header">
	<h1>Commentaires</h1>
</div>
<p>
	Commentaires en exergue d'abord <br>
	Les autres après
</p>