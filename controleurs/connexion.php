<?php
include("modele/connexion.php"); // on inclue le modèle (= toutes les fonctions php d'accès à la BDD et tout)

// C'est ici qu'il faut vérifier si l'utilisateur est admin ou pas et tout
if (!empty($_GET['page'])) {
	switch ( $_GET['page'] ){
		case 'deconnexion':
			deconnexion();
			break;
		case 'verifier_connexion':
			verifier_connexion();
			break;
		default:
			defaut();
			break;
	}
} else {
        defaut();
}

function defaut(){
	if (!empty($_SESSION['login'])) {
		include('vues/accueil.php');
	} else {
		include('vues/connexion/defaut.php');
	}
}

function deconnexion(){
	Messages::info("Déconnexion réussie !");
	session_destroy();
	include('vues/accueil.php');
}

function verifier_connexion(){
	// Vérifier que la personne a un compte et que le mdp est bon
	if(isset($_POST["login"]) && isset($_POST["mdp"]) && !empty($_POST["login"]) && !empty($_POST["mdp"]) && is_login_mdp_corrects($_POST["login"], $_POST["mdp"])){
		$_SESSION['login'] = $_POST["login"];

		// Vérifier les droits
		$_SESSION['Administrateur'] = true;
		$_SESSION['Auteur'] = true;
		$_SESSION['Editeur'] = true;
		$_SESSION['Lecteur'] = true;
		$_SESSION['Moderateur'] = true;


		Messages::info("Connexion réussie !");
		include('vues/accueil.php');
	} else {
		// Identifiants incorrects
		Messages::error("Identifiants/mot de passe incorrect(s) !");
		include('vues/connexion/defaut.php');
	}
	
}