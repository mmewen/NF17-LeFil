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
	$req ="SELECT t.texte_titre, t.texte_corps FROM Texte t WHERE t.texte_article='".addslashes($id)."'
	ORDER BY t.texte_id ASC;";
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

function get_comite_article($id){
	$req ="SELECT m.motsclefs_corps FROM Indexer_Article i, MotsClefs m
			WHERE i.indexart_article='".addslashes($id)."'
				AND i.indexart_motclef=m.motsclefs_id";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_commite_article. Requête:<br>'.var_dump($req).'<br>');
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_liste_articles_publies(){
	// penser à modifier la fonction get_articles_publies_rubrique si besoin
	$req ="SELECT article_id, article_titre FROM Article, Modifier_Statut_Editeur
			WHERE article_id=modifstatedit_article AND article_supprime=FALSE AND article_publie=TRUE AND modifstatedit_statut='Valide'
			ORDER BY modifstatedit_datemodif DESC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_liste_articles_publies. Requête:<br>'.var_dump($req).'<br>');
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_liste_articles_publies_honneur(){
	$req ="SELECT article_id, article_titre FROM Article, Modifier_Statut_Editeur
			WHERE article_id=modifstatedit_article AND article_supprime=FALSE AND article_publie=TRUE AND article_honneur=TRUE AND modifstatedit_statut='Valide'
			ORDER BY modifstatedit_datemodif DESC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_liste_articles_publies. Requête:<br>'.var_dump($req).'<br>');
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_ssrubriques_rubrique(){

}

function get_articles_publies_rubrique(){
	// penser à modifier la fonction get_liste_articles_publies si besoin
	$req ="SELECT article_id, article_titre FROM Article, Modifier_Statut_Editeur
			WHERE article_id=modifstatedit_article AND article_supprime=FALSE AND article_publie=TRUE AND modifstatedit_statut='Valide'
			ORDER BY modifstatedit_datemodif DESC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_liste_articles_publies. Requête:<br>'.var_dump($req).'<br>');
	$array = pg_fetch_all ( $result );
	return $array;
}