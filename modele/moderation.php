<?php
/*
	Ici on a que du php, avec les accès à la base de donnée surtout.
	Toutes les fonctions sont utilisables par les pages (= les controlleurs en fait)
	du module
*/

function get_all_commentaires(){
	$req ="SELECT commentaire_id, commentaire_titre, commentaire_corps, lecteur_login, commentaire_createur, commentaire_datecreation,
			commentaire_masque, commentaire_enExergue, commentaire_supprime, commentaire_datesuppression, commentaire_article, article_titre
		FROM Commentaire, Lecteur, Article
		WHERE commentaire_createur=lecteur_id AND commentaire_article=article_id
		ORDER BY commentaire_datecreation DESC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_all_commentaires. Requête:<br>'.$req.'<br>');
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_commentaire($id_com){
	$req ="SELECT commentaire_id, commentaire_titre, commentaire_corps, lecteur_login, commentaire_createur, commentaire_datecreation,
			commentaire_masque, commentaire_enExergue, commentaire_supprime, commentaire_datesuppression, commentaire_article, article_titre
		FROM Commentaire, Lecteur, Article
		WHERE commentaire_createur=lecteur_id AND commentaire_article=article_id AND commentaire_id=$id_com
		ORDER BY commentaire_datecreation DESC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_commentaire. Requête:<br>'.$req.'<br>');
	$array = pg_fetch_array( $result );
	return $array;
}

function demasquer_commentaire($id_com){
	$req = "UPDATE Commentaire SET commentaire_masque=FALSE WHERE commentaire_id=$id_com;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql demasquer_commentaire. Requête:<br>'.$req.'<br>');
}

function masquer_commentaire($id_com){
	$req = "UPDATE Commentaire SET commentaire_masque=TRUE WHERE commentaire_id=$id_com;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql masquer_commentaire. Requête:<br>'.$req.'<br>');
}

function exerguer_commentaire($id_com){	
	$req ="INSERT INTO Mettre_Exergue_Commentaire (miseexcom_datemiseex, miseexcom_commentaire, miseexcom_moderateur)
			VALUES ('".date("Y-m-d H:i:s")."', $id_com, ".$_SESSION['Moderateur'].");";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql exerguer_commentaire. Requête:<br>'.$req.'<br>');
}

function supprimer_commentaire($id_com){
	$req ="INSERT INTO Supprimer_Commentaire (suppcomm_datesupp, suppcomm_commentaire, suppcomm_moderateur)
			VALUES ('".date("Y-m-d H:i:s")."', $id_com, ".$_SESSION['Moderateur'].");";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql supprimer_commentaire. Requête:<br>'.$req.'<br>');
}