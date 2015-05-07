/*************************************************************************************************|
|	Rappel: "\i fichier" pour charger un script en PostgreSQL									  |
|	Sur Windows la console se trouve ici C:\Program Files\PostgreSQL\9.4\scripts/runpsql.bat	  |
|	Pour qu'elle se connecte automatiquement sur une base de donnée autre que celle par défaut	  |
|	il faut modifier le fichier runpsql.bat avec le bloc note lancé un mode administrateur        |
|	(sublime text ne fonctionne pas) et modifier la ligne SET database=basededonéesouhaité 		  |
|	On peut mettre du script psql dans les fichiers .sql (\d pour afficher les tables par ex)	  |
|	J'ai fait les tables un peu à l'aveugle, n'hésitez pas à les modifier si c'est nécéssaire	  |
*************************************************************************************************/

CREATE TABLE Personne (
	personne_id INTEGER PRIMARY KEY,
	login VARCHAR(20) UNIQUE NOT NULL,
	mail VARCHAR(255),
	nom VARCHAR(100),
	prenom VARCHAR(100)
);

CREATE TABLE Administrateur (
	administrateur_id INTEGER PRIMARY KEY REFERENCES Personne(personne_id),
	administrateur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(login) 
);

CREATE TABLE Auteur (
	auteur_id INTEGER PRIMARY KEY REFERENCES Personne(personne_id),
	auteur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(login)
);

CREATE TABLE Editeur (
	editeur_id INTEGER PRIMARY KEY REFERENCES Personne(personne_id),
	editeur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(login)
);

CREATE TABLE Lecteur (
	lecteur_id INTEGER PRIMARY KEY REFERENCES Personne(personne_id),
	lecteur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(login)
);

CREATE TABLE Moderateur (
	moderateur_id INTEGER PRIMARY KEY REFERENCES Personne(personne_id),
	moderateur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(login)
);

CREATE TABLE ComiteEditorial (
	comiteeditorial_id INTEGER PRIMARY KEY,
	groupenom VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Compose (
	editeurcompose_id INTEGER PRIMARY KEY,
	editeur INTEGER UNIQUE NOT NULL REFERENCES Editeur(editeur_id),
	comite INTEGER UNIQUE NOT NULL REFERENCES ComiteEditorial(comiteeditorial_id)
);

CREATE TABLE Rubrique (
	rubrique_id INTEGER PRIMARY KEY,
	rubrique_nom VARCHAR(50) UNIQUE NOT NULL,
	createur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	dateCreationRub TIMESTAMP NOT NULL
);

CREATE TABLE Article (
	article_id INTEGER PRIMARY KEY,
	article_titre VARCHAR(50),
	supprime BOOLEAN,
	publie BOOLEAN,
	honneur BOOLEAN,
	article_comite INTEGER UNIQUE NOT NULL REFERENCES ComiteEditorial(comiteeditorial_id)
); --Statut n'est pas un attribut, il faut envoyer un mail à l'équipe de conception


CREATE TABLE Image (
	image_id INTEGER PRIMARY KEY,
	image_titre VARCHAR(50) UNIQUE NOT NULL,
	image_article INTEGER UNIQUE NOT NULL REFERENCES Article(article_id),
	bitmap BYTEA NOT NULL
);

CREATE TABLE Texte (
	texte_id INTEGER PRIMARY KEY,
	texte_titre VARCHAR(50) UNIQUE NOT NULL,
	texte_article INTEGER UNIQUE NOT NULL REFERENCES Article(article_id),
	texte_corps TEXT 
);

/*
CREATE TABLE Statut (
	)
*/

\d