<?php

$id_auteur=$_SESSION['Auteur'];

include("modele/auteur.php"); // on inclue le modèle (= toutes les fonctions php d'accès à la BDD et tout)

if (isset($id_auteur) && $id_auteur > 0){ // équivaut à dire "l'utilisateur a un id d'auteur" donc "l'utilisateur est auteur"
	if (!empty($_GET['page'])) {
		switch ( $_GET['page'] ){	
			case 'editer_article':
				if (isset($_GET['article'])) {
					editer_article($_GET['article']);
				} else {
					defaut();
				}
				break;
			case 'soumettre':
				soumettre_article();
				break;
			default:
				defaut();
				break;
		}
	} else {
	        defaut();
	}
} else {
	Messages::error("Page inaccessible avec vos droits actuels");
	include('controleurs/accueil.php');
}

function defaut(){
	$articles=get_liste_articles_auteur();
	include('vues/auteur/defaut.php');
}

function editer_article($id_article){

}

function soumettre_article($id_article){

}