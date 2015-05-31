<?php

function get_comptes(){
	$req = "SELECT personne_login FROM Personne;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_comptes.</strong> Requête : <br>'.$req.'<br>'));
	$array = pg_fetch_all($result);
	return $array;
}

function create_account($login,$mail,$nom,$prenom){
	$req = "INSERT INTO Personne VALUES (DEFAULT,'".$login."','".$mail."','".$nom."','".$prenom."');" ;
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql create_account.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all($result);
	return $array;
}

function create_account_admin($id,$login){
	$req = "INSERT INTO Administrateur VALUES ('".$id."','".$login."');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql create_account_admin.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all($result);
	return $array;
}

function create_account_auteur($id,$login){
	$req = "INSERT INTO Auteur VALUES ('".$id."','".$login."');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql create_account_auteur.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all($result);
	return $array;
}
function create_account_editeur($id,$login){
	$req = "INSERT INTO Editeur VALUES ('".$id."','".$login."');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql create_account_editeur.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all($result);
	return $array;
}
function create_account_moderateur($id,$login){
	$req = "INSERT INTO Moderateur VALUES ('".$id."','".$login."');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql create_account_moderateur.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all($result);
	return $array;
}
function create_account_lecteur($id,$login){
	$req = "INSERT INTO Lecteur VALUES ('".$id."','".$login."');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql create_account_lecteur.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all($result);
	return $array;
}
function get_id($login){
	$req = "SELECT personne_id FROM Personne WHERE personne_login ='".$login."';";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_id.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_array($result);
	return $array;
}