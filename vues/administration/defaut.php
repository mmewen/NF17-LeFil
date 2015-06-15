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
				$dr="";
				$i = 0;
				foreach($comptes as $co){
					if(!empty($droits[$i]["admin_login"])){
						$dr=$dr." Administrateur ";
					}
					if(!empty($droits[$i]["auteur_login"])){
						$dr=$dr." Auteur ";
					}
					if(!empty($droits[$i]["editeur_login"])){
						$dr=$dr." Editeur ";
					}
					if(!empty($droits[$i]["lecteur_login"])){
						$dr=$dr." Lecteur ";
					}
					if(!empty($droits[$i]["moderateur_login"])){
						$dr=$dr." Moderateur ";
					}
						echo "<option value =".$co["personne_login"].">".$co["personne_login"]." - ".$dr."</option>" ;
						$i++;
						$dr = "";
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