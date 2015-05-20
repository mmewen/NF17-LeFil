<?php
//On démarre la session (permet de maintenir des informations de connection)
session_start();
 
//On se connecte à MySQL
include_once("classes/Db.class.php");
$bdd = DB::connect();

//On importe la classe de messages
include_once("classes/Messages.class.php");

//On inclut l'entête'
include 'vues/haut.php';

//On inclut le contrôleur s'il existe et s'il est spécifié
if (!empty($_GET['module']) && is_file('controleurs/'.$_GET['module'].'.php'))
{
    include 'controleurs/'.$_GET['module'].'.php';
}
else
{
    include 'controleurs/accueil.php';
}
 
//On inclut le pied de page
include 'vues/bas.php';
 
//On ferme la connexion à MySQL
DB::close();