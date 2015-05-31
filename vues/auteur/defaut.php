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

			$statut=$article_historique['statut'];
			$titre=$article_historique["titre"];
			$comite=$article_historique['comite'];
			$supp=$article_historique["supp"];
			$publie=$article_historique["publie"];
			$honneur=$article_historique["honneur"];
			
			echo('<h4>'.$titre);
			$datecreation=$article_historique["datecreation"];
			echo(' - créé le '.$datecreation);
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
					
			echo('<br> <a href="?module=auteur&page=editer_article&article='.$article_historique["article_id"].'">Éditer</a></h4>');
			?>

			<div class="well">
			    <p>
			        <?php
			        $textefinal=' ';
			        $textes=get_texte_article($article_historique["article_id"]);
			        foreach($textes as $txt){
			        	$textefinal.=$txt["texte_corps"];
			        	$textefinal.="\n";	
			        }
			        echo(nl2br($textefinal));
			        ?>
			    </p>
			</div><br>
			<?php
			if($statut=='En_redaction'||$statut=='A_reviser'){
				echo "<a href='?module=auteur&page=soumettre_article&article=".$article_historique["article_id"]."'><span class='btn btn-lg btn-default'>Soumettre</span></a> ";
			}

			echo "<hr>";
		}
	}
?> 
</p>