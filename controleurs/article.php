<?php
include("modele/article.php"); // on inclue le modèle (= toutes les fonctions php d'accès à la BDD et tout)

// C'est ici qu'il faut vérifier si l'utilisateur est admin ou pas et tout
if (!empty($_GET['page'])) {
	switch ( $_GET['page'] ){	
		case 'afficher_article':
			afficher_article();
			break;
		default:
			defaut();
			break;
	}
} else {
        defaut();
}

function defaut(){
	include('vues/article/defaut.php');
}

function afficher_article(){
	if (!empty($_GET['article']) && article_existe($_GET['article'])){
		$article = get_article($_GET['article']);
		include('vues/article/afficher_article.php');
	} else if (!empty($_GET['article']) && article_supprime($_GET['article'])){
		Message::warn("L'article auquel vous essayez d'accéder a été supprimé !");
		defaut();
	} else {
		defaut();
	}
}