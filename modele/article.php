<?php
/*
	Ici on a que du php, avec les accès à la base de donnée surtout.
	Toutes les fonctions sont utilisables par les pages (= les controlleurs en fait)
	du module
*/

function is_publie($id){ // et n'est pas supprimé
	$req ="SELECT COUNT(*) FROM Article WHERE article_id='".addslashes($id)."'  AND article_supprime=false AND article_publie=true;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql is_publie. Requête:<br>'.var_dump($req).'<br>');
	$array = pg_fetch_array ( $result );
	return $array['count']>0? true : false;
}

function is_supprime($id){
	$req ="SELECT COUNT(*) FROM Article WHERE article_id='".addslashes($id)."' AND article_supprime=true;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql is_supprime. Requête:<br>'.var_dump($req).'<br>');
	$array = pg_fetch_array ( $result );
	return $array['count']==1? true : false;
}

function get_article($id){
	$req ="SELECT * FROM Article a WHERE a.article_id='".addslashes($id)."';";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_article. Requête:<br>'.var_dump($req).'<br>');
	$array = pg_fetch_array ( $result );
	return $array;
}

function get_texte_article($id){
	$req ="SELECT t.texte_titre, t.texte_corps FROM Texte t WHERE t.texte_article='".addslashes($id)."' ORDER BY t.texte_id ASC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_texte_article. Requête:<br>'.var_dump($req).'<br>');
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_commentaires_article($id, $enExergue){
	$req ="SELECT commentaire_titre, commentaire_corps, commentaire_createur, commentaire_datecreation FROM Commentaire
			WHERE commentaire_article='".addslashes($id)."'
				AND commentaire_enExergue=".($enExergue?"TRUE":"FALSE")." AND commentaire_masque=FALSE AND commentaire_supprime=FALSE
			ORDER BY commentaire_datecreation DESC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_commentaires_article. Requête:<br>'.var_dump($req).'<br>');
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_commite_article($id){
	$req ="SELECT m.motsclefs_corps FROM Indexer_Article i, MotsClefs m
			WHERE i.indexart_article='".addslashes($id)."'
				AND i.indexart_motclef=m.motsclefs_id";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_commite_article. Requête:<br>'.var_dump($req).'<br>');
	$array = pg_fetch_all ( $result );
	return $array;
}