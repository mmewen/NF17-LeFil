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
		case 'commenter':
			commenter();
			break;
		case 'rechercher':
			rechercher();
			break;
		default:
			Messages::error('La page que vous demandez n\'existe pas !');
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
		$tags = get_tag_article($id);
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

function commenter(){
	if(isset($_SESSION['Lecteur']) && ($_SESSION['Lecteur'] > 0)  && !empty($_POST["titre"]) && !empty($_POST["com"])){
		// Alors on a le droit de commenter
		poster_commentaire($_POST["titre"], $_POST["com"]);
		Messages::info("Votre commentaire a bien été posté ! :)");
		afficher_article(); // on a le numéro d'article en GET
	} else {
		// on se fait bouler
		Messages::error("Genre tu peux poster un commentaire sans être connecté, genre !");
		defaut();
	}
}

function rechercher(){
	$nomRubriqueMere = "Recherche";
	if (isset($_POST["recherche"]) && !empty($_POST["recherche"])){
		$recherche = $_POST["recherche"];
	} else if (isset($_GET["recherche"]) && !empty($_GET["recherche"])){
		$recherche = $_GET["recherche"];
	} else {
		defaut();
		return;
	}
	$rubriques = get_rubriques_correspondantes($recherche);
	$articles = get_articles_correspondants($recherche);
	include 'vues/article/afficher_rubriques.php';
}