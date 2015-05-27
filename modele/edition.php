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
	$req ="SELECT COUNT(*) FROM MotsClefs WHERE LOWER(motsclefs_corps)=LOWER('".pg_escape_string($motcle)."');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql motcle_existe_deja.</strong> Requête:<br>'.$req.'<br>'));
	$do_exists = pg_fetch_array($result);
	return $do_exists["count"]=="1"?true:false;
}

function add_motcle($motcle){
	$req ="INSERT INTO MotsClefs (motsclefs_corps, motsclefs_editeur, motsclefs_datecreation)
					VALUES ('".pg_escape_string($motcle)."', ".$_SESSION['Editeur'].",'".date("Y-m-d H:i:s")."');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql ajouter_motcle.</strong> Requête:<br>'.$req.'<br>'));
}

function rubrique_existe_deja($rubrique){
	$req ="SELECT COUNT(*) FROM Rubrique WHERE LOWER(rubrique_nom)=LOWER('".pg_escape_string($rubrique)."');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql rubrique_existe_deja.</strong> Requête:<br>'.$req.'<br>'));
	$do_exists = pg_fetch_array($result);
	return $do_exists["count"]=="1"?true:false;
}

function ajouter_rubrique($rubrique){
	$req ="INSERT INTO Rubrique (rubrique_nom, rubrique_createur, rubrique_datecreation)
					VALUES ('".pg_escape_string($rubrique)."', ".$_SESSION['Editeur'].",'".date("Y-m-d H:i:s")."');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql ajouter_rubrique.</strong> Requête:<br>'.$req.'<br>'));
}

function get_tous_articles(){
	$req ="SELECT article_id, article_titre FROM Article, Modifier_Statut_Editeur
			ORDER BY modifstatedit_datemodif DESC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_tous_articles.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_toutes_rubriques(){
	$req ="SELECT r1.rubrique_nom AS nom_mere, r1.rubrique_id AS id_mere, r2.rubrique_nom AS nom_fille, r2.rubrique_id AS id_fille
			FROM Rubrique r1
			LEFT OUTER JOIN Associer_SousRubrique_Rubrique asrr ON asrr.assocsrubrub_rubrique=r1.rubrique_id
			LEFT OUTER JOIN Rubrique r2 ON r2.rubrique_id=asrr.assocsrubrub_sousrubrique
			ORDER BY id_mere ASC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_tous_articles.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_rubrique_mere($rubrique){
	$req ="SELECT rubrique_nom AS nom_mere, rubrique_id AS id_mere
			FROM Rubrique, Associer_SousRubrique_Rubrique
			WHERE rubrique_id=assocsrubrub_rubrique AND assocsrubrub_sousrubrique=$rubrique;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_rubrique_mere.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_array ( $result );
	return $array;
}

function get_rubriques_filles($rubrique){
	$req ="SELECT rubrique_nom AS nom_fille, rubrique_id AS id_fille
			FROM Rubrique, Associer_SousRubrique_Rubrique
			WHERE rubrique_id=assocsrubrub_sousrubrique AND assocsrubrub_rubrique=$rubrique;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_rubrique_mere.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_nom_rubrique($rubrique){
	$req ="SELECT rubrique_nom FROM Rubrique WHERE rubrique_id=$rubrique;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_nom_rubrique.</strong> Requête:<br>'.$req.'<br>'));
	$res = pg_fetch_array($result);
	return $res['rubrique_nom'];
}

function modifer_nom_rubrique($rubrique, $nouveau_nom){
	$req ="UPDATE Rubrique SET rubrique_nom='".pg_escape_string($nouveau_nom)."' WHERE rubrique_id=$rubrique;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql modifer_nom_rubrique.</strong> Requête:<br>'.$req.'<br>'));
}

function is_fille_ou_petitefille($rub_mere, $rub_fille){
	// on cherche à savoir si la seconde rubrique est fille de la première
	$filles = get_rubriques_filles($rub_mere);
	if(!$filles){
		return false;
	}

	foreach ($filles as $fille) { // Attention : complexité pas tip top :/
		if($rub_fille==$fille['id_fille'] || is_fille_ou_petitefille($fille['id_fille'], $rub_fille)){
			return true;
		}
	}

	return false;
}

function get_rubrique_mere_potentielles($rubrique){
	$rubriques_all = get_toutes_rubriques();
	foreach ($rubriques_all as $key => $rub) { // Attention : complexité pas tip top :/
		if($rub['id_mere']==$rubrique || is_fille_ou_petitefille($rubrique, $rub['id_mere'])){
			unset($rubriques_all[$key]);
		}
	}
	return $rubriques_all;
}

function get_id_assoc_rub_ssrub($rubrique_fille){
	// on cherche à trouver 0 ou 1 ligne où rubrique_fille a une mère
	$req ="SELECT assocsrubrub_id FROM associer_sousrubrique_rubrique WHERE assocsrubrub_sousrubrique=$rubrique_fille;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_id_assoc_rub_ssrub.</strong> Requête:<br>'.$req.'<br>'));
	$res = pg_fetch_array($result);
	return $res;
}

function add_assoc_rub_ssrub($id_future_maman, $id_rubrique){
	$req ="INSERT INTO associer_sousrubrique_rubrique
			(assocsrubrub_dateassoc, assocsrubrub_editeur, assocsrubrub_rubrique, assocsrubrub_sousrubrique)
			VALUES ('".date("Y-m-d H:i:s")."',".$_SESSION['Editeur'].",$id_future_maman,$id_rubrique);";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_id_assoc_rub_ssrub.</strong> Requête:<br>'.$req.'<br>'));
	$res = pg_fetch_array($result);
	return $res;
}

function delete_assoc_rub_ssrub($id_old_assoc){
	$req ="DELETE FROM associer_sousrubrique_rubrique WHERE assocsrubrub_id=$id_old_assoc;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql delete_assoc_rub_ssrub.</strong> Requête:<br>'.$req.'<br>'));
	$res = pg_fetch_array($result);
}