<?php
include("modele/moderation.php"); // on inclue le modèle (= toutes les fonctions php d'accès à la BDD et tout)

if (isset($_SESSION['Moderateur']) && $_SESSION['Moderateur'] > 0){ // équivaut à dire "l'utilisateur a un id de modérateur" donc "l'utilisateur est modérateur"
	if (!empty($_GET['page'])) {
		switch ( $_GET['page'] ){	
			case 'editer_commentaire':
				if (isset($_GET['commentaire'])) {
					editer_commentaire($_GET['commentaire']);
				} else {
					defaut();
				}
				break;
			case 'demasquer':
				demasquer();
				break;
			case 'masquer':
				masquer();
				break;
			case 'exerguer':
				exerguer();
				break;
			case 'supprimer':
				supprimer();
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
	$comms = get_all_commentaires();
	include('vues/moderation/defaut.php');
}

function editer_commentaire($id_com){
	if (!empty($id_com)){
		$com = get_commentaire($id_com);
		include('vues/moderation/editer_commentaire.php');
	} else {
		Message::warn('Commentaire inexistant');
		defaut();
	}
}

function demasquer(){
	$id_com = $_GET['commentaire'];
	demasquer_commentaire($id_com);
	Messages::info('Le démasquage a bien été pris en compte');
	editer_commentaire($id_com);
}

function masquer(){
	$id_com = $_GET['commentaire'];
	masquer_commentaire($id_com);
	Messages::info('Le masquage a bien été pris en compte');
	editer_commentaire($id_com);
}

function exerguer(){
	$id_com = $_GET['commentaire'];
	exerguer_commentaire($id_com);
	Messages::info('La mise en exergue a bien été prise en compte');
	editer_commentaire($id_com);
}

function supprimer(){
	$id_com = $_GET['commentaire'];
	supprimer_commentaire($id_com);
	Messages::info('La suppression a bien été prise en compte');
	editer_commentaire($id_com);
}
