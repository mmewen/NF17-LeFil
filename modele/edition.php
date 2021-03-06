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

function get_tous_articles($tri){
	switch ($tri) {
		case 'statut':
			$strtri = "s.statut";
			break;
		case 'auteur':
			$strtri = "auteur_login ASC";
			break;
		case 'date':
			$strtri = "date DESC";
			break;
	}
	$req ="SELECT a.*, statut, auteur_login, comedit_groupenom, date
			FROM Article a, vStatutArticles s, Auteur aut, vArticleAuteur vaa, ComiteEditorial c
			WHERE s.article = a.article_id AND aut.auteur_id=vaa.auteur AND vaa.article=a.article_id AND a.article_comite=c.comedit_id
			ORDER BY $strtri;";
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

function get_motscles(){ // redondante avec le modele Article
	$req ="SELECT m.motsclefs_id, m.motsclefs_corps, i.indexart_article FROM MotsClefs m
			LEFT JOIN Indexer_Article i
			ON i.indexart_motclef=m.motsclefs_id;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_motscles_article.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_article($id){
	$req ="SELECT * FROM Article a WHERE a.article_id='".pg_escape_string($id)."';";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_article.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_array ( $result );
	return $array;
}

function add_motcle_article($id_motcle, $id_article){
	$req ="INSERT INTO Indexer_Article (indexart_dateindex, indexart_motclef, indexart_editeur, indexart_article)
			VALUES ('".date("Y-m-d H:i:s")."',$id_motcle,".$_SESSION['Editeur'].",$id_article);";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql add_motcle_article.</strong> Requête:<br>'.$req.'<br>'));
}

function supprimer_motcle_article($id_motcle, $id_article){
	$req ="DELETE FROM Indexer_Article
			WHERE indexart_motclef=$id_motcle AND indexart_article=$id_article;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql supprimer_motcle_article.</strong> Requête:<br>'.$req.'<br>'));
}

function get_articles_rubriques($id_article){
	$req ="SELECT DISTINCT r.rubrique_id, r.rubrique_nom, a.article_id
			FROM Rubrique r
			LEFT OUTER JOIN Associer_Article_Rubrique aar ON aar.assocartrub_rubrique=r.rubrique_id
			LEFT OUTER JOIN Article a ON aar.assocartrub_article=a.article_id AND a.article_id=$id_article;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_articles_rubriques.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function add_rubrique_article($id_rubrique, $id_article){
	$req ="INSERT INTO Associer_Article_Rubrique (assocartrub_dateassoc, assocartrub_rubrique,
						assocartrub_editeur, assocartrub_article)
			VALUES ('".date("Y-m-d H:i:s")."',$id_rubrique,".$_SESSION['Editeur'].",$id_article);";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql add_rubrique_article.</strong> Requête:<br>'.$req.'<br>'));
}

function delete_rubrique_article($id_rubrique, $id_article){
	$req ="DELETE FROM Associer_Article_Rubrique
			WHERE assocartrub_rubrique=$id_rubrique AND assocartrub_article=$id_article;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql delete_rubrique_article.</strong> Requête:<br>'.$req.'<br>'));
}


function get_articles_associes(){
	$req ="SELECT a.article_id AS id_art_1, a.article_titre AS titre_art_1, a2.article_id AS id_art_2, a2.article_titre AS titre_art_2
			FROM Article a
			LEFT OUTER JOIN Associer_Article_Article aaa ON aaa.assocartart_article1=a.article_id
			LEFT OUTER JOIN Article a2 ON aaa.assocartart_article2=a2.article_id;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_articles_rubriques.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function add_association_2articles($id_art_1, $id_art_2){
	$req ="INSERT INTO Associer_Article_Article (assocartart_dateassoc, assocartart_article1,
						assocartart_article2, assocartart_editeur)
			VALUES ('".date("Y-m-d H:i:s")."',$id_art_1,$id_art_2,".$_SESSION['Editeur'].");";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql add_rubrique_article.</strong> Requête:<br>'.$req.'<br>'));
}


function delete_association_2articles($id_art_1, $id_art_2){
	$req ="DELETE FROM Associer_Article_Article
			WHERE
				(assocartart_article1=$id_art_1 AND assocartart_article2=$id_art_2)
				OR
				(assocartart_article1=$id_art_2 AND assocartart_article2=$id_art_1);";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql delete_rubrique_article.</strong> Requête:<br>'.$req.'<br>'));
}

function put_honneur_article($id_article){
	$req ="INSERT INTO Mettre_A_Honneur (misehonneur_datemisehonneur, misehonneur_editeur, misehonneur_article)
			VALUES ('".date("Y-m-d H:i:s")."',".$_SESSION['Editeur'].",$id_article);";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql put_honneur_article.</strong> Requête:<br>'.$req.'<br>'));
}

function delete_honneur_article($id_article){
	$req ="DELETE FROM Mettre_A_Honneur
			WHERE misehonneur_article=$id_article;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql 1 delete_honneur_article.</strong> Requête:<br>'.$req.'<br>'));
	$req ="UPDATE article SET article_honneur=false WHERE article_id=$id_article;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql 2 delete_honneur_article.</strong> Requête:<br>'.$req.'<br>'));
}

function get_statut_article($id_article){
	$req ="SELECT * FROM vStatutArticles WHERE article=$id_article;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_statut_article.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_array ( $result );
	return $array;
}

function set_statut_article($id_article, $new_statut){
	$req ="INSERT INTO Modifier_Statut_Editeur (modifstatedit_datemodif, modifstatedit_editeur, modifstatedit_statut, modifstatedit_article)
			VALUES ('".date("Y-m-d H:i:s")."',".$_SESSION['Editeur'].",'$new_statut',$id_article);";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql set_statut_article.</strong> Requête:<br>'.$req.'<br>'));
}

function set_article_publie($id_article){
	$req ="UPDATE Article SET article_publie=true WHERE article_id=$id_article;;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql set_article_publie.</strong> Requête:<br>'.$req.'<br>'));
}

function set_en_relecture($id_article){
	$statut = get_statut_article($id_article);
	if ($statut['statut'] == "Soumis") {
		set_statut_article($id_article, "En_relecture");
	}
}

function add_remarque($id_article, $remarque, $statut){
	$req ="INSERT INTO Remarque (remarque_corps, remarque_date, remarque_article, remarque_statut)
			VALUES ('".pg_escape_string($remarque)."', '".date("Y-m-d H:i:s")."', $id_article, '$statut');";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql add_remarque.</strong> Requête:<br>'.$req.'<br>'));
}

function get_remarques($id_article){
	$req ="SELECT * FROM Remarque WHERE remarque_article=$id_article;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_remarques.</strong> Requête:<br>'.$req.'<br>'));
	return pg_fetch_all($result);
}

function get_texte_article($id_article){
	$req ="SELECT t.texte_titre, t.texte_corps, t.texte_id FROM Texte t WHERE t.texte_article='".pg_escape_string($id_article)."'
	ORDER BY t.texte_id ASC;";
	$result = pg_query($GLOBALS['bdd'], $req) or die (Messages::error('<strong>Erreur requête psql get_texte_article.</strong> Requête:<br>'.$req.'<br>'));
	$array = pg_fetch_all ( $result );
	return $array;
}

function get_auteur($id_article){
	$req = "SELECT  personne_prenom, personne_nom
			FROM Modifier_Statut_Auteur, Personne
			WHERE modifstatut_article=$id_article AND personne_id=modifstatut_auteur;";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_auteur. Requête:<br>'.$req.'<br>');
	$array = pg_fetch_array($result);
	return $array;
}

function update_article($id_article, $modif){
	$nbarg=$modif["nbarg"];
	$titre=$modif["titre"];
	
	for($i=0;$i<$nbarg;$i++){
		$idtexte{$i} = $modif["idtexte".$i];
		$titretexte{$i}=$modif["titretexte".$i];
		$corps{$i}=$modif["corps".$i];
	}

	$req1="UPDATE Article
		  SET Article_titre='".$titre."'
		  WHERE article_id=".$id_article.";";
	$result = pg_query($GLOBALS['bdd'], $req1) or die ('Erreur requête psql update_article. Requête:<br>'.$req1.'<br>');

	for($i=0;$i<$nbarg;$i++){
		$req="UPDATE Texte
			  SET texte_titre='".$titretexte{$i}."', texte_corps='".$corps{$i}."'
			  WHERE texte_id=".$idtexte{$i}.";";
		$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql update_article. Requête:<br>'.$req.'<br>');
	}
}