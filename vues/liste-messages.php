<h2>Messages</h2>

<?php foreach($discussions as $discussion): ?>
	<p class="diffusion">
		<span class="titreDiffusion">
		   <a href="discussion.php?id=<?= $discussion['id'] ?>">
				<img src="vues/img/user.png" alt="user" />

				<?php
				if($discussion['user2Id'])
					echo $discussion['user2Login'];
				else
					echo 'Compte supprimé';
				?>
			</a>

			&nbsp; &nbsp;
			<a href="liste-messages.php?supprId=<?= $discussion['id'] ?>" onclick="return confirm('Supprimer cette discussion ?')">
				<img src="vues/img/supprimer.png" alt="supprimer" />
			</a>
		</span>

		<span class="infoDiffusion">
			<img src="vues/img/horloge.png" alt="horloge" />
			<?= formaterDate($discussion['dateDernierMsg']) ?>

			<?= nbNouveauMsg($discussion['user1Id'], $discussion['id']) ?>
		</span>
	</p>
<?php endforeach; ?>

<h3>Nouveau message</h3>

<form method="post" action="">
	<p>
		<label>Destinataire</label>
		<select name="destinataire" class="destinataire">
			<?php
			foreach($users as $user)
				echo '<option value="' . $user['id'] . '">' . $user['login'] . '</option>';
			?>
		</select>
	</p>

	<p>
		<textarea rows="7" name="message"></textarea>
	</p>

	<p><input type="submit" value="Envoyer" /></p>
</form>
