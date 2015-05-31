<?php

$admin_id=$_SESSION['Administrateur'];

include("modele/administration.php");

if(isset($admin_id) && $admin_id > 0){
	if (!empty($_GET['page'])) { 
		switch ( $_GET['page'] ){ 
			case 'creer_compte': creer_compte(); 
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
	include('vues/administration/defaut.php');
}

function creer_compte(){
	include('vues/administration/creer_compte.php');
}

function ajouter_compte(){
	$compte = create_account($_POST["login"],$_POST["mail"],$_POST["prenom"],$_POST["nom"]);
	switch($_POST["type"]){
		case "L" :
			create_account_lecteur($compte,$_POST["login"]);
			break;
		case "A" :
			create_account_auteur($compte,$_POST["login"]);
			break;
		case "E" :
			create_account_aditeur($compte,$_POST["login"]);
			break;
		case "M" :
			create_account_moderateur($compte,$_POST["login"]);
			break;
		case "Ad" :
			create_account_admin($compte,$_POST["login"]);
			break;
	}
	Messages::info('Compte correctement créé !');
	defaut();
}

function modif_compte(){
	$id = get_id($_POST["compte"]);
	switch($_POST["droit"]){
		case "L" :
			create_account_lecteur($id,$_POST["compte"]);
			break;
		case "A" :
			create_account_auteur($id,$_POST["compte"]);
			break;
		case "E" :
			create_account_aditeur($id,$_POST["compte"]);
			break;
		case "M" :
			create_account_moderateur($id,$_POST["compte"]);
			break;
		case "Ad" :
			create_account_admin($id,$_POST["compte"]);
			break;
	}
	Messages::info('Droits correctement ajoutés !');
	defaut();
}