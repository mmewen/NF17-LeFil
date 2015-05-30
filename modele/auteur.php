<?php
/*
	Ici on a que du php, avec les accès à la base de donnée surtout.
	Toutes les fonctions sont utilisables par les pages (= les controlleurs en fait)
	du module
*/

function get_article_auteur(){
	$req="SELECT DISTINCT modifstatut_article
		  FROM Modifier_Statut_Auteur
		  WHERE modifstatut_auteur=".$GLOBALS["auteur_id"]."
		  ORDER BY modifstatut_article ASC;";
	$result= pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_article_auteur. Requête:<br>'.$req.'<br>');
	$array = pg_fetch_all ($result);
	return $array;
}

function get_historique_article_auteur($article_id){
	$req="SELECT article_id, article_titre, article_supprime, article_publie, article_honneur, comedit_groupenom, modifstatut_statut, 
	             modifstatut_datemodif
		  FROM Article, ComiteEditorial, Modifier_Statut_Auteur
          WHERE comedit_id=article_comite AND article_id=".$article_id."AND modifstatut_article=article_id AND modifstatut_auteur=".$GLOBALS['auteur_id']."
          ORDER BY modifstatut_datemodif DESC;";
    $result= pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_historique_article. Requête:<br>'.$req.'<br>');
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

/* 
Cette fonction permettait de récupérer la date de création d'un article, c'est à dire la date de modification des statuts la plus ancienne
C'est pas évident car en récupérant l'adresse elle devient un string, qu'il faut convertir en date pour les comparer puis reconvertir en string 
pour l'afficher
*/

/*
function get_date_creation_article($article_id){
	$articles=get_historique_article_auteur($article_id);
	foreach ($articles as $art){
		$datemodif=date_create_from_format('Y-m-d G:i:s',$art["modifstatut_datemodif"]);
		if (isset($datecreation)){
			if ($datemodif<$datecreation){				
				$datecreation=$datemodif;					
			}
		} else { 			
			$datecreation=$datemodif;			
		}
	}
	return date_format($datecreation,"Y-m-d G:i:s");
}
*/

function get_rubrique_article($article_id){
	$req = "SELECT rubrique_nom, assocartrub_rubrique, assocartrub_article
			FROM Associer_Article_Rubrique, Rubrique
			WHERE assocartrub_rubrique=rubrique_id AND assocartrub_article=".$article_id.";";
	$result= pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_rubrique_article. Requête:<br>'.$req.'<br>');
	$array = pg_fetch_all ($result);
	return $array;	
}

function get_article_article($article_id,$titre){
	$req = "SELECT DISTINCT article_titre, assocartart_article1, assocartart_article2
			FROM Associer_Article_Article, Article
			WHERE (article_id=assocartart_article1 OR article_id=assocartart_article2) AND 
				  (assocartart_article1=".$article_id." OR assocartart_article2=".$article_id.") AND article_titre<>'".$titre."';";
	$result = pg_query($GLOBALS['bdd'], $req) or die ('Erreur requête psql get_article_article. Requête:<br>'.$req.'<br>');
	$array = pg_fetch_all ($result);
	return $array;
}

function inserer_article($titre,$titretexte,$texte){
	$req1="INSERT INTO Article (article_titre, article_supprime, article_publie, 
					 article_honneur, article_comite)
		   VALUES ('".pg_escape_string($titre)."',FALSE,FALSE,FALSE,1) 
		   RETURNING article_id;";
	$result = pg_query($GLOBALS['bdd'], $req1) or die ('Erreur requête psql get_article_article. Requête:<br>'.$req1.'<br>');
	$id = pg_fetch_all ($result);
	$date=date('Y-m-d G:i:s');

	foreach($id as $id){
		$req3="INSERT INTO Texte (texte_titre, texte_article, texte_corps)
			   VALUES ('".pg_escape_string($titretexte)."',".intval($id['article_id']).",'".pg_escape_string($texte)."');";
		$result = pg_query($GLOBALS['bdd'], $req3) or die ('Erreur requête psql get_article_article. Requête:<br>'.$req3.'<br>');

		$req4="INSERT INTO Modifier_Statut_Auteur (modifstatut_datemodif,modifstatut_auteur,modifstatut_article,modifstatut_statut)
			   VALUES ('".$date."','".$GLOBALS['auteur_id']."',".intval($id['article_id']).",'En redaction');";
	    $result = pg_query($GLOBALS['bdd'], $req4) or die ('Erreur requête psql get_article_article. Requête:<br>'.$req4.'<br>');
	}
}