<?php

function is_login_mdp_corrects($login, $mdp){
	$req ="SELECT COUNT(*) FROM Personne WHERE personne_login='".addslashes($login)."';";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']>0? true : false;
}

function is_admin($login){
	$req ="SELECT COUNT(*) FROM Administrateur WHERE admin_login='$login';";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==1? true : false;
}

function is_auteur($login){
	$req ="SELECT COUNT(*) FROM Auteur WHERE auteur_login='$login';";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==1? true : false;
}

function is_editeur($login){
	$req ="SELECT COUNT(*) FROM Editeur WHERE editeur_login='$login';";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==1? true : false;
}

function is_lecteur($login){
	$req ="SELECT COUNT(*) FROM Lecteur WHERE lecteur_login='$login';";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==1? true : false;
}

function is_moderateur($login){
	$req ="SELECT COUNT(*) FROM Moderateur WHERE moderateur_login='$login';";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==1? true : false;
}