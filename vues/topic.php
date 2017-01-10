<h2><?= $topic['nom'] ?></h2>

<p class="message">
	<span class="infoMessage">
		<?php
		if($topic['auteurId'])
			echo '<a href="user.php?id=' . $topic['auteurId'] . '">' . $topic['loginAuteur'] . '</a>';
		else
			echo 'Compte supprimé';
		?>

		<span class="dateMessage">
			<?= $topic['dateCreation'] ?>
		</span>
	</span>

	<span class="contenuMessage">
		<?= $topic['message'] ?>
	</span>
</p>

<?php foreach($posts as $post): ?>
	<p class="message">
		<span class="infoMessage">
			<?php
			if($post['auteurId'])
				echo '<a href="user.php?id=' . $post['auteurId'] . '">' . $post['loginAuteur'] . '</a>';
			else
				echo 'Compte supprimé';
			?>

			<span class="dateMessage">
				<?= $post['dateCreation'] ?>

				<?php if ($post['auteurId'] == $_SESSION['userId'] || $MODO): ?>
					&nbsp; &nbsp;
					<a href="topic.php?id=<?= $_GET['id'] ?>&supprId=<?= $post['id'] ?>" onclick="return confirm('Supprimer ce post ?')">
						<img src="vues/img/supprimer.png" alt="supprimer" />
					</a>
				<?php endif; ?>
			</span>
		</span>

		<span class="contenuMessage">
			<?= $post['contenu'] ?>
		</span>
	</p>
<?php endforeach; ?>

<h3>Ajouter un post<h3>

<form method="post" action="">
	<p>
		<textarea rows="7" name="message"></textarea>
	</p>

	<p><input type="submit" value="Valider" /></p>
</form>
