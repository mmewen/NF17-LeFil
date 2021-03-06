/* 
INSERTION DES DONNEES TEST 
J'ai considéré que l'on utilisera des triggers et des update pour mettre 
tout les trucs à jours mais on peut faire autrement évidemment
J'ai essayé de faire en sorte que la plupart des données aie un sens mais je garantis rien ^^
*/

/* Pour que j'ai plus de problème caca avec les caractères bizarres */

SET client_encoding='UTF8';

INSERT INTO Personne (personne_login, personne_mail, personne_nom, personne_prenom)
VALUES ('login1','login1@etu.utc.fr','nom1','prenom1');
INSERT INTO Personne (personne_login, personne_mail, personne_nom, personne_prenom)
VALUES ('login2','login2@etu.utc.fr','nom2','prenom2');
INSERT INTO Personne (personne_login, personne_mail, personne_nom, personne_prenom)
VALUES ('login3','login3@etu.utc.fr','nom3','prenom3');
INSERT INTO Personne (personne_login, personne_mail, personne_nom, personne_prenom)
VALUES ('login4','login4@etu.utc.fr','nom4','prenom4');
INSERT INTO Personne (personne_login, personne_mail, personne_nom, personne_prenom)
VALUES ('login5','login5@etu.utc.fr','nom5','prenom5');
INSERT INTO Personne (personne_login, personne_mail, personne_nom, personne_prenom)
VALUES ('login6','login6@etu.utc.fr','nom6','prenom6');
-- SELECT * FROM Personne;


INSERT INTO Administrateur (admin_id, admin_login)
VALUES (1,'login1');

-- SELECT * FROM Administrateur;



INSERT INTO Auteur (auteur_id, auteur_login)
VALUES (2,'login2');
INSERT INTO Auteur (auteur_id, auteur_login)
VALUES (6,'login6');

-- SELECT * FROM Auteur;



INSERT INTO Editeur (editeur_id, editeur_login)
VALUES (3,'login3');

-- SELECT * FROM Editeur;



INSERT INTO Lecteur (lecteur_id, lecteur_login)
VALUES (4,'login4');

-- SELECT * FROM Lecteur;



INSERT INTO Moderateur (moderateur_id, moderateur_login)
VALUES (5,'login5');

-- SELECT * FROM Moderateur;



INSERT INTO ComiteEditorial (comedit_groupenom)
VALUES ('Groupe Cool');

-- SELECT * FROM ComiteEditorial;



INSERT INTO Compose (compose_editeur, compose_comite)
VALUES (3,1);

-- SELECT * FROM Compose;



INSERT INTO Rubrique (rubrique_nom, rubrique_createur, rubrique_datecreation)
VALUES ('Rubrique Marrante',3,'2015-05-08 21:37:50');

INSERT INTO Rubrique (rubrique_nom, rubrique_createur, rubrique_datecreation)
VALUES ('Rubrique Triste',3,'2015-05-08 21:37:50');

-- SELECT * FROM Rubrique;



INSERT INTO Article (article_titre, article_supprime, article_publie, 
					 article_honneur, article_comite)
VALUES ('Article nul',FALSE,TRUE,FALSE,1);
INSERT INTO Article (article_titre, article_supprime, article_publie, 
					 article_honneur, article_comite)
VALUES ('Article bien',FALSE,FALSE,FALSE,1);

INSERT INTO Article (article_titre, article_supprime, article_publie, 
					 article_honneur, article_comite)
VALUES ('Article moyen',FALSE,FALSE,FALSE,1);
INSERT INTO Article (article_titre, article_supprime, article_publie, 
					 article_honneur, article_comite)
VALUES ('Article médiocre',FALSE,TRUE,FALSE,1);

-- SELECT * FROM Article;


/* 
Fonction qui permet d'importer une image dans la base de donnée 
au format hexadecimal
Me demandez pas comment ça fonctionne, je l'ai chopé sur un forum
Tout ce que je sais c'est que ça utilise le language plpgsql qui est
un language procédural pour psql
Autrefois on appelait ça de la magie noire
*/

create or replace function bytea_import(p_path text, p_result out bytea) 
                   language plpgsql as $$
declare
  l_oid oid;
  r record;
begin
  p_result := '';
  SELECT lo_import('C:\wamp\www\nf17\images\pgsql-logo.png') into l_oid;
  for r in ( SELECT data 
             from pg_largeobject 
             where loid = l_oid 
             order by pageno ) loop
    p_result = p_result || r.data;
  end loop;
  perform lo_unlink(l_oid);
end;$$;

INSERT INTO Image (image_titre, image_article, image_bitmap)
VALUES ('Image belle',1,bytea_import('C:\wamp\www\nf17\images\pgsql-logo.png'));

-- SELECT * FROM Image;



INSERT INTO Texte (texte_titre, texte_article, texte_corps)
VALUES ('Texte beau',1,'Techno, toujours pareil,
		 				BOUM BOUM dans les oreilles');
INSERT INTO Texte (texte_titre, texte_article, texte_corps)
VALUES ('Texte de conclusion',1,'Musique de défonce man,
		 						 Pas de message normal,
		 						 Rien à dire.');
INSERT INTO Texte (texte_titre, texte_article, texte_corps)
VALUES ('Texte du debut',2,'Si la purée a cramé,
		 					Recouvre-la d''un chiffon mouillée,');
INSERT INTO Texte (texte_titre, texte_article, texte_corps)
VALUES ('Texte de fin',2,'Et fais couler du sel dessus,
		 				  Pour absorber les senteurs de brûlé');
INSERT INTO Texte (texte_titre, texte_article, texte_corps)
VALUES ('Texte de bizarre',3,'Les hommes se nourrissent d''animaux sauvages qu''ils chassent et de fruits qu''ils cueillent.
						  On les appelle les chasseurs-cueilleurs.');
INSERT INTO Texte (texte_titre, texte_article, texte_corps)
VALUES ('Texte de hilarant',4,'30 giga ça prend beaucoup de place
						  Mais ça veut pas dire que tu es grosse
						  C''est mon amour pour toi qui prend toute la place
						  Comme les disques durs qui saturent');


-- Il suffit d'aller à la ligne pour rentrer le retour chariot dans la BD

-- SELECT * FROM Texte;



INSERT INTO Statut (statut_type, statut_createur, statut_datecreation)
VALUES ('Valide',3,'2015-05-09 19:37:50');
INSERT INTO Statut (statut_type, statut_createur, statut_datecreation)
VALUES ('En_redaction',3,'2015-05-09 19:37:50');
INSERT INTO Statut (statut_type, statut_createur, statut_datecreation)
VALUES ('Soumis',3,'2015-05-09 19:37:50');
INSERT INTO Statut (statut_type, statut_createur, statut_datecreation)
VALUES ('En_relecture',3,'2015-05-09 19:37:50');
INSERT INTO Statut (statut_type, statut_createur, statut_datecreation)
VALUES ('A_reviser',3,'2015-05-09 19:37:50');
INSERT INTO Statut (statut_type, statut_createur, statut_datecreation)
VALUES ('Rejete',3,'2015-05-09 19:37:50');

-- SELECT * FROM Statut;



-- INSERT INTO Remarque (remarque_corps, remarque_statut)
-- VALUES ('Ceci est une remarque','Valide');

-- SELECT * FROM Remarque;



INSERT INTO Commentaire (commentaire_titre, commentaire_corps, commentaire_enExergue,
						commentaire_masque, commentaire_supprime, commentaire_createur,
						commentaire_article, commentaire_datecreation, commentaire_datesuppression)
VALUES ('Commentaire diffamatoire','Je trouve que cet article est vraiment inutile',FALSE,
	    FALSE,FALSE,4,1,'2015-05-20 19:37:50',NULL);

INSERT INTO Commentaire (commentaire_titre, commentaire_corps, commentaire_enExergue,
						commentaire_masque, commentaire_supprime, commentaire_createur,
						commentaire_article, commentaire_datecreation, commentaire_datesuppression)
VALUES ('Commentaire correct','Je trouve que cet article est vraiment trop bien !',FALSE,
	    FALSE,FALSE,4,1,'2015-05-21 19:37:50',NULL);


-- SELECT * FROM Commentaire;



INSERT INTO MotsClefs (motsclefs_corps, motsclefs_editeur, motsclefs_datecreation)
VALUES ('temps',3,'2015-06-20 19:37:50');

-- SELECT * FROM MotsClefs;



INSERT INTO Modifier_Statut_Auteur (modifstatut_datemodif, modifstatut_auteur,
									modifstatut_article, modifstatut_statut)
VALUES ('2015-05-28 19:37:55',2,1,'En_redaction');
INSERT INTO Modifier_Statut_Auteur (modifstatut_datemodif, modifstatut_auteur,
									modifstatut_article, modifstatut_statut)
VALUES ('2015-05-28 19:45:55',6,2,'En_redaction');
INSERT INTO Modifier_Statut_Auteur (modifstatut_datemodif, modifstatut_auteur,
									modifstatut_article, modifstatut_statut)
VALUES ('2015-05-28 19:40:55',2,1,'Soumis');
INSERT INTO Modifier_Statut_Auteur (modifstatut_datemodif, modifstatut_auteur,
									modifstatut_article, modifstatut_statut)
VALUES ('2015-05-28 19:42:55',2,1,'En_redaction');
INSERT INTO Modifier_Statut_Auteur (modifstatut_datemodif, modifstatut_auteur,
									modifstatut_article, modifstatut_statut)
VALUES ('2015-05-28 19:47:55',6,2,'Soumis');
INSERT INTO Modifier_Statut_Auteur (modifstatut_datemodif, modifstatut_auteur,
									modifstatut_article, modifstatut_statut)
VALUES ('2015-05-28 19:35:55',2,1,'Soumis');
INSERT INTO Modifier_Statut_Auteur (modifstatut_datemodif, modifstatut_auteur,
									modifstatut_article, modifstatut_statut)
VALUES ('2015-05-29 08:20:30',2,3,'En_redaction');
INSERT INTO Modifier_Statut_Auteur (modifstatut_datemodif, modifstatut_auteur,
									modifstatut_article, modifstatut_statut)
VALUES ('2015-05-28 18:45:55',6,4,'En_redaction');
INSERT INTO Modifier_Statut_Auteur (modifstatut_datemodif, modifstatut_auteur,
									modifstatut_article, modifstatut_statut)
VALUES ('2015-05-28 19:35:55',6,4,'Soumis');

-- + trigger

-- SELECT * FROM Modifier_Statut_Auteur;



INSERT INTO Supprimer_Commentaire (suppcomm_datesupp, suppcomm_commentaire, suppcomm_moderateur)
VALUES ('2015-05-21 20:37:50',2,5);

-- SELECT * FROM Supprimer_Commentaire;



INSERT INTO Mettre_Exergue_Commentaire (miseexcom_datemiseex, miseexcom_commentaire, miseexcom_moderateur)
VALUES ('2015-05-21 20:37:50',2,5);

-- SELECT * FROM Mettre_Exergue_Commentaire;



INSERT INTO Mettre_A_Honneur (misehonneur_datemisehonneur, misehonneur_editeur, misehonneur_article)
VALUES ('2015-05-22 20:37:50',3,2);

-- +trigger
-- SELECT * FROM Mettre_A_Honneur;



INSERT INTO Associer_Article_Rubrique (assocartrub_dateassoc, assocartrub_article,
									   assocartrub_rubrique, assocartrub_editeur)
VALUES ('2015-05-23 20:37:50',1,2,3);
INSERT INTO Associer_Article_Rubrique (assocartrub_dateassoc, assocartrub_article,
									   assocartrub_rubrique, assocartrub_editeur)
VALUES ('2015-05-23 20:37:50',2,1,3);
INSERT INTO Associer_Article_Rubrique (assocartrub_dateassoc, assocartrub_article,
									   assocartrub_rubrique, assocartrub_editeur)
VALUES ('2015-05-23 20:37:50',3,1,3);
INSERT INTO Associer_Article_Rubrique (assocartrub_dateassoc, assocartrub_article,
									   assocartrub_rubrique, assocartrub_editeur)
VALUES ('2015-05-23 20:37:50',4,2,3);

-- SELECT * FROM Associer_Article_Rubrique;



INSERT INTO Modifier_Statut_Editeur (modifstatedit_datemodif, modifstatedit_editeur,
									 modifstatedit_statut, modifstatedit_article)
VALUES ('2015-05-30 19:37:55',3,'Valide',1);
INSERT INTO Modifier_Statut_Editeur (modifstatedit_datemodif, modifstatedit_editeur,
									 modifstatedit_statut, modifstatedit_article)
VALUES ('2015-05-25 19:37:55',3,'Valide',2);
INSERT INTO Modifier_Statut_Editeur (modifstatedit_datemodif, modifstatedit_editeur,
									 modifstatedit_statut, modifstatedit_article)
VALUES ('2015-05-20 19:37:55',3,'Valide',3);

-- SELECT * FROM Modifier_Statut_Editeur;

INSERT INTO Associer_Article_Article (assocartart_dateassoc, assocartart_article1,
									  assocartart_article2, assocartart_editeur)
VALUES ('2015-05-19 21:37:55',1,2,3);
INSERT INTO Associer_Article_Article (assocartart_dateassoc, assocartart_article1,
									  assocartart_article2, assocartart_editeur)
VALUES ('2015-05-19 21:37:55',2,4,3);
INSERT INTO Associer_Article_Article (assocartart_dateassoc, assocartart_article1,
									  assocartart_article2, assocartart_editeur)
VALUES ('2015-05-19 21:37:55',3,1,3);
INSERT INTO Associer_Article_Article (assocartart_dateassoc, assocartart_article1,
									  assocartart_article2, assocartart_editeur)
VALUES ('2015-05-19 21:37:55',4,3,3);


/*
INSERT INTO Associer_Article_Article (assocartart_dateassoc, assocartart_article1,
									  assocartart_article2, assocartart_editeur)
VALUES ('2015-05-19 21:37:55',2,1,3);
INSERT INTO Associer_Article_Article (assocartart_dateassoc, assocartart_article1,
									  assocartart_article2, assocartart_editeur)
VALUES ('2015-05-19 21:37:55',4,1,3);
INSERT INTO Associer_Article_Article (assocartart_dateassoc, assocartart_article1,
									  assocartart_article2, assocartart_editeur)
VALUES ('2015-05-19 21:37:55',1,3,3);
*/
-- SELECT * FROM Associer_Article_Article;


INSERT INTO Indexer_Article (indexart_dateindex, indexart_motclef, indexart_editeur,
							 indexart_article)
VALUES ('2015-06-20 19:50:50',1,3,1);

-- SELECT * FROM Indexer_Article;



INSERT INTO Associer_SousRubrique_Rubrique (assocsrubrub_dateassoc, assocsrubrub_editeur, 
											assocsrubrub_rubrique, assocsrubrub_sousrubrique)
VALUES ('2015-06-20 20:50:50',3,1,2);

-- SELECT * FROM Associer_SousRubrique_Rubrique;