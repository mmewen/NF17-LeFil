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
	personne_login VARCHAR(20) UNIQUE NOT NULL,
	personne_mail VARCHAR(255),
	personne_nom VARCHAR(100),
	personne_prenom VARCHAR(100)
);

CREATE TABLE Administrateur (
	admin_id INTEGER PRIMARY KEY REFERENCES Personne(personne_id),
	admin_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(personne_login) 
);

CREATE TABLE Auteur (
	auteur_id INTEGER PRIMARY KEY REFERENCES Personne(personne_id),
	auteur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(personne_login)
);

CREATE TABLE Editeur (
	editeur_id INTEGER PRIMARY KEY REFERENCES Personne(personne_id),
	editeur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(personne_login)
);

CREATE TABLE Lecteur (
	lecteur_id INTEGER PRIMARY KEY REFERENCES Personne(personne_id),
	lecteur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(personne_login)
);

CREATE TABLE Moderateur (
	mod_id INTEGER PRIMARY KEY REFERENCES Personne(personne_id),
	mod_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(personne_login)
);

CREATE TABLE ComiteEditorial (
	comedit_id INTEGER PRIMARY KEY,
	groupenom VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Compose (
	compose_id INTEGER PRIMARY KEY,
	compose_editeur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	compose_comite INTEGER NOT NULL REFERENCES ComiteEditorial(comedit_id)
);

CREATE TABLE Rubrique (
	rubrique_id INTEGER PRIMARY KEY,
	rubrique_nom VARCHAR(50) UNIQUE NOT NULL,
	rubrique_createur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	rubrique_datecreation TIMESTAMP NOT NULL
);

CREATE TABLE Article (
	article_id INTEGER PRIMARY KEY,
	article_titre VARCHAR(50),
	article_supprime BOOLEAN,
	article_publie BOOLEAN,
	article_honneur BOOLEAN,
	article_comite INTEGER NOT NULL REFERENCES ComiteEditorial(comedit_id)
); --Statut n'est pas un attribut, il faut envoyer un mail à l'équipe de conception


CREATE TABLE Image (
	image_id INTEGER PRIMARY KEY,
	image_titre VARCHAR(50) UNIQUE NOT NULL,
	image_article INTEGER NOT NULL REFERENCES Article(article_id),
	image_bitmap BYTEA NOT NULL
);

CREATE TABLE Texte (
	texte_id INTEGER PRIMARY KEY,
	texte_titre VARCHAR(50) UNIQUE NOT NULL,
	texte_article INTEGER NOT NULL REFERENCES Article(article_id),
	texte_corps TEXT 
);

CREATE TYPE enum_statut AS ENUM (
	'A réviser', 'En rédaction', 'En relecture'
	'Rejeté', 'Soumis', 'Validé'
);

CREATE TABLE Statut (
	statut_type ENUM_STATUT PRIMARY KEY,
	statut_createur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	statut_datecreattion TIMESTAMP NOT NULL
); --Je comprends pas cette table

CREATE TABLE Remarque (
	remarque_id INTEGER PRIMARY KEY,
	remarque_corps TEXT NOT NULL,
	remarque_statut ENUM_STATUT NOT NULL REFERENCES Statut(statut_type)
);

CREATE TABLE Commentaire (
	commentaire_id INTEGER PRIMARY KEY,
	commentaire_titre VARCHAR(50) NOT NULL,
	commentaire_corps TEXT NOT NULL ,
	commentaire_enExergue BOOLEAN,
	commentaire_masque BOOLEAN,
	commentaire_supprime BOOLEAN,
	commentaire_createur INTEGER NOT NULL REFERENCES Lecteur(lecteur_id),
	commentaire_article INTEGER NOT NULL REFERENCES Article(article_id),
	commentaire_datecreation TIMESTAMP NOT NULL,
	commentaire_datesuppression TIMESTAMP NOT NULL
);

CREATE TABLE MotsClefs (
	motsclefs_id INTEGER PRIMARY KEY,
	motsclefs_corps VARCHAR(20) UNIQUE NOT NULL,
	motsclefs_editeur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	motsclefs_datecreation TIMESTAMP NOT NULL
);



/* HISTORIQUE ACTION AUTEUR */

CREATE TABLE Modifier_Statut_Auteur (
	modifstataut_id INTEGER PRIMARY KEY,
	modifstataut_datemodif TIMESTAMP NOT NULL,
	modifstataut_auteur INTEGER NOT NULL REFERENCES Auteur(auteur_id),
	modifstataut_article INTEGER NOT NULL REFERENCES Article(article_id),
	modifstataut_statut ENUM_STATUT NOT NULL REFERENCES Statut(statut_type)
);



/* HISTORIQUE ACTION MODERATEUR */

CREATE TABLE Supprimer_Commentaire (
	suppcomm_id INTEGER PRIMARY KEY,
	suppcomm_datesupp TIMESTAMP NOT NULL,
	suppcomm_commentaire INTEGER NOT NULL REFERENCES Commentaire(commentaire_id),
	suppcomm_moderateur INTEGER NOT NULL REFERENCES Moderateur(mod_id)
);

CREATE TABLE Mettre_Exergue_Commentaire (
	miseexcom_id INTEGER PRIMARY KEY,
	miseexcom_commentaire INTEGER NOT NULL REFERENCES Commentaire(commentaire_id),
	miseexcom_moderateur INTEGER NOT NULL REFERENCES Moderateur(mod_id)
);



/* HISTORIQUE ACTION EDITEUR */

CREATE TABLE Mettre_A_Honneur (
	misehonneur_id INTEGER PRIMARY KEY,
	misehonneur_editeur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	misehonneur_article INTEGER NOT NULL REFERENCES Article(article_id),
	misehonneur_datemisehonneur TIMESTAMP NOT NULL
);

CREATE TABLE Associer_Article_Rubrique (
	assocartrub_id INTEGER PRIMARY KEY,
	assocartrub_dateassoc TIMESTAMP NOT NULL,
	assocartrub_article INTEGER NOT NULL REFERENCES Article(article_id),
	assocartrub_rubrique INTEGER NOT NULL REFERENCES Rubrique(rubrique_id),
	assocartrub_editeur INTEGER NOT NULL REFERENCES Editeur(editeur_id)
);

CREATE TABLE Modifier_Statut_Editeur (
	modifstatedit_id INTEGER PRIMARY KEY,
	modifstatedit_datemodif TIMESTAMP NOT NULL,
	modifstatedit_editeur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	modifstatedit_statut ENUM_STATUT NOT NULL REFERENCES Statut(statut_type),
	modifstatedit_article INTEGER NOT NULL REFERENCES Article(article_id)
);

CREATE TABLE Associer_Article_Article (
	assocartart_id INTEGER PRIMARY KEY,
	assocartart_dateassoc TIMESTAMP NOT NULL,
	assocartart_article1 INTEGER NOT NULL REFERENCES Article(article_id),
	assocartart_article2 INTEGER NOT NULL REFERENCES Article(article_id),
	assocartart_editeur INTEGER NOT NULL REFERENCES Editeur(editeur_id)
);

CREATE TABLE Indexer_Article (
	indexart_id INTEGER PRIMARY KEY,
	indexart_dateindex TIMESTAMP NOT NULL,
	indexart_motclef INTEGER NOT NULL REFERENCES MotsClefs(motsclefs_id),
	indexart_editeur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	indexart_article INTEGER NOT NULL REFERENCES Article(article_id)
);

CREATE TABLE Associer_Sous_Rubrique_Rubrique (
	assocsrubrub_id INTEGER PRIMARY KEY,
	assocsrubrub_dateassoc TIMESTAMP NOT NULL,
	assocsrubrub_editeur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	assocsrubrub_rubrique INTEGER NOT NULL REFERENCES Rubrique(rubrique_id),
	assocsrubrub_sousrubrique INTEGER NOT NULL REFERENCES Rubrique(rubrique_id)
);

\d

/* CONTRAINTES */

-- Je sais pas comment faire


/* VUES */

--Je fais à l'arrache, je sais pas si c'est ce qu'il faut faire

CREATE VIEW vEditeur AS
	SELECT * FROM Personne
	INNER JOIN Editeur
	ON Personne.personne_id=Editeur.editeur_id;

CREATE VIEW vAdministrateur AS
	SELECT * FROM Personne
	INNER JOIN Administrateur
	ON Personne.personne_id=Administrateur.admin_id;

CREATE VIEW vModerateur AS
	SELECT * FROM Personne
	INNER JOIN Moderateur 
	ON Personne.personne_id=Moderateur.mod_id;

CREATE VIEW vAuteur AS
	SELECT * FROM Personne
	INNER JOIN Auteur 
	ON Personne.personne_id=Auteur.auteur_id;

CREATE VIEW vLecteur AS
	SELECT * FROM Personne
	INNER JOIN Lecteur
	ON Personne.personne_id=Lecteur.lecteur_id;

CREATE VIEW vArticleNonSupprime AS
	SELECT * FROM Article
	WHERE Article.article_supprime='0';

CREATE VIEW vArticleHonneur AS
	SELECT * FROM Article
	WHERE Article.article_honneur='1';

CREATE VIEW vArticlePublie AS
	SELECT * FROM Article
	WHERE Article.article_publie='1';

CREATE VIEW vCommentaireExergue AS
	SELECT * FROM Commentaire
	WHERE Commentaire.commentaire_enExergue='1';

CREATE VIEW vCommentaireNonMasque AS
	SELECT * FROM Commentaire
	WHERE Commentaire.commentaire_masque='0';

CREATE VIEW vCommentaireNonSupprime AS
	SELECT * FROM Commentaire
	WHERE Commentaire.commentaire_supprime='0';

