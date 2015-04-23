# NF17-LeFil
Project in a database course at the Université de Technologie de Compiègne : create a website based on another group's analysis. Our subject is to do a news website.

## Liens utiles
* [Sujet du projet](http://nf17.crzt.fr/www/co/sujet5_leo.html)
* [Apprendre à utiliser Github](https://humantalks.com/talks/620-git-vous-ne-pourrez-plus-vous-en-passer)
* [Paramétrer psql au premier lancement](http://stackoverflow.com/questions/1471571/how-to-configure-postgresql-for-the-first-time)
* [Dillinger](http://dillinger.io/) pour faire un joli MakeDown file :)
* [Bootstrap](http://getbootstrap.com/examples/theme/) : une page d'exemple du style, copiez les classes pour faire jouli. Ya meme un carrousel, trop stylé :)

## Installation
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
