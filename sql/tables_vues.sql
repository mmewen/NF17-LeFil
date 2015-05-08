/*************************************************************************************************|
|	Rappel: "\i fichier" pour charger un script en PostgreSQL									  |
|	Sur Windows la console se trouve ici C:\Program Files\PostgreSQL\9.4\scripts/runpsql.bat	  |
|	Pour qu'elle se connecte automatiquement sur une base de donnée autre que celle par défaut	  |
|	il faut modifier le fichier runpsql.bat avec le bloc note lancé un mode administrateur        |
|	(sublime text ne fonctionne pas) et modifier la ligne SET database=basededonéesouhaité 		  |
|	On peut mettre du script psql dans les fichiers .sql (\d pour afficher les tables par ex)	  |
|	J'ai fait les tables un peu à l'aveugle, n'hésitez pas à les modifier si c'est nécéssaire	  |
|   A la fin de l'exécution \d montrera PLEIIIN de séquences, c'est pour incrémenter les id 	  |
*************************************************************************************************/

CREATE TABLE Personne (
	personne_id SERIAL PRIMARY KEY,
	personne_login VARCHAR(20) UNIQUE NOT NULL,
	personne_mail VARCHAR(255),
	personne_nom VARCHAR(100),
	personne_prenom VARCHAR(100)
);

\echo 'Personne'

CREATE TABLE Administrateur (
	admin_id SERIAL PRIMARY KEY REFERENCES Personne(personne_id),
	admin_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(personne_login) 
);

\echo 'Administrateur'

CREATE TABLE Auteur (
	auteur_id SERIAL PRIMARY KEY REFERENCES Personne(personne_id),
	auteur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(personne_login)
);

\echo 'Auteur'

CREATE TABLE Editeur (
	editeur_id SERIAL PRIMARY KEY REFERENCES Personne(personne_id),
	editeur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(personne_login)
);

\echo 'Editeur'

CREATE TABLE Lecteur (
	lecteur_id SERIAL PRIMARY KEY REFERENCES Personne(personne_id),
	lecteur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(personne_login)
);

\echo 'Lecteur'

CREATE TABLE Moderateur (
	moderateur_id SERIAL PRIMARY KEY REFERENCES Personne(personne_id),
	moderateur_login VARCHAR(20) UNIQUE NOT NULL REFERENCES Personne(personne_login)
);

\echo 'Moderateur'

CREATE TABLE ComiteEditorial (
	comedit_id SERIAL PRIMARY KEY,
	groupenom VARCHAR(50) UNIQUE NOT NULL
);

\echo 'ComiteEditorial'

CREATE TABLE Compose (
	compose_id SERIAL PRIMARY KEY,
	compose_editeur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	compose_comite INTEGER NOT NULL REFERENCES ComiteEditorial(comedit_id)
);

\echo 'Compose'

CREATE TABLE Rubrique (
	rubrique_id SERIAL PRIMARY KEY,
	rubrique_nom VARCHAR(50) UNIQUE NOT NULL,
	rubrique_createur INTEGER NOT NULL REFERENCES Editeur(editeur_id),
	rubrique_datecreation TIMESTAMP NOT NULL
);

\echo 'Rubrique'

CREATE TABLE Article (
	article_id SERIAL PRIMARY KEY,
	article_titre VARCHAR(50),
	article_supprime BOOLEAN,
	article_publie BOOLEAN,
	article_honneur BOOLEAN,
	article_comite INTEGER NOT NULL REFERENCES ComiteEditorial(comedit_id)
); --Statut n'est pas un attribut, il faut envoyer un mail à l'équipe de conception

\echo 'Article'

CREATE TABLE Image (
	image_id SERIAL PRIMARY KEY,
	image_titre VARCHAR(50) UNIQUE NOT NULL,
	image_article INTEGER NOT NULL REFERENCES Article(article_id),
	image_bitmap BYTEA NOT NULL
);

\echo 'Image'

CREATE TABLE Texte (
	texte_id SERIAL PRIMARY KEY,
	texte_titre VARCHAR(50) UNIQUE NOT NULL,
	texte_article SERIAL NOT NULL REFERENCES Article(article_id),
	texte_corps TEXT 
);

\echo 'Texte'

CREATE TYPE enum_statut AS ENUM (
	'A réviser', 'En rédaction', 'En relecture'
	'Rejeté', 'Soumis', 'Validé'
);

\echo 'ENUM_STATUT'

CREATE TABLE Statut (
	statut_type ENUM_STATUT PRIMARY KEY,
	statut_createur SERIAL NOT NULL REFERENCES Editeur(editeur_id),
	statut_datecreattion TIMESTAMP NOT NULL
); --Je comprends pas cette table

\echo 'Statut'

CREATE TABLE Remarque (
	remarque_id SERIAL PRIMARY KEY,
	remarque_corps TEXT NOT NULL,
	remarque_statut ENUM_STATUT NOT NULL REFERENCES Statut(statut_type)
);

\echo 'Remarque'

CREATE TABLE Commentaire (
	commentaire_id SERIAL PRIMARY KEY,
	commentaire_titre VARCHAR(50) NOT NULL,
	commentaire_corps TEXT NOT NULL ,
	commentaire_enExergue BOOLEAN,
	commentaire_masque BOOLEAN,
	commentaire_supprime BOOLEAN,
	commentaire_createur SERIAL NOT NULL REFERENCES Lecteur(lecteur_id),
	commentaire_article SERIAL NOT NULL REFERENCES Article(article_id),
	commentaire_datecreation TIMESTAMP NOT NULL,
	commentaire_datesuppression TIMESTAMP NOT NULL
);

\echo 'Commentaire'

CREATE TABLE MotsClefs (
	motsclefs_id SERIAL PRIMARY KEY,
	motsclefs_corps VARCHAR(20) UNIQUE NOT NULL,
	motsclefs_editeur SERIAL NOT NULL REFERENCES Editeur(editeur_id),
	motsclefs_datecreation TIMESTAMP NOT NULL
);

\echo 'MotsClefs'



/* HISTORIQUE ACTION AUTEUR */

CREATE TABLE Modifier_Statut_Auteur (
	modifstataut_id SERIAL PRIMARY KEY,
	modifstataut_datemodif TIMESTAMP NOT NULL,
	modifstataut_auteur SERIAL NOT NULL REFERENCES Auteur(auteur_id),
	modifstataut_article SERIAL NOT NULL REFERENCES Article(article_id),
	modifstataut_statut ENUM_STATUT NOT NULL REFERENCES Statut(statut_type)
);

\echo 'Modifier_Statut_Auteur'



/* HISTORIQUE ACTION MODERATEUR */

CREATE TABLE Supprimer_Commentaire (
	suppcomm_id SERIAL PRIMARY KEY,
	suppcomm_datesupp TIMESTAMP NOT NULL,
	suppcomm_commentaire SERIAL NOT NULL REFERENCES Commentaire(commentaire_id),
	suppcomm_moderateur SERIAL NOT NULL REFERENCES Moderateur(moderateur_id)
);

\echo 'Supprimer_Commentaire'

CREATE TABLE Mettre_Exergue_Commentaire (
	miseexcom_id SERIAL PRIMARY KEY,
	miseexcom_commentaire SERIAL NOT NULL REFERENCES Commentaire(commentaire_id),
	miseexcom_moderateur SERIAL NOT NULL REFERENCES Moderateur(moderateur_id)
);

\echo 'Mettre_Exergue_Commentaire'



/* HISTORIQUE ACTION EDITEUR */

CREATE TABLE Mettre_A_Honneur (
	misehonneur_id SERIAL PRIMARY KEY,
	misehonneur_editeur SERIAL NOT NULL REFERENCES Editeur(editeur_id),
	misehonneur_article SERIAL NOT NULL REFERENCES Article(article_id),
	misehonneur_datemisehonneur TIMESTAMP NOT NULL
);

\echo 'Mettre_A_Honneur'

CREATE TABLE Associer_Article_Rubrique (
	assocartrub_id SERIAL PRIMARY KEY,
	assocartrub_dateassoc TIMESTAMP NOT NULL,
	assocartrub_article SERIAL NOT NULL REFERENCES Article(article_id),
	assocartrub_rubrique SERIAL NOT NULL REFERENCES Rubrique(rubrique_id),
	assocartrub_editeur SERIAL NOT NULL REFERENCES Editeur(editeur_id)
);

\echo 'Associer_Article_Rubrique'

CREATE TABLE Modifier_Statut_Editeur (
	modifstatedit_id SERIAL PRIMARY KEY,
	modifstatedit_datemodif TIMESTAMP NOT NULL,
	modifstatedit_editeur SERIAL NOT NULL REFERENCES Editeur(editeur_id),
	modifstatedit_statut ENUM_STATUT NOT NULL REFERENCES Statut(statut_type),
	modifstatedit_article SERIAL NOT NULL REFERENCES Article(article_id)
);

\echo 'Modifier_Statut_Editeur'

CREATE TABLE Associer_Article_Article (
	assocartart_id SERIAL PRIMARY KEY,
	assocartart_dateassoc TIMESTAMP NOT NULL,
	assocartart_article1 SERIAL NOT NULL REFERENCES Article(article_id),
	assocartart_article2 SERIAL NOT NULL REFERENCES Article(article_id),
	assocartart_editeur SERIAL NOT NULL REFERENCES Editeur(editeur_id)
);

\echo 'Associer_Article_Article'

CREATE TABLE Indexer_Article (
	indexart_id SERIAL PRIMARY KEY,
	indexart_dateindex TIMESTAMP NOT NULL,
	indexart_motclef SERIAL NOT NULL REFERENCES MotsClefs(motsclefs_id),
	indexart_editeur SERIAL NOT NULL REFERENCES Editeur(editeur_id),
	indexart_article SERIAL NOT NULL REFERENCES Article(article_id)
);

\echo 'Indexer_Article'

CREATE TABLE Associer_SousRubrique_Rubrique (
	assocsrubrub_id SERIAL PRIMARY KEY,
	assocsrubrub_dateassoc TIMESTAMP NOT NULL,
	assocsrubrub_editeur SERIAL NOT NULL REFERENCES Editeur(editeur_id),
	assocsrubrub_rubrique SERIAL NOT NULL REFERENCES Rubrique(rubrique_id),
	assocsrubrub_sousrubrique SERIAL NOT NULL REFERENCES Rubrique(rubrique_id)
);

\echo 'Associer_SousRubrique_Rubrique'



/* CONTRAINTES */

-- Je sais pas comment faire


/* VUES */

--Je fais à l'arrache, je sais pas si c'est ce qu'il faut faire

CREATE VIEW vEditeur AS
	SELECT * FROM Personne
	INNER JOIN Editeur
	ON Personne.personne_id=Editeur.editeur_id;

\echo 'vEditeur'

CREATE VIEW vAdministrateur AS
	SELECT * FROM Personne
	INNER JOIN Administrateur
	ON Personne.personne_id=Administrateur.admin_id;

\echo 'vAdministrateur'

CREATE VIEW vModerateur AS
	SELECT * FROM Personne
	INNER JOIN Moderateur 
	ON Personne.personne_id=Moderateur.moderateur_id;

\echo 'vModerateur'

CREATE VIEW vAuteur AS
	SELECT * FROM Personne
	INNER JOIN Auteur 
	ON Personne.personne_id=Auteur.auteur_id;

\echo 'vAuteur'

CREATE VIEW vLecteur AS
	SELECT * FROM Personne
	INNER JOIN Lecteur
	ON Personne.personne_id=Lecteur.lecteur_id;

\echo 'vLecteur'

CREATE VIEW vArticleNonSupprime AS
	SELECT * FROM Article
	WHERE Article.article_supprime='0';

\echo 'vArticleNonSupprime'

CREATE VIEW vArticleHonneur AS
	SELECT * FROM Article
	WHERE Article.article_honneur='1';

\echo 'vArticleHonneur'

CREATE VIEW vArticlePublie AS
	SELECT * FROM Article
	WHERE Article.article_publie='1';

\echo 'vArticlePublie'

CREATE VIEW vCommentaireExergue AS
	SELECT * FROM Commentaire
	WHERE Commentaire.commentaire_enExergue='1';

\echo 'vCommentaireExergue'

CREATE VIEW vCommentaireNonMasque AS
	SELECT * FROM Commentaire
	WHERE Commentaire.commentaire_masque='0';

\echo 'vCommentaireNonMasque'

CREATE VIEW vCommentaireNonSupprime AS
	SELECT * FROM Commentaire
	WHERE Commentaire.commentaire_supprime='0';

\echo 'vCommentaireNonSupprime'

--\d