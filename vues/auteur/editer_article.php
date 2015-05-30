<div class="jumbotron">
	<h1>Gestion de vos articles</h1>
</div>

<p><a href="?module=auteur">Retourner à la gestion des articles</a></p>

<div class="page-header">
	<h1>Edition d'article</h1>
</div>
<p>

<div style="width:25%;">
	<?php
	echo "<form action='?module=auteur&page=modifier_article&article=".$_GET['article']."' method='POST'>"
	?>
		<div class="form-group">
			<label for="titre">Titre:</label>
			<?php
			echo("<input type='text' class='form-control' name='titre' id='titre' value='".$article["titre"]."'>");
			?>
		</div>
		<?php
		$ligne=1;
		$nbligne=(count($article)-2)/2;
		foreach($article as $art){
			echo"<div class='form-group'>";
				echo"<label for='titretexte'>Titre de votre texte:</label>";
				echo("<input type='text' class='form-control' name='titretexte".$ligne."' id='titretexte' value='".$article["titretexte".$ligne.""]."'>");
			echo"</div>";
			echo"<div class='form-group'>";
				echo"<label for='corps'>Texte:</label>";
				echo("<textarea class='form-control' rows='10' name='corps".$ligne."' id='corps'>".$article["corps".$ligne.""]."</textarea>");
			echo"</div>";
			if($ligne==$nbligne){
				break;
			}
			$ligne+=1;
		}
		echo"<input type='hidden' name='nbarg' id='nbarg' value='".$ligne."'/>";
		?>
		<button type="submit" class="btn btn-default">Editer l'article</button>
	</form>
</div>

</p>