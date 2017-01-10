<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title><?= TITRE ?> - Webinar - Enerbioflex</title>
		<link rel="stylesheet" href="vues/style.css" />
		<meta name="viewport" content="width=device-width, user-scalable=no" />
	</head>

	<body>
		<div id="menu">
			<ul>
				<li><a href="index.php">Accueil</a></li>
				<?php if ($MODO): ?>
					<li><a href="liste-membres.php">Membres</a></li>
				<?php endif; ?>
				<?php if ($MEMBRE): ?>
					<li><a href="liste-diffusions.php">Diffusions</a></li>
					<li><a href="liste-forums.php">Forum</a></li>
					<li><a href="liste-messages.php">Messages <?= nbMessage() ?></a></li>
					<li><a href="compte.php">Compte</a></li>
					<li><a href="deconnexion.php">Deconnexion</a></li>
				<?php else: ?>
					<li><a href="connexion.php">Connexion</a></li>
					<li><a href="inscription.php">Inscription</a></li>
				<?php endif; ?>
			</ul>
		</div>

		<div id="corps">
			<?php
			if (isset($_SESSION['msgErreur'])) {
				echo '<p class="erreur">' . $_SESSION['msgErreur'] . '</p>';
				unset($_SESSION['msgErreur']);
			} if (isset($_SESSION['msgSucces'])) {
				echo '<p class="succes">' . $_SESSION['msgSucces'] . '</p>';
				unset($_SESSION['msgSucces']);
			}

			include('./vues/' . PAGE . '.php');
			?>
		</div>
	</body>
</html>
