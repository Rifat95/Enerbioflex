<h2><?= $diffusion['titre'] ?></h2>

<iframe frameborder="0" width="100%" height="350px" src="//www.dailymotion.com/embed/video/<?= $diffusion['lien'] ?>" allowfullscreen></iframe>

<p>
	<img src="vues/img/user.png" alt="user" />

	<?php
	if($diffusion['auteurId'])
		echo '<a href="user.php?id=' . $diffusion['auteurId'] . '">' . $diffusion['loginAuteur'] . '</a>';
	else
		echo 'Compte supprimé';
	?>
	&nbsp; &nbsp;

	<img src="vues/img/horloge.png" alt="horloge" />
	<?= $diffusion['debut'] ?>
	&nbsp; &nbsp;

	<img src="vues/img/chat.png" alt="chat" />
	<?= $diffusion['nbMessage'] ?>
</p>

<h3>Chat</h3>

<div id="chat">
</div>

<h3>Envoyer un message</h3>

<form method="post" action="diffusion.php?id=<?= $_GET['id'] ?>">
	<p>
		<textarea rows="7" name="message" id="message"></textarea>
	</p>

	<p><input type="submit" id="submit" value="Envoyer" /></p>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	function charger() {
		$('#chat').load("chat-ajax.php?id=<?= $_GET['id'] ?>").fadeIn("slow");
	}

	charger();

	$('#submit').click(
		function(e) {
			e.preventDefault();
			var message = encodeURIComponent($('#message').val());

			if(message != "") {
				$.ajax({
					url : "diffusion.php?id=<?= $_GET['id'] ?>",
					type : "POST",
					data : "message=" + message
				});
			}

			charger();
			$('#message').val('');
		}
	);

	var refresh = setInterval(
		function() {
			$('#chat').load("chat-ajax.php?id=<?= $_GET['id'] ?>").fadeIn("slow");
		}, 2000
	);
</script>
