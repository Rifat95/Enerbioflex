<h2><?= $user['login'] ?></h2>

<form method="post" action="">
	<table>
		<tr>
			<td>Pseudo</td><td><?= $user['login'] ?></td>
		</tr>
		<tr>
			<td>Date d'inscription</td><td><?= $user['dateInscription'] ?></td>
		</tr>
		<tr>
			<td>Diffusions en cours</td><td><?= $user['nbDiffusion'] ?></td>
		</tr>
		<tr>
			<td>Sujets créé</td><td><?= $user['nbTopic'] ?></td>
		</tr>
		<tr>
			<td>Messages postés</td><td><?= $user['nbPost'] ?></td>
		</tr>

		<?php if ($MODO): ?>
			<tr>
				<td>Adresse e-mail</td><td><?= $user['mail'] ?></td>
			</tr>
			<tr>
				<td>Adresse IP</td><td><?= $user['adresseIp'] ?></td>
			</tr>

			<?php if ($ADMIN): ?>
				<tr>
					<td>Type</td>
					<td>
						<select name="type">
							<?php afficherTypes() ?>
							<input type="submit" value="OK" style="width:auto; border:0; padding:0; color:#4169E1; background:white;" />
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;">
						<a href="user.php?id=<?= $_GET['id'] ?>&action=supprimer" style="color:red;" onclick="return confirm('Supprimer cet utilisateur ?')">
							SUPPRIMER
						</a>
					</td>
				</tr>
			<?php else: ?>
				<tr>
					<td>Type</td><td><?= $user['type'] ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>
	</table>
</form>
