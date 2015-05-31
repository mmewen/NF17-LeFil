<div class = "jumbotron">
	<h1>Gestion des comptes</h1>
</div>

<p><a href="?module=administration">Retourner à la gestion des comptes</a>

<div class="page-header">
	<h1>Création de comptes</h1>
</div>
<p>

<div style="width:25%;">
	<form action="?module=administration&page=ajouter_compte" method="POST">
		<div class="form-group">
			<label for="login">Login : </label>
			<input type="text" class"form-control" name="login" id="login">
		</div>
		<div class="form-group">
			<label for="mail">Mail : </label>
			<input type="text" class"form-control" name="mail" id="mail">
		</div>
		<div class="form-group">
			<label for="mail">Prénom : </label>
			<input type="text" class"form-control" name="prenom" id="prenom">
		</div>
		<div class="form-group">
			<label for="mail">Nom : </label>
			<input type="text" class"form-control" name="nom" id="nom">
		</div>
		<div class="form-group">
			<label for="type">Type : </label>
			<select name="type" id="type">
				<option value="L">Lecteur</option>
				<option value="A">Auteur</option>
				<option value="E">Editeur</option>
				<option value="M">Moderateur</option>
				<option value="Ad">Administrateur</option>
			</select>
		</div>
		<button type="submit" class="btn btn-default">Créer le compte</button>
	</form>
</div>
</p>
