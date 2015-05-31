<div class = "jumbotron">
	<h1>Gestion des comptes</h1>
</div>

<a href="?module=administration&page=creer_compte"> Créer un compte </a>	

<div class="page-header">
	<h1>Modification des droits</h1>
</div>

<p>
	<form action="?module=administration&page=modif_compte" method="POST">
	<div style="width:25%;">
		<div class = "form-group">
			<label for="compte">Comptes : </label>
			<select name="compte" id="compte">
			<?php
			if(is_bool($comptes)){
				echo("<option value='NA'>Pas de comptes à afficher</option>");
			} else {
				$i = 0;
				foreach($comptes as $co){
					echo "<option value =".$co[$i]["personne_login"].">".$co[$i]["personne_login"]."</option>" ;
					$i++;
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