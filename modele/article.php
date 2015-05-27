<?php
/*
	Ici on a que du php, avec les accès à la base de donnée surtout.
	Toutes les fonctions sont utilisables par les pages (= les controlleurs en fait)
	du module
*/

function is_publie($id){ // et n'est pas supprimé
	$req ="SELECT COUNT(*) FROM Article WHERE article_id='".pg_escape_string($id)."'  AND article_supprime=false AND article_publie=true;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql is_publie.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_array ( $result );
	return $array['count']>0? true : false;
}

function is_supprime($id){
	$req ="SELECT COUNT(*) FROM Article WHERE article_id='".pg_escape_string($id)."' AND article_supprime=true;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql is_supprime.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_array ( $result );
	return $array['count']==1? true : false;
}

function get_article($id){
	$req ="SELECT * FROM Article a WHERE a.article_id='".pg_escape_string($id)."';";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_article.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_array ( $result );
	return $array;
}

function get_texte_article($id){
	$req ="SELECT t.texte_titre, t.texte_corps FROM Texte t WHERE t.texte_article='".pg_escape_string($id)."'
	ORDER BY t.texte_id ASC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_texte_article.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_commentaires_article($id, $enExergue){
	$req ="SELECT commentaire_titre, commentaire_corps, lecteur_login AS commentaire_createur, commentaire_datecreation FROM Commentaire, Lecteur
			WHERE commentaire_article='".pg_escape_string($id)."' AND commentaire_createur=lecteur_id
				AND commentaire_enExergue=".($enExergue?"TRUE":"FALSE")." AND commentaire_masque=FALSE AND commentaire_supprime=FALSE
		
		ORDER BY commentaire_datecreation DESC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_commentaires_article.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_comite_article($id){
	$req ="SELECT m.motsclefs_corps FROM Indexer_Article i, MotsClefs m
			WHERE i.indexart_article='".pg_escape_string($id)."'
				AND i.indexart_motclef=m.motsclefs_id";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_commite_article.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_liste_articles_publies(){
	// penser à modifier la fonction get_articles_publies_rubrique si besoin
	$req ="SELECT article_id, article_titre FROM Article, Modifier_Statut_Editeur
			WHERE article_id=modifstatedit_article AND article_supprime=FALSE AND article_publie=TRUE AND modifstatedit_statut='Valide'
			ORDER BY modifstatedit_datemodif DESC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_liste_articles_publies.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_liste_articles_publies_honneur(){
	$req ="SELECT article_id, article_titre FROM Article, Modifier_Statut_Editeur
			WHERE article_id=modifstatedit_article AND article_supprime=FALSE AND article_publie=TRUE AND article_honneur=TRUE AND modifstatedit_statut='Valide'
			ORDER BY modifstatedit_datemodif DESC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_liste_articles_publies.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_ssrubriques_rubrique($rubriqueMere){
	if (!empty($rubriqueMere)){
		$req ="SELECT assocsrubrub_sousrubrique AS id_sous_rubrique, rubrique_nom AS nom_sous_rubrique
				FROM Associer_SousRubrique_Rubrique, Rubrique
				WHERE assocsrubrub_rubrique=$rubriqueMere AND rubrique_id=assocsrubrub_sousrubrique;";
	} else {
		$req ="SELECT rubrique_id AS id_sous_rubrique, rubrique_nom AS nom_sous_rubrique FROM Rubrique
				WHERE rubrique_id NOT IN (SELECT assocsrubrub_sousrubrique FROM Associer_SousRubrique_Rubrique);";
	}
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_ssrubriques_rubrique.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_articles_publies_rubrique($rubriqueMere){
	// penser à modifier la fonction get_liste_articles_publies si besoin
	if (!empty($rubriqueMere)){
		$req = "SELECT article_id, article_titre, article_honneur FROM Article, Modifier_Statut_Editeur, Associer_Article_Rubrique
			WHERE article_id=modifstatedit_article AND article_supprime=FALSE AND article_publie=TRUE AND modifstatedit_statut='Valide'
				AND assocartrub_article=article_id AND assocartrub_rubrique=$rubriqueMere
			ORDER BY modifstatedit_datemodif DESC;";
	} else {
		$req = "SELECT article_id, article_titre, article_honneur FROM Article, Modifier_Statut_Editeur
			WHERE article_id=modifstatedit_article AND article_supprime=FALSE AND article_publie=TRUE AND modifstatedit_statut='Valide'
				AND article_id NOT IN (SELECT assocartrub_article FROM Associer_Article_Rubrique)
			ORDER BY modifstatedit_datemodif DESC;";
	}
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_articles_publies_rubrique.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_nom_rubrique($rubrique){
	$req ="SELECT rubrique_nom FROM Rubrique WHERE rubrique_id=$rubrique;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_nom_rubrique.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_array( $result );
	return $array["rubrique_nom"];
}

function poster_commentaire($titre_com, $texte_com){
	$req ="INSERT INTO Commentaire (commentaire_titre, commentaire_corps, commentaire_enExergue,
						commentaire_masque, commentaire_supprime, commentaire_createur,
						commentaire_article, commentaire_datecreation, commentaire_datesuppression)
			VALUES ('".pg_escape_string($titre_com)."','".pg_escape_string($texte_com)."',FALSE,
				    FALSE,FALSE,".$_SESSION['Lecteur'].",".$_GET["article"].",'".date("Y-m-d H:i:s")."',NULL);";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql poster_commentaire.</strong> Requête:<br>'.$req.'<br>'));
}