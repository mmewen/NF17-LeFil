/**************************************************************|
|	Ce script détruit toutes les tables de la base de donnée   |
|	en supprimant le schéma public en cascade (ce qui permet)  |
|	de détruire les tables même si elles dépendent les une     |
|	des autres. Il recréer ensuite le schéma public.		   |
|	Entre nous je sais pas à quoi servent les schémas mais 	   |
|	c'est pratique dans ce cas-ci ^^						   |
**************************************************************/

drop schema public cascade;
create schema public;