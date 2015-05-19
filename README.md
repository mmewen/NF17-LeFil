# NF17-LeFil
Project in a database course at the Université de Technologie de Compiègne : create a website based on another group's analysis. Our subject is to do a news website.

## Liens utiles
* [Sujet du projet](http://nf17.crzt.fr/www/co/sujet5_leo.html)
* [Apprendre à utiliser Github](https://humantalks.com/talks/620-git-vous-ne-pourrez-plus-vous-en-passer)
* [Paramétrer psql au premier lancement](http://stackoverflow.com/questions/1471571/how-to-configure-postgresql-for-the-first-time)
* [Dillinger](http://dillinger.io/) pour faire un joli MakeDown file :)
* [Bootstrap](http://getbootstrap.com/examples/theme/) : une page d'exemple du style, copiez les classes pour faire jouli. Ya meme un carrousel, trop stylé :)

## Installation
### Linux
* Paquets à installer :
	* Le serveur + php of course : `apache2 php5`
	* Le SGBD : `postgresql`
	* Un truc utile mais je sais pas pourquoi : `rpm`
	* Pareil, celui là sert à ce que PHP trouve Postgres (ça peut servir...) : `php5-pgsql`

* Il faut lancer apache avec la commande suivante :
```
	sudo service apache2 start/restart/stop
```

* Sur votre PC par défaut les fichiers web se trouvent dans `/var/www`. Je vous recommande de faire un lien symbolique :
```
	cd /var/www(/html)
	sudo ln -s (path to nf17 directory) nf17
```
Comme ça vous aurez accès au site en faisant : `127.0.0.1/nf17` :)
* Pensez bien à faire un `chmod` de tous les dossiers parents de votre dossier nf17 où other n'a pas de droit 'r', forcément ^^
* Ajoutez un utilisateur dans la BDD avec le liens au dessus
* Si votre PHP n'imprime pas les erreurs dans le HTML, modifiez le fichier `php.ini` de votre système en mettant `display_startup_errors` et `display_errors` à `On`

### Windows

#### Installer [Postgres](http://www.postgresql.org/download/windows)
* Spammer `suivant` et `ok`
* Lancer `PG Admin III`, se connecter au serveur puis créer une base de donnée (nf17 par exemple). Le propriétaire de la BD devrait être `postgres` et le mot de passe est au choix.

#### Installer [Wamp]()
* Spammer `suivant` et `ok`
* Aller dans `Ordinateur` -> `Propriétés` -> `Avancé` -> `Variables d'environnement`
* Dans la liste des variables systèmes ajouter `;C:/wamp/bin/php/php5.5.12` (en fonction du chemin et de la version de php).
* Aller sur l'icône `wamp` -> `apache` -> `alias directories` -> `add an alias`, une invite de commande s'ouvre
* Taper `phppgadmin` puis entrer
* Taper `C:/wamp/apps/phppgadmin` puis entrer
* Ensuite aller sur l'icône `wamp` -> `PHP` -> `PHP Extensions` -> `php_pgsql` et `php_pdo_pgsl`
* Redémarer WAMP

#### Installer [PHPpgAdmin](http://phppgadmin.sourceforge.net/doku.php?id=download) 
* Extraire le .zip dans `C:/wamp/apps`	
* Aller dans `conf/config.inc.php`
	Changer 
		
	    //    $conf['servers'][0]['desc'] = 'PostgreSQL';
		$conf['servers'][0]['desc'] = 'PostgreSQL_local'; //+

		//    $conf['servers'][0]['host'] = '';    
		$conf['servers'][0]['host'] = '127.0.0.1';//+

		//    $conf['servers'][0]['pg_dump_path'] = '/usr/bin/pg_dump';
		//    $conf['servers'][0]['pg_dumpall_path'] = '/usr/bin/pg_dumpall';
		$conf['servers'][0]['pg_dump_path'] = 'C:\Program Files\PostgreSQL\9.4\bin\pg_dump.exe'; (à changer)//+
		$conf['servers'][0]['pg_dumpall_path'] = 'C:\Program Files\PostgreSQL\9.4\bin\pg_dumpall.exe'; (à changer)//+

		//    $conf['extra_login_security'] = true;
		$conf['extra_login_security'] = false; // par défaut à true,

* Aller dans `C:/wamp/alias/` et modifier `phppgadmin.conf`, il doit ressembler à ça :
      Alias /phppgadmin/ "C:\wamp\apps\phppgadmin/" 

	  <Directory "C:\wamp\apps\phppgadmin">
        Options Indexes FollowSymLinks MultiViews
    	AllowOverride all
            Order allow,deny
   	    Allow from all
        Require local
      </Directory>

Normalement tout devrait être bon !

Ouvrir SQL Shell et taper `\i C:/wamp/www/nf17/sql/reset.sql` pour remplir la base données

Il y a des instructions intéressantes en commentaires dans le fichier sql/tables_vues

## TODO
* check SQL à l'insertion dans le BD (dates par exemple)
* Triggers pour toutes les mises à jour. Prendre exemple sur celui déjà fait
* Envoyer un mail au groupe précédent pour éclaircir le fonctionnement des statuts
* Changer la table personne et virer les tables admins et tout
* faire la structure du site (choisir les modules à faire et créer les modèles, vues et contrôlleurs associés)
* faire un menu dynamique


## Rendus
* 3 requêtes compliquées + 1 trigger dans un fichier sql
* slides de la présentation
* code PHP du site

## Présentation
* 30 minutes également réparties (20 minutes de présentation et questions + 10 min de démo **préparée**)
* présentation de ce qui a été développé
	- rapide de l'UML : surtout nos modifications
	- exemples de tables et 1 ou 2 requête(s) compliquée(s) intéressantes,
	- exemple de données
	- un trigger
	- présentation du site
	- trucs sympas