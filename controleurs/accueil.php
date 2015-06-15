<?php
if(isset($_GET['connexion']) && $_GET['connexion']==1)
	Messages::info('Connexion réussie');
if(isset($_GET['deconnexion']) && $_GET['deconnexion']==1)
	Messages::info('Déconnexion réussie');

include 'vues/accueil.php';