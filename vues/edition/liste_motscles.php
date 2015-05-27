<div class="col-sm-4">
	<div class="list-group">
		<?php
		foreach ($motscles as $motcle) {
			echo ('<a href="?module=article&page=rechercher&recherche='.$motcle["motsclefs_corps"].'" class="list-group-item">'.$motcle["motsclefs_corps"].'</a>');
		}
		?>
		<li class="list-group-item active">
			<form action="?module=edition&page=ajouter_motcle" method="POST">
				<div class="form-group">
					<input type="text" class="form-control" name="motcle" placeholder="Ajouter un mot-clé">
				</div>
				<button type="submit" class="btn btn-default">Ajouter</button>
			</form>
		</li>
	</div>
</div>