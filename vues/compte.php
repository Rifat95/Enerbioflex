<h2>Modifer l'adresse e-mail</h2>

<form method="post" action="">
	<p>
		<label for="mail">Mail</label>
		<input type="text" name="mail" id="mail" required />
	</p>

	<p><input type="submit" value="Valider" /></p>
</form>

<h2>Modifer le mot de passe</h2>

<form method="post" action="">
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

<h2>Supprimer le compte</h2>

<form method="post" action="">
	<p class="erreur">Attention cette action est irréversible</p>

	<p>
		<label for="mdp">Mot de passe</label>
		<input type="password" name="mdpSupprimer" id="mdpSupprimer" required />
	</p>

	<p><input type="submit" value="Supprimer !" /></p>
</form>
