<?php

define('DROIT_ACCES', 'membre');
require('./lib/top.php');
require('./modeles/chat-ajax.php');

if (!parametreValide('id'))
	erreur404();

$messages = getMessages($_GET['id']);
securiserTab($messages);
?>

<?php foreach($messages as $message): ?>
	<p class="message">
		<span class="infoMessage">
			<?php
			if($message['auteurId'])
				echo '<a href="#">' . $message['loginAuteur'] . '</a>';
			else
				echo 'Compte supprimé';
			?>

			<span class="dateMessage">
				<?= $message['dateMessage'] ?>
				<?php if ($message['auteurId'] == $_SESSION['userId'] || $MODO): ?>
					&nbsp; &nbsp;
					<a href="diffusion.php?id=<?= $_GET['id'] ?>&supprId=<?= $message['id'] ?>" onclick="return confirm('Supprimer ce message ?')">
						<img src="vues/img/supprimer.png" alt="supprimer" />
					</a>
				<?php endif; ?>
			</span>
		</span>

		<span class="contenuMessage">
			<?= $message['message'] ?>
		</span>
	</p>
<?php endforeach; ?>
