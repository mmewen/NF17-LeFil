<?php

function is_login_mdp_corrects($login, $mdp){
	$req ="SELECT COUNT(*) FROM Personne WHERE personne_login='".addslashes($login)."';";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']>0? true : false;
}