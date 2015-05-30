<div class="jumbotron">
	<h1>Gestion de vos articles</h1>
</div>

<p><a href="?module=auteur">Retourner à la gestion des articles</a></p>

<div class="page-header">
	<h1>Création d'article</h1>
</div>
<p>

<div style="width:25%;">
	<form action="?module=auteur&page=ajouter_article" method="POST">
		<div class="form-group">
			<label for="titre">Titre:</label>
			<input type="text" class="form-control" name="titre" id="titre">
		</div>
		<div class="form-group">
			<label for="titretexte">Titre de votre texte:</label>
			<input type="text" class="form-control" name="titretexte" id="titretexte">
		</div>
		<div class="form-group">
			<label for="corps">Texte:</label>
			<textarea class="form-control" rows="10" name="corps" id="corps"></textarea>
		</div>
		<button type="submit" class="btn btn-default">Créer l'article</button>
	</form>
</div>

</p>