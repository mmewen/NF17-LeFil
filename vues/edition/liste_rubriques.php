<?php
$old_index = 0;

foreach ($rubriques as $rubrique) {
	if (intval($rubrique ["id_mere"]) != $old_index){ // On change de rubrique mère
		if($old_index != 0){
			echo('</div></div>'); // on ferme le div précédent
		}

		$old_index = intval($rubrique ["id_mere"]);
		// print du titre
		echo "<div class='col-sm-4'><div class='list-group'>";
		echo "<a href='?module=edition&page=editer_rubrique&rubrique=".$rubrique["id_mere"]."' class='list-group-item active'>".$rubrique["nom_mere"]."</a>";
	}
	// on print un truc normal
	?>
		<li class="list-group-item">
			<a href="?module=edition&page=editer_rubrique&rubrique=<?php echo $rubrique["id_fille"]; ?>">
				<?php echo $rubrique["nom_fille"]; ?>
			</a>
		</li>
	<?php
}

if($old_index != 0){
	echo('</div></div>'); // on ferme le dernier div
}
?>

<div class='col-sm-4'>
	<form action="?module=edition&page=ajouter_rubrique" method="POST">
		<div class="form-group">
			<input type="text" class="form-control" name="rubrique" placeholder="Ajouter une rubrique">
		</div>
		<button type="submit" class="btn btn-default">Ajouter</button>
	</form>
</div>