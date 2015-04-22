<!DOCTYPE html>
<html>
<head>
	<title>Accueil temporaire site NF17</title>
	<meta charset="UTF-8"/>
</head>
<body>
On peut mettre des liens vers toutes les pages ici, en attendant de faire une vraie page d'accueil et tout... <br><br>


<!-- Test de PHP + connection à Postgres -->
Extention Postgres 
<?php
echo extension_loaded('pgsql') ? 'trouvée <br>':'pas trouvée :/ <br>';

include_once("classes/db.class.php");
$db = DB::connect();

$vSql ="SELECT * FROM test;";

$vQuery=pg_query($db, $vSql);
while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) { 
	echo ($vResult['index'].": ".$vResult['truc']."<br>");
}

DB::close();
?>
</body>
</html>