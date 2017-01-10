<h2>Connexion</h2>

<form method="post" action="">
	<p>
		<label for="login">Login</label>
		<input type="text" name="login" id="login" required />
	</p>

	<p>
		<label for="mdp">Mot de passe</label>
		<input type="password" name="mdp" id="mdp" required />
	</p>

	<p><a href="connexion.php?oubli">Mot de passe oublié ?</a></p>

	<p><input type="submit" value="Valider" /></p>
</form>

<?php if (isset($_GET['oubli'])): ?>
	<h2>Récupérer mot de passe</h2>

	<form method="post" action="">
		<p>
			<label for="mail">Mail</label>
			<input type="text" name="mail" id="mail" required />
		</p>

		<p><input type="submit" value="Valider" /></p>
	</form>
<?php endif; ?>
