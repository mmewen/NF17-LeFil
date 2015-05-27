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
			case 'editer_rubrique':
				editer_rubrique();
				break;
			case 'ajouter_rubrique':
				add_rubrique();
				break;
			case 'gerer_motscles':
				gerer_motscles();
				break;
			case 'ajouter_motcle':
				ajouter_motcle();
				break;
			case 'renommer_rubrique':
				renommer_rubrique();
				break;
			case 'modifier_mere_rubrique';
				modifier_mere_rubrique();
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
	// on récupère les articles "en rédaction", "soumis", "en relecture", "à réviser", "rejeté", "validé"
	$articles = get_tous_articles();
	include('vues/edition/liste_articles.php');
}

function gerer_rubriques(){
	$rubriques = get_toutes_rubriques();
	include('vues/edition/liste_rubriques.php');
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

function editer_rubrique(){
	if (isset($_GET['rubrique']) && !empty($_GET['rubrique'])) {
		$rubrique = $_GET['rubrique'];
		$nom_rubrique = get_nom_rubrique($rubrique);
		$rubrique_mere = get_rubrique_mere($rubrique);
		$rubriques_filles = get_rubriques_filles($rubrique);
		$rubriques_mere_potentielles = get_rubrique_mere_potentielles($rubrique);
		include('vues/edition/editer_rubrique.php');
	} else {
		Messages::error("Erreur, ce numéro de rubrique est incorrect !");
	}
}

function add_rubrique(){
	if (isset($_POST['rubrique']) && !empty($_POST['rubrique'])) {
		if(!rubrique_existe_deja($_POST['rubrique'])){
			ajouter_rubrique($_POST['rubrique']);
			Messages::info("Rubrique correctement ajoutée !");
		} else {
			Messages::warn("Cette rubrique existe déjà !");
		}
	} else {
		Messages::error("Erreur, il n'y a pas de rubrique à ajouter !");
	}
	gerer_rubriques();
}

function renommer_rubrique(){
	if (isset($_GET['rubrique']) && !empty($_GET['rubrique']) && isset($_POST['nouveau_nom']) && !empty($_POST['nouveau_nom'])) {
		if(!rubrique_existe_deja($_GET['rubrique'])){
			modifer_nom_rubrique($_GET['rubrique'], $_POST['nouveau_nom']);
			Messages::info("Rubrique correctement modifiée !");
		} else {
			Messages::warn("Ce nom de rubrique existe déjà !");
		}
	} else {
		Messages::error("Erreur, il n'y a pas de rubrique à ajouter !");
	}
	editer_rubrique();
}

function modifier_mere_rubrique(){
	if (isset($_GET['rubrique']) && !empty($_GET['rubrique']) && isset($_POST['future_maman']) && !empty($_POST['future_maman'])) {
		// get id de l'ancienne association si elle existe
		$id_old_assoc = get_id_assoc_rub_ssrub($_GET['rubrique']);

		// on ajoute la nouvelle ligne
		add_assoc_rub_ssrub($_POST['future_maman'], $_GET['rubrique']);

		// on supprime l'ancienne si ça a réussi
		if(!!$id_old_assoc){
			delete_assoc_rub_ssrub($id_old_assoc["assocsrubrub_id"]);
		}
		Messages::info("Rubrique correctement modifiée !");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants !");
	}
	editer_rubrique();
}