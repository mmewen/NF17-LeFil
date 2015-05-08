/* INSERTION DES DONNEES TEST */

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


SELECT * FROM Personne;

INSERT INTO Administrateur (admin_id, admin_login)
VALUES (1,'login1');

SELECT * FROM Administrateur;

INSERT INTO Auteur (auteur_id, auteur_login)
VALUES (2,'login2');

SELECT * FROM Auteur;

INSERT INTO Editeur (editeur_id, editeur_login)
VALUES (3,'login3');

SELECT * FROM Editeur;

INSERT INTO Lecteur (lecteur_id, lecteur_login)
VALUES (4,'login4');

SELECT * FROM Lecteur;

INSERT INTO Moderateur (moderateur_id, moderateur_login)
VALUES (5,'login5');

SELECT * FROM Moderateur;

INSERT INTO ComiteEditorial (groupenom)
VALUES ('Groupe Cool');

SELECT * FROM ComiteEditorial;

INSERT INTO Compose (compose_editeur, compose_comite)
VALUES (3,1);

SELECT * FROM Compose;

INSERT INTO Rubrique (rubrique_nom, rubrique_createur, rubrique_datecreation)
VALUES ('Rubrique Marrante',3,'2015-05-08 21:37:50');

SELECT * FROM Rubrique;

INSERT INTO Article (article_titre, article_supprime, article_publie, article_honneur, article_comite)
VALUES ('Article nul',FALSE,TRUE,TRUE,1);

SELECT * FROM Article;

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
  select lo_import('C:\wamp\www\nf17\images\pgsql-logo.png') into l_oid;
  for r in ( select data 
             from pg_largeobject 
             where loid = l_oid 
             order by pageno ) loop
    p_result = p_result || r.data;
  end loop;
  perform lo_unlink(l_oid);
end;$$;

INSERT INTO Image (image_titre, image_article, image_bitmap)
VALUES ('Image belle',1,bytea_import('C:\wamp\www\nf17\images\pgsql-logo.png'));

SELECT * FROM Image;