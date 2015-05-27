<div class="jumbotron">
	<h1>Edition d'une rubrique</h1>
	Celle qu'on appelle "<?php echo($nom_rubrique); ?>" dans le milieu...
</div>

<a href="?module=edition&page=gerer_rubriques">Retourner à la gestion des rubriques</a>

<p>
	<?php 
	if(!$rubrique_mere){
		echo('<p>Cette rubrique ne possède pas de rubrique mère.</p>');
	} else {
		echo ('<div class="page-header"><h3>Rubrique mère : '.$rubrique_mere['nom_mere'].'</h3></div>');
	}

	if(!$rubriques_filles){
		echo('<p>Cette rubrique ne possède pas de rubriques filles.</p>');
	} else {
		echo ('<h3>Rubrique(s) fille :</h3>
			<div class="list-group" style="width:25%;">');
		foreach ($rubriques_filles as $rubrique_fille) {
			echo ('<li class="list-group-item">'.$rubrique_fille["nom_fille"].'</li>');
		}
		echo("</div>");
	}

	// Renommer
	?>
	<div class="page-header"><h3>Changer le nom de la rubrique</h3></div>
	<div style="width:25%;">
		<form action="?module=edition&page=renommer_rubrique&rubrique=<?php echo($rubrique); ?>" method="POST">
			<div class="form-group">
				<input type="text" class="form-control" id="nouveau_nom" name="nouveau_nom" placeholder="Rechercher un article ou une rubrique"
					value="<?php echo($nom_rubrique); ?>">
			</div>
			<button type="submit" class="btn btn-default">Modifier le nom de la rubrique</button>
		</form>
	</div>

	<div class="page-header"><h3>Changer la rubrique mère</h3></div>
	<?php
	if(count($rubriques_mere_potentielles)>0){ ?>
		<div style="width:25%;">
			<form action="?module=edition&page=modifier_mere_rubrique&rubrique=<?php echo($rubrique); ?>" method="POST">
				<div class="form-group">
					<select class="form-control" id="future_maman" name="future_maman">
						<?php 
						foreach ($rubriques_mere_potentielles as $future_maman) {
							echo("<option value='".$future_maman["id_mere"]."'>".$future_maman["nom_mere"]."</option>");
						}?>
					</select>
				</div>
				<button type="submit" class="btn btn-default">Modifier la rubrique mère</button>
			</form>
		</div>
		<?php
	} else {
		echo("Dans l'état actuel des choses, ya pas moyen de lui trouver une autre maman !");
	} ?>
</p>