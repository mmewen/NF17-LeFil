<div class="jumbotron">
	<h1>Page d'accueil test</h1>
	<p>On peut mettre des liens vers toutes les pages ici, en attendant de faire une vraie page d'accueil et tout...</p>
</div>


<div class="page-header">
	<h1>Test de PHP + connection à Postgres</h1>
</div>
<p>

	Extention Postgres 
	<?php
	echo extension_loaded('pgsql') ? '<span class="label label-primary">trouvée</span> <br>':'<span class="label label-warning">pas trouvée</span><br>';


	$req ="SELECT COUNT(*) from article;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql. ');
	$array = pg_fetch_array ( $result );
	if ($array['count']>0) {
		echo ('Ok ! Base de donnée non vide :)');
	} else {
		echo ('Oups, ya un soucis...');
	}
	?>
</p>


<div class="page-header">
	<h1>_SESSION</h1>
</div>
<p>
	<?php
	var_dump($_SESSION);
	?>
</p>