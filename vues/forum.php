<h2>Forum <?= $forum['nom'] ?> - Liste des sujets</h2>

<?php foreach($topics as $topic): ?>
	<p class="diffusion">
		<span class="titreDiffusion">
		   <a href="topic.php?id=<?= $topic['id'] ?>"><?= $topic['nom'] ?></a>
		</span>

		<span class="infoDiffusion">
			<img src="vues/img/user.png" alt="user" />
			<?php
			if($topic['auteurId'])
				echo '<a href="user.php?id=' . $topic['auteurId'] . '">' . $topic['loginAuteur'] . '</a>';
			else
				echo 'Compte supprimé';
			?>

			&nbsp; &nbsp;
			<img src="vues/img/chat.png" alt="chat" />
			<?= $topic['nbPost'] ?> - <?= formaterDate($topic['dernierPost']) ?>

			<?php if ($topic['auteurId'] == $_SESSION['userId'] || $MODO): ?>
				&nbsp; &nbsp;
				<a href="forum.php?id=<?= $_GET['id'] ?>&supprId=<?= $topic['id'] ?>" onclick="return confirm('Supprimer ce sujet ?')">
					<img src="vues/img/supprimer.png" alt="supprimer" />
				</a>
			<?php endif; ?>
		</span>
	</p>
<?php endforeach; ?>

<h3>Créer un sujet</h3>

<form method="post" action="">
	<p>
		<label for="nom">Nom</label>
		<input type="text" name="nom" id="nom" required />
	</p>

	<p>
		<label for="message">Message</label>
		<textarea rows="7" name="message"></textarea>
	</p>

	<p><input type="submit" value="Valider" /></p>
</form>
