<div class="jumbotron">
	<h1><?php echo $article['article_titre']; ?></h1>
</div>

<p>
	<?php 
	foreach ($textes as $t) {
		echo('<h2>'.$t["texte_titre"].'</h2>');
		echo nl2br($t["texte_corps"]);
	}
	?>
</p>

<stong>
<p>
	À FAIRE !<br>
	Auteur<br>
	Commité éditorial ?<br>
	Articles associés<br>
</p>
</stong>

<p>
	<br>
	<?php
		if ($tags){
			echo ('<h3>Tags</h3>');

			foreach ($tags as $tag) {
				echo '<h4><span class="label label-default">'.nl2br($tag["motsclefs_corps"].'</span></h4>');
			}
		} else {
			echo ('Cet article ne possède pas encore de tag.');
		}
	?>
</p>


<div class="page-header">
	<h1>Commentaires</h1>
</div>
<p>
	<?php
	if ($commsEnExergue){
		echo ('<h3>Commentaires mis en avant</h3>');

		foreach ($commsEnExergue as $com) {
			echo('<h4>'.$com["commentaire_titre"].' - écrit par '.$com["commentaire_createur"].' le '.$com["commentaire_datecreation"].'</h4>');
			echo '<p>'.nl2br($com["commentaire_corps"].'</p>');
		}
		echo '<hr>';
	}
	if ($commsAutres){
		foreach ($commsAutres as $com) {
			echo('<h4>'.$com["commentaire_titre"].' - écrit par '.$com["commentaire_createur"].' le '.$com["commentaire_datecreation"].'</h4>');
			echo '<p>'.nl2br($com["commentaire_corps"].'</p>');
		}
	}?>
</p>