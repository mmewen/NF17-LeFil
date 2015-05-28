<div class="jumbotron">
	<h1>Gestion de vos articles</h1>
</div>

<div class="page-header">
	<h1>Liste des articles</h1>
</div>
<p>
	<?php 
	if (is_bool($articles)){
		echo("Pas d'article valable à afficher");
	} else {
		foreach ($articles as $art){
			echo('<h4>'.$art["article_titre"].' - créé le '.$art["modifstatut_datemodif"].
				' - suivi par le comité éditorial "'.$art['comedit_groupenom'].'"'.str_repeat('&nbsp;', 3).'');

			echo"<span class='label label-default'>".$art["modifstatut_statut"]."</span> ";

			if ($art["article_supprime"] == 't'){
				echo "<span class='label label-danger'>Supprimé</span> ";
			} else {
				echo "<span class='label label-primary'>Disponible</span> ";
			}

			if ($art["article_publie"] == 't'){
				echo "<span class='label label-primary'>Publié</span> ";
			} else {
				echo "<span class='label label-warning'>Pas publié</span> ";
			}

			if ($art["article_honneur"] == 't'){
				echo "<span class='label label-success'>A l'honneur</span> ";
			} else {
				echo "<span class='label label-default'>Pas à l'honneur</span> ";
			}

			echo(' - <a href="?module=auteur&page=editer_article&article='.$art["article_id"].'">Éditer</a></h4>');
			?>

			<div class="well">
	        	<p>
	        		<?php
	        		$textefinal=' ';
	        		$textes=get_texte_article($art["article_id"]);
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
	}?> 
</p>