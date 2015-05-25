<?php

function is_login_mdp_corrects($login, $mdp){
	$req ="SELECT COUNT(*) FROM Personne WHERE personne_login='".addslashes($login)."';";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']>0? true : false;
}

function is_admin($login){
	$req ="SELECT admin_id, COUNT(*) FROM Administrateur WHERE admin_login='$login' GROUP BY admin_id;";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==1? $array['admin_id'] : 0;
}

function is_auteur($login){
	$req ="SELECT auteur_id, COUNT(*) FROM Auteur WHERE auteur_login='$login' GROUP BY auteur_id;";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==1? $array['auteur_id'] : 0;
}

function is_editeur($login){
	$req ="SELECT editeur_id, COUNT(*) FROM Editeur WHERE editeur_login='$login' GROUP BY editeur_id;";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==1? $array['editeur_id'] : 0;
}

function is_lecteur($login){
	$req ="SELECT lecteur_id, COUNT(*) FROM Lecteur WHERE lecteur_login='$login' GROUP BY lecteur_id;";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==1? $array['lecteur_id'] : 0;
}

function is_moderateur($login){
	$req ="SELECT moderateur_id, COUNT(*) FROM Moderateur WHERE moderateur_login='$login' GROUP BY moderateur_id;";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==1? $array['moderateur_id'] : 0;
}