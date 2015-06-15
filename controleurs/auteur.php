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
				break;
			case 'supprimer_article':
				supprimer_article();
				break;
			case 'recuperer_article':
				recuperer_article();
				break;
			case 'consulter_remarques':
				consulter_remarques();
				break;
			default:
				Messages::error('La page que vous demandez n\'existe pas !');
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
	$article_id=$_GET['article'];
	modif_statut_article($article_id,'En_redaction');
	$article=get_info_article($article_id);
	include('vues/auteur/editer_article.php');
}

function modifier_article(){
	$nbarg=$_POST["nbarg"];
	$titre=$_POST["titre"];

	$modif=array(
		"nbarg" => $nbarg,
		"titre" => $titre
		);
	for($i=1;$i<=$nbarg;$i++){
			$modif["titretexte".$i]=$_POST["titretexte".$i];
			$modif["corps".$i]=$_POST["corps".$i];
		}
	update_article($modif);
	Messages::info('Article correctement modifié');
	defaut();
}

function soumettre_article(){
	$article_id=$_GET['article'];
	modif_statut_article($article_id,'Soumis');
	Messages::info("L'article a bien été soumis");
	defaut();
}

function creer_article(){
	include('vues/auteur/creer_article.php');
}

function ajouter_article(){
	inserer_article($_POST["titre"],$_POST["titretexte"],$_POST["corps"]);
	Messages::info('Article correctement ajouté !');
	defaut();
}

function supprimer_article(){
	$article_id=$_GET['article'];
	supp_article($article_id);
	Messages::info("L'article a bien été supprimé");
	defaut();
}

function recuperer_article(){
	$article_id=$_GET['article'];
	desup_article($article_id);
	Messages::info("L'article a bien été récupéré");
	defaut();
}

function consulter_remarques(){
	if (isset($_GET['article']) && !empty($_GET['article'])) {
		$article = get_article($_GET['article']);
		$remarques = get_remarques($_GET['article']);
		include("vues/auteur/liste_remarques.php");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour consulter_remarques !");
		defaut();
	}
}