<?php

$admin_id=$_SESSION['Administrateur'];

include("modele/administration.php");

if(isset($admin_id) && $admin_id > 0){
	if (!empty($_GET['page'])) { 
		switch ( $_GET['page'] ){ 
			case 'creer_compte': creer_compte(); 
				break; 
			case 'ajouter_compte' : ajouter_compte();
				break;
			case 'modif_compte': modif_compte();
				break;
			default: defaut(); 
				break; 
			} 
			} 
			else { 
				defaut(); 
			}
} else {
	Messages::error("Page inaccessible avec vos droits actuels");
	include('controleurs/accueil.php');
}

function defaut(){
	$comptes = get_comptes();
	$droits = get_droits();
	include('vues/administration/defaut.php');
}

function creer_compte(){
	include('vues/administration/creer_compte.php');
}

function ajouter_compte(){
	create_account($_POST["login"],$_POST["mail"],$_POST["nom"],$_POST["prenom"]);
	$ID = get_id($_POST["login"]);
	switch($_POST["type"]){
		case "L" :
			create_account_lecteur($ID["personne_id"],$_POST["login"]);
			break;
		case "A" :
			create_account_auteur($ID["personne_id"],$_POST["login"]);
			break;
		case "E" :
			create_account_editeur($ID["personne_id"],$_POST["login"]);
			break;
		case "M" :
			create_account_moderateur($ID["personne_id"],$_POST["login"]);
			break;
		case "Ad" :
			create_account_admin($ID["personne_id"],$_POST["login"]);
			break;
	}
	Messages::info('Compte correctement créé !');
	defaut();
}

function modif_compte(){
	$ID = get_id($_POST["compte"]);
	switch($_POST["droit"]){
		case "L" :
			create_account_lecteur($ID["personne_id"],$_POST["compte"]);
			break;
		case "A" :
			create_account_auteur($ID["personne_id"],$_POST["compte"]);
			break;
		case "E" :
			create_account_editeur($ID["personne_id"],$_POST["compte"]);
			break;
		case "M" :
			create_account_moderateur($ID["personne_id"],$_POST["compte"]);
			break;
		case "Ad" :
			create_account_admin($ID["personne_id"],$_POST["compte"]);
			break;
	}
	Messages::info('Droits correctement ajoutés !');
	defaut();
}