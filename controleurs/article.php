<?php
include("modele/article.php"); // on inclue le modèle (= toutes les fonctions php d'accès à la BDD et tout)

// C'est ici qu'il faut vérifier si l'utilisateur est admin ou pas et tout
if (!empty($_GET['page'])) {
	switch ( $_GET['page'] ){	
		case 'afficher_article':
			afficher_article();
			break;	
		case 'rubriques':
			rubriques();
			break;
		default:
			defaut();
			break;
	}
} else {
        defaut();
}

function defaut(){
	$articles_honneur = get_liste_articles_publies_honneur();
	$articles_pas_honneur = get_liste_articles_publies();
	include('vues/article/defaut.php');
}

function afficher_article(){
	if (!empty($_GET['article']) && is_publie($_GET['article'])){
		$id = $_GET['article'];
		$article = get_article($id);
		$textes = get_texte_article($id);
		$commsEnExergue = get_commentaires_article($id, true);
		$commsAutres = get_commentaires_article($id, false);
		$tags = get_comite_article($id);
		include('vues/article/afficher_article.php');
	} else if (!empty($_GET['article']) && is_supprime($_GET['article'])){
		Messages::warn("L'article auquel vous essayez d'accéder a été supprimé !");
		defaut();
	} else {
		Messages::warn("L'article demandé n'est pas accessible");
		defaut();
	}
}

function rubriques(){
	if (isset($_GET['rubrique']) && !empty($_GET['rubrique'])){
		$rubriqueMere = $_GET['rubrique'];
		$nomRubriqueMere = get_nom_rubrique($rubriqueMere);
	} else {
		$rubriqueMere = null;
		$nomRubriqueMere = "Rubriques";
	}

	$rubriques = get_ssrubriques_rubrique($rubriqueMere);
	$articles = get_articles_publies_rubrique($rubriqueMere);
	
	include 'vues/article/afficher_rubriques.php';
}

function get_auteur_from_article(){

}