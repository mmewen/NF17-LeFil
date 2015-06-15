<div class="jumbotron">
	<h1>Edition de <a href="?module=edition&page=consulter_article&article=<?php echo $article['article_id']; ?>"><?php echo $article['article_titre']; ?></a></h1>
</div>

<p><a href="?module=edition&page=consulter_article&article=<?php echo $_GET['article']; ?>">Retourner à la lecture de l'article</a> (sans enregistrer)</p>

<div class="page-header">
	<h1>Edition d'article</h1>
</div>
<p>

<div style="width:25%;">
	<form action='?module=edition&page=modifier_article&article=<?php echo($_GET['article']); ?>' method='POST'>
		<div class="form-group">
			<label for="titre">Titre:</label>
			<?php
			echo("<input type='text' class='form-control' name='titre' id='titre' value='".$article["article_titre"]."'>");
			?>
		</div>
		<?php
		foreach($textes as $key => $texte){ ?>
			<div class='form-group'>
				<label for='titretexte'>Titre de votre texte:</label>
				<input type='text' class='form-control' name='titretexte<?php echo $key; ?>' id='titretexte' value='<?php echo $texte["texte_titre"]; ?>'>
				<input type='hidden' class='form-control' name='idtexte<?php echo $key; ?>' id='idtexte' value='<?php echo $texte["texte_id"]; ?>'>
			</div>
			<div class='form-group'>
				<label for='corps'>Texte:</label>
				<textarea class='form-control' rows='10' name='corps<?php echo $key; ?>' id='corps'><?php echo $texte["texte_corps"]; ?></textarea>
			</div> <?php
		}
		echo"<input type='hidden' name='nbarg' id='nbarg' value='".count($textes)."'/>";
		?>
		<br>
		<button type="submit" class="btn btn-default">Editer l'article</button>
	</form>
</div>

</p>