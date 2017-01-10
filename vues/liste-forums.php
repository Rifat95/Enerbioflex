<h2>Liste des forums</h2>

<?php foreach($forums as $forum): ?>
	<p class="diffusion">
		<span class="titreDiffusion">
		   <a href="forum.php?id=<?= $forum['id'] ?>"><?= $forum['nom'] ?></a>

		   <?php if ($MODO): ?>
				&nbsp; &nbsp;
				<a href="liste-forums.php?supprId=<?= $forum['id'] ?>" onclick="return confirm('Supprimer ce forum ?')">
					<img src="vues/img/supprimer.png" alt="supprimer" />
				</a>
			<?php endif; ?>
		</span>

		<span class="infoDiffusion">
			<?= $forum['description'] ?>
		</span>
	</p>
<?php endforeach; ?>

<?php if ($MODO): ?>
	<h2>Créer un forum</h2>

	<form method="post" action="liste-forums.php">
		<p>
			<label for="nom">Nom</label>
			<input type="text" name="nom" id="nom" required />
		</p>

		<p>
			<label for="description">Description</label>
			<input type="text" name="description" id="description" required />
		</p>

		<p><input type="submit" value="Valider" /></p>
	</form>
<?php endif; ?>
