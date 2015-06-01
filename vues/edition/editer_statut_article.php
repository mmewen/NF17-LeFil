<div class="jumbotron">
	<h1>Gestion du statut de l'article <?php echo($article['article_titre']); ?></h1>
</div>

<p><a href="?module=edition&page=gerer_articles">Retourner à la liste des articles</a> (sans enregistrer)</p>

<div class="page-header">
	<h3>Statut actuel :</h3>
</div>
<p>
	Article 
	<?php
	switch ($statut["statut"]) {
		case 'En_redaction':
			echo "en cours de redaction";
			break;
		case 'Soumis':
			echo "soumis";
			break;
		case 'En_relecture':
			echo "en relecture";
			break;
		case 'A_reviser':
			echo "à réviser";
			break;
		case 'Rejete':
			echo "rejeté";
			break;
		case 'Valide':
			echo "validé";
			break;
	}
	?>
</p>
<div class="page-header">
	<h3>Modifier le statut :</h3>
</div>
<p>
<div style="width:25%;">
	<form action='?module=edition&page=modifier_statut_article&article=<?php echo $_GET['article']; ?>' method='POST'>
		<div class="form-group">
			<label for="statut">Nouveau statut :</label>
			<select class='form-control' name='statut' id='statut' onChange="if(this.value == 'Rejete' || this.value == 'A_reviser') { $('#divjustification').show();} else { $('#divjustification').hide();}; ">
				<?php
				if ($statut['statut'] =='En_relecture') {
					echo("<option value='A_reviser'>à réviser</option>");
					echo("<option value='Rejete'>rejeter</option>");
					echo("<option value='Valide'>valider</option>");
				}

				if ($statut['statut']=='Valide') {
					echo("<option value='Publier'>publier l'article</option>");
				}
				?>
			</select>
		</div>
		<div class="form-group" id="divjustification" style="display:none;">
			<label for="justification">Merci de motiver cette décision :</label>
			<input type="text" id="justification" name="justification">
		</div>
		<button type="submit" class="btn btn-default">Changer de statut</button>
	</form>
</div>

</p>