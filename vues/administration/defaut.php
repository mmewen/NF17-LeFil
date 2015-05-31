<div class = "jumbotron">
	<h1>Gestion des comptes</h1>
</div>

<a href="?module=administration&page=creer_compte"> Créer un compte </a>	

<div class="page-header">
	<h1>Liste des comptes</h1>
</div>

<p>
	<form action="?module=administration&page=modif_compte" method="POST">
	<div style="width:25%;">
		<div class = "form-group">
			<label for="compte">Comptes : </label>
			<select name="compte" id="compte">
			<?php
			$comptes = get_comptes();
			if(is_bool($comptes)){
				echo("<option value='NA'>Pas de comptes à afficher</option>");
			} else {
				foreach($comptes as $co){
					//$l = $co["personne_login"];
					echo "<option value =".$co.">$l</option>";			//DECONNE !!
				}
			}
				?>
			</select>
		</div>
			<div class = "form-group">
				<label for="droit">Catégorie : </label>
				<select name="droit" id="droit">
					<option value="L">Lecteur</option>
					<option value="A">Auteur</option>
					<option value="E">Editeur</option>
					<option value="M">Moderateur</option>
					<option value="Ad">Administrateur</option>
				</select>
			</div>
		<button type="submit" class="btn btn-default"> Modifier les droits </button>
	</div>
	</form>
</p>