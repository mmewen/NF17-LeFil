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
			case 'editer_motcles_article':
				editer_motcles_article();
				break;
			case 'ajouter_motcle_article':
				ajouter_motcles_article();
				break;
			case 'supprimer_motcle_article':
				supprimer_mot_cle_article();
				break;
			case 'editer_rubrique_article':
				editer_rubrique_article();
				break;
			case 'ajouter_rubrique_article':
				ajouter_rubrique_article();
				break;
			case 'supprimer_rubrique_article':
				supprimer_rubrique_article();
				break;
			case 'editer_associations_articles':
				editer_associations_articles();
				break;
			case 'ajouter_assoc_article':
				ajouter_article_associe();
				break;
			case 'supprimer_assoc_article':
				supprimer_article_associe();
				break;
			case 'mettre_article_honneur':
				mettre_article_honneur();
				break;
			case 'enlever_article_honneur':
				enlever_article_honneur();
				break;
			case 'changer_statut':
				voir_statut();
				break;
			case 'modifier_statut_article':
				modifier_statut_article();
				break;
			case 'consulter_remarques':
				consulter_remarques();
				break;
			case 'consulter_article':
				consulter_article();
				break;
			case 'editer_article':
				editer_article();
				break;
			case 'modifier_article':
				modifier_article();
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
	include 'controleurs/accueil.php';
}

function defaut(){
	include('vues/edition/defaut.php');
}

function gerer_articles(){
	// on récupère les articles 'A_reviser', 'En_redaction', 'En_relecture', 'Rejete', 'Soumis', 'Valide'
	if (isset($_GET['trier_par']) && !empty($_GET['trier_par'])) {
		$trier_par = $_GET['trier_par'];
	} else {
		$trier_par = "statut";
	}
	$articles = get_tous_articles($trier_par);
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

function editer_motcles_article(){
	if (isset($_GET['article']) && !empty($_GET['article'])) {
		$id_article = $_GET['article'];
		$article = get_article($id_article);
		$motscles = get_motscles();
		include('vues/edition/editer_motcles_article.php');
	} else {
		Messages::error("Erreur, il y a des paramètres manquants !");
	}
	
}

function ajouter_motcles_article(){
	if (isset($_GET['article']) && !empty($_GET['article']) && isset($_POST['id_mot_cle']) && !empty($_POST['id_mot_cle'])) {
		add_motcle_article(intval($_POST['id_mot_cle']), intval($_GET['article']));
		Messages::info("Mot-clé correctement modifiée !");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants !");
	}
	editer_motcles_article();
}

function supprimer_mot_cle_article(){
	if (isset($_GET['article']) && !empty($_GET['article']) && isset($_GET['id_mot_cle']) && !empty($_GET['id_mot_cle'])) {
		supprimer_motcle_article(intval($_GET['id_mot_cle']), intval($_GET['article']));
		Messages::info("Mot-clé correctement modifiée !");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants !");
	}
	editer_motcles_article();
}

function editer_rubrique_article(){
	if (isset($_GET['article']) && !empty($_GET['article'])) {
		$id_article = $_GET['article'];
		$article = get_article($id_article);
		$rubriques = get_articles_rubriques($id_article);
		include('vues/edition/editer_rubriques_article.php');
	} else {
		Messages::error("Erreur, il y a des paramètres manquants !");
	}
}

function ajouter_rubrique_article(){
	if (isset($_GET['article']) && !empty($_GET['article']) && isset($_POST['id_rubrique']) && !empty($_POST['id_rubrique'])) {
		add_rubrique_article(intval($_POST['id_rubrique']), intval($_GET['article']));
		Messages::info("Rubrique correctement modifiée !");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants !");
	}
	editer_rubrique_article();
}

function supprimer_rubrique_article(){
	if (isset($_GET['article']) && !empty($_GET['article']) && isset($_GET['id_rubrique']) && !empty($_GET['id_rubrique'])) {
		delete_rubrique_article(intval($_GET['id_rubrique']), intval($_GET['article']));
		Messages::info("Rubrique correctement modifiée !");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants !");
	}
	editer_rubrique_article();
}

function editer_associations_articles(){
	if (isset($_GET['article']) && !empty($_GET['article'])) {
		$id_article = intval($_GET['article']);
		$article = get_article($id_article);
		$assoc_articles = get_articles_associes();
		include('vues/edition/editer_associations_articles.php');
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour editer_associations_articles !");
	}
}

function ajouter_article_associe(){
	if (isset($_GET['article']) && !empty($_GET['article']) && isset($_POST['article2']) && !empty($_POST['article2'])) {
		add_association_2articles(intval($_POST['article2']), intval($_GET['article']));
		Messages::info("Association inter-article correctement modifiée !");
	} else {
		var_dump($_GET);
		var_dump($_POST);
		Messages::error("Erreur, il y a des paramètres manquants pour ajouter_article_associe !");
	}
	editer_associations_articles();
}

function supprimer_article_associe(){
	if (isset($_GET['article']) && !empty($_GET['article']) && isset($_GET['article2']) && !empty($_GET['article2'])) {
		delete_association_2articles(intval($_GET['article2']), intval($_GET['article']));
		Messages::info("Association inter-article correctement modifiée !");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour supprimer_article_associe !");
	}
	editer_associations_articles();
}

function mettre_article_honneur(){
	if (isset($_GET['article']) && !empty($_GET['article'])) {
		put_honneur_article($_GET['article']);
		Messages::info("Article correctement mis à l'honneur !");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour mettre_article_honneur !");
	}
	gerer_articles();
}

function enlever_article_honneur(){
	if (isset($_GET['article']) && !empty($_GET['article'])) {
		delete_honneur_article($_GET['article']);
		Messages::info("Cet article ne sera plus mis à l'honneur !");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour enlever_article_honneur !");
	}
	gerer_articles();
}

function voir_statut(){
	if (isset($_GET['article']) && !empty($_GET['article'])) {
		set_en_relecture($_GET['article']);
		$statut = get_statut_article($_GET['article']);
		$article = get_article($_GET['article']);
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour changer_statut !");
	}
	include ('vues/edition/editer_statut_article.php');
}

function modifier_statut_article(){
	if (isset($_GET['article']) && !empty($_GET['article']) && isset($_POST['statut']) && !empty($_POST['statut'])) {
		switch ($_POST['statut']) {
			case 'A_reviser':
				if (isset($_POST['justification']) && !empty($_POST['justification'])) {
					add_remarque($_GET['article'], $_POST['justification'], $_POST['statut']);
					set_statut_article($_GET['article'], $_POST['statut']);
					Messages::info("Article marqué comme étant à réviser par l'auteur");
				} else {
					Messages::warn("Merci d'indiquer une justification pour cette révision !");
				}
				break;
			case 'Rejete':
				if (isset($_POST['justification']) && !empty($_POST['justification'])) {
					add_remarque($_GET['article'], $_POST['justification'], $_POST['statut']);
					set_statut_article($_GET['article'], $_POST['statut']);
					Messages::info("Article rejeté");
				} else {
					Messages::warn("Merci d'indiquer une justification pour ce rejet !");
				}
				break;
			case 'Valide':
				set_statut_article($_GET['article'], "Valide");
				Messages::info("Article correctement validé !");
				break;
			case 'Publier':
				set_article_publie($_GET['article']);
				Messages::info("Article correctement publié !");
				break;
			default:
				Messages::info("Le statut transmis n'est pas correct.");
				break;
		}
		voir_statut();
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour changer_statut !");
		defaut();
	}
}

function consulter_remarques(){
	if (isset($_GET['article']) && !empty($_GET['article'])) {
		$article = get_article($_GET['article']);
		$remarques = get_remarques($_GET['article']);
		include("vues/edition/liste_remarques.php");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour consulter_remarques !");
		defaut();
	}
}

function consulter_article(){
	if (isset($_GET['article']) && !empty($_GET['article'])) {
		set_en_relecture($_GET['article']);
		$id = $_GET['article'];
		$article = get_article($id);
		$textes = get_texte_article($id);
		$auteur = get_auteur($id);
		include("vues/edition/consulter_article.php");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour consulter_article !");
		defaut();
	}
}

function editer_article(){
	if (isset($_GET['article']) && !empty($_GET['article'])) {
		$article = get_article($_GET['article']);
		$textes = get_texte_article($_GET['article']);
		include("vues/edition/editer_article.php");
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour editer_article !");
		defaut();
	}
}

function modifier_article(){
	if (isset($_GET['article']) && !empty($_GET['article']) && isset($_POST['titre']) && !empty($_POST['titre']) && isset($_POST['nbarg']) && !empty($_POST['nbarg'])) {
		$nbarg=$_POST["nbarg"];
		$titre=$_POST["titre"];

		$modif=array(
			"nbarg" => $nbarg,
			"titre" => $titre
			);
		for($i=0;$i<$nbarg;$i++){
			$modif["idtexte".$i]=$_POST["idtexte".$i];
			$modif["titretexte".$i]=$_POST["titretexte".$i];
			$modif["corps".$i]=$_POST["corps".$i];
		}

		update_article($_GET['article'], $modif);
		Messages::info('Article correctement modifié');
		consulter_article();
	} else {
		Messages::error("Erreur, il y a des paramètres manquants pour editer_article !");
		defaut();
	}
}