<?php
/*
	Ici on a que du php, avec les accès à la base de donnée surtout.
	Toutes les fonctions sont utilisables par les pages (= les controlleurs en fait)
	du module
*/

function article_existe($id){ // et n'est pas supprimé
	$req ="SELECT COUNT(*) FROM Article WHERE article_id='".addslashes($id)."'  AND article_supprime=false;;";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']>0? true : false;
}

function article_supprime($id){
	$req ="SELECT COUNT(*) FROM Article WHERE article_id='".addslashes($id)."'' AND article_supprime=true;";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array['count']==0? true : false;
}

function get_article($id){
	$req ="SELECT * FROM Article a, Texte t WHERE a.article_id='".addslashes($id)."' AND a.article_id=t.texte_article;";
	$result = pg_query($GLOBALS['bdd'], $req);
	$array = pg_fetch_array ( $result );
	return $array;
}