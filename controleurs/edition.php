<?php
include("modele/edition.php"); // on inclue le modèle (= toutes les fonctions php d'accès à la BDD et tout){


if (isset($_SESSION['Editeur']) && $_SESSION['Editeur'] > 0){ // équivaut à dire "l'utilisateur a un id de modérateur" donc "l'utilisateur est modérateur"
	if (!empty($_GET['page'])) {
		switch ( $_GET['page'] ){	
			case 'editer_commentaire':
				if (isset($_GET['commentaire'])) {
					editer_commentaire($_GET['commentaire']);
				} else {
					defaut();
				}
				break;
			case 'gerer_articles':
				gerer_articles();
				break;
			case 'gerer_rubriques':
				gerer_rubriques();
				break;
			case 'gerer_motscles':
				gerer_motscles();
				break;
			case 'ajouter_motcle':
				ajouter_motcle();
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
	include 'controleurs/accueil.php';
}

function defaut(){
	include('vues/edition/defaut.php');
}

function gerer_articles(){
	include('vues/edition/liste_articles.php');
}

function gerer_rubriques(){

}

function gerer_motscles(){
	$motscles = get_all_motscles();
	include('vues/edition/liste_motscles.php');
}

function ajouter_motcle(){
	if (isset($_POST['motcle']) && !empty($_POST['motcle'])) {
		if(!motcle_existe_deja($_POST['motcle'])){
			add_motcle($_POST['motcle']);
			Messages::info("Mot-clé correctement ajouté !");
		} else {
			Messages::warn("Ce mot clé existe déjà !");
		}
	} else {
		Messages::error("Erreur, il n'y a pas de mot clé à ajouter !");
	}
	gerer_motscles();
}
