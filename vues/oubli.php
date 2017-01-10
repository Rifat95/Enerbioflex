<h2>Changer le mot de passe</h2>

<form method="post" action="<?= $lien ?>">
	<p>
		<label for="mdp">Nouveau mot de passe</label>
		<input type="password" name="mdp" id="mdp" required />
	</p>

	<p>
		<label for="mdp2">Confirmer le mot de passe</label>
		<input type="password" name="mdp2" id="mdp2" required />
	</p>

	<p><input type="submit" value="Valider" /></p>
</form>
