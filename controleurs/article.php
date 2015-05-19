<?php
include("modele/article.php"); // on inclue le modèle (= toutes les fonctions php d'accès à la BDD et tout)

// C'est ici qu'il faut vérifier si l'utilisateur est admin ou pas et tout
if (!empty($_GET['page'])) {
	switch ( $_GET['page'] ){	
		// case 'corriger_article':
		// 	corriger_article();
		// 	break;
		default:
			defaut();
			break;
	}
} else {
        defaut();
}

function defaut(){
	include('vues/article/defaut.php');
}