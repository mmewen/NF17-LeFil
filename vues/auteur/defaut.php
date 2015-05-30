<div class="jumbotron">
	<h1>Gestion de vos articles</h1>
</div>

<a href="?module=auteur&page=creer_article">Créer un Article</a>

<div class="page-header">
	<h1>Liste des articles</h1>
</div>
<p>
	<?php 
	if (is_bool($articles)){
		echo("Pas d'article valable à afficher");
	} else {
		//var_dump($articles);
		foreach ($articles as $art){

			$article_historique=get_historique_article_auteur($art["modifstatut_article"]);
			$nbligne=count($article_historique);
			$ligne=1;

			//var_dump($article_historique);

			foreach($article_historique as $hist){

				if($ligne==1){
					$statut=$hist["modifstatut_statut"];
					$titre=$hist["article_titre"];
					$comite=$hist['comedit_groupenom'];
					$supp=$hist["article_supprime"];
					$publie=$hist["article_publie"];
					$honneur=$hist["article_honneur"];
				}

				if($ligne==$nbligne){
					echo('<h4>'.$titre);
					$datemodif=$hist["modifstatut_datemodif"];
					echo(' - créé le '.$datemodif);
					echo(' - suivi par le comité éditorial "'.$comite.'"'.str_repeat('&nbsp;', 3).'');
					echo"<span class='label label-default'>".$statut."</span> ";
					
					if ($publie == 't'){
						echo "<span class='label label-primary'>Publié</span> ";
					} else {
						echo "<span class='label label-warning'>Pas publié</span> ";
					}

					if ($supp == 't'){
						echo "<span class='label label-danger'>Supprimé</span> ";
					} else {
						echo "<span class='label label-primary'>Pas supprimé</span> ";
					}
					
					if ($honneur == 't'){
						echo "<span class='label label-success'>A l'honneur</span> ";
					} else {
						echo "<span class='label label-default'>Pas à l'honneur</span> ";
					}

					$article_rubrique=get_rubrique_article($art["modifstatut_article"]);
					
					if($article_rubrique){
						echo('<br> Apparait dans la/les rubrique(s) : ');
							foreach($article_rubrique as $artrub){
								echo('<a href="?module=article&page=rubriques&rubrique='.
									  $artrub["assocartrub_rubrique"].'">'.$artrub["rubrique_nom"].'</a>');
							}
					}
					
					$article_liaison=get_article_article($art["modifstatut_article"],$titre);

					if($article_liaison){
						echo('<br> Est lié à/aux article(s) : ');
						foreach($article_liaison as $li){
							if($li["assocartart_article1"]==$art["modifstatut_article"]){
								echo('<a href="?module=article&page=afficher_article&article='.$li["assocartart_article2"].'"">'.$li["article_titre"].'</a> ');
							}
							if($li["assocartart_article2"]==$art["modifstatut_article"]){
								echo('<a href="?module=article&page=afficher_article&article='.$li["assocartart_article1"].'"">'.$li["article_titre"].'</a> ');
							}
						}
					}
					
					echo('<br> <a href="?module=auteur&page=editer_article&article='.$hist["article_id"].'">Éditer</a></h4>');
					?>

					<div class="well">
			        	<p>
			        		<?php
			        		$textefinal=' ';
			        		$textes=get_texte_article($hist["article_id"]);
			        		foreach($textes as $txt){
			        			$textefinal.=$txt["texte_corps"];
			        			$textefinal.="\n";	
			        		}
			        		echo(nl2br($textefinal));
			        		?>
			        	</p>
			      	</div><br>
				<?php
				}
				$ligne=$ligne+1;
			}
		}
	}
?> 
</p>