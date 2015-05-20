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

	$vSql ="SELECT * FROM test;";

	$vQuery=pg_query($GLOBALS['bdd'], $vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) { 
		echo ($vResult['index'].": ".$vResult['truc']."<br>");
	}	
	?>
</p>