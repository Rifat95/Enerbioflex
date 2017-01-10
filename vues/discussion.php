<h2><?= $discussion['user2Login'] ?></h2>

<?php foreach($messages as $message): ?>
	<p class="<?= $message['type'] ?>">
		<?= $message['contenu'] ?>
		<span class="msgInfo">
			<?= dateIntelligente($message['dateEnvoi']) ?>
			&nbsp; &nbsp;
			<a href="discussion.php?id=<?= $_GET['id'] ?>&supprId=<?= $message['id'] ?>&boite=<?= $message['type'] ?>" onclick="return confirm('Supprimer ce message ?')">
				<img src="vues/img/supprimer.png" alt="supprimer" />
			</a>
		</span>
	</p>
<?php endforeach; ?>

<?php if($discussion['user2Id']): ?>
	<form method="post" action="">
		<p>
			<textarea rows="7" name="message"></textarea>
		</p>

		<p><input type="submit" value="Envoyer" /></p>
	</form>
<?php endif; ?>
