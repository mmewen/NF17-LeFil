<?php
/*
	Ici on a que du php, avec les accès à la base de donnée surtout.
	Toutes les fonctions sont utilisables par les pages (= les controlleurs en fait)
	du module
*/

function get_liste_articles_auteur(){
	$req="SELECT article_id, article_titre, article_supprime, article_publie, article_honneur, comedit_groupenom, modifstatut_statut, 
	             modifstatut_datemodif
		  FROM Article, ComiteEditorial, Modifier_Statut_Auteur
          WHERE comedit_id=article_comite AND modifstatut_article=article_id AND modifstatut_auteur=".$GLOBALS['id_auteur'].";";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_liste_articles_auteur. Requête:<br>'.$req.'<br>');
	$array = pg_fetch_all ($result);
	return $array;
}

function get_texte_article($article_id){
	$req="SELECT texte_corps
		  FROM Texte
		  WHERE texte_article=".$article_id.";";
	$result= pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_texte_article. Requête:<br>'.$req.'<br>');
	$array = pg_fetch_all ($result);
	return $array;
}