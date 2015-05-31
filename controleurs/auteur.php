<?php

$auteur_id=$_SESSION['Auteur'];

include("modele/auteur.php"); // on inclue le modèle (= toutes les fonctions php d'accès à la BDD et tout)

if (isset($auteur_id) && $auteur_id > 0){ // équivaut à dire "l'utilisateur a un id d'auteur" donc "l'utilisateur est auteur"
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
			case 'creer_article':
				creer_article();
				break;
			case 'ajouter_article':
				ajouter_article();
				break;
			case 'editer_article':
				editer_article();
				break;
			case 'modifier_article':
				modifier_article();
				break;
			case 'soumettre_article':
				soumettre_article();
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
	$articles=get_article_auteur();
	include('vues/auteur/defaut.php');
}

function editer_article(){
	$article=get_info_article($_GET['article']);
	include('vues/auteur/editer_article.php');
}

function modifier_article(){
	$nbarg=$_POST["nbarg"];
	$titre=$_POST["titre"];


	$modif=array(
		"nbarg" => $nbarg,
		"titre" => $titre//,
		);
	for($i=1;$i<=$nbarg;$i++){
			$modif["titretexte".$i.""]=$_POST["titretexte".$i.""];
			$modif["corps".$i.""]=$_POST["corps".$i.""];
		}
	update_article($modif);
	Messages::info('Article correctement modifié');
	defaut();
}

function soumettre_article(){
	$article_id=$_GET['article'];
	submit_article($article_id);
	Messages::info("L'article a bien été soumis");
}

function creer_article(){
	include('vues/auteur/creer_article.php');
}

function ajouter_article(){
	inserer_article($_POST["titre"],$_POST["titretexte"],$_POST["corps"]);
	Messages::info('Article correctement ajouté !');
	defaut();
}