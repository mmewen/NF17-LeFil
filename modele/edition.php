<?php
/*
	Ici on a que du php, avec les accès à la base de donnée surtout.
	Toutes les fonctions sont utilisables par les pages (= les controlleurs en fait)
	du module
*/

function get_all_motscles(){
	$req ="SELECT * FROM MotsClefs";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_all_motscles.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all( $result );
	return $array;
}

function motcle_existe_deja($motcle){
	$req ="SELECT COUNT(*) FROM MotsClefs WHERE motsclefs_corps='".pg_escape_string($motcle)."';";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql motcle_existe_deja.</strong> Requête:<br>'.$req.'<br>'));
	$do_exists = pg_fetch_array($result);
	return $do_exists["count"]=="1"?true:false;
}

function add_motcle($motcle){
	$req ="INSERT INTO MotsClefs (motsclefs_corps, motsclefs_editeur, motsclefs_datecreation)
					VALUES ('".pg_escape_string($motcle)."', ".$_SESSION['Editeur'].",'".date("Y-m-d H:i:s")."');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql ajouter_motcle.</strong> Requête:<br>'.$req.'<br>'));
}