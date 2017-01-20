<h2>Diffusions</h2>

<?php foreach($diffusions as $diffusion): ?>
	<p class="diffusion">
		<span class="titreDiffusion">
		   <a href="diffusion.php?id=<?= $diffusion['id'] ?>"><?= $diffusion['titre'] ?></a>
		</span>

		<span class="infoDiffusion">
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

			<?php if ($diffusion['auteurId'] == $_SESSION['userId'] || $MODO): ?>
				&nbsp; &nbsp;
				<a href="liste-diffusions.php?supprId=<?= $diffusion['id'] ?>" onclick="return confirm('Supprimer cette diffusion ?')">
					<img src="vues/img/supprimer.png" alt="supprimer" />
				</a>
			<?php endif; ?>
		</span>
	</p>
<?php endforeach; ?>

<h3>Programmer une diffusion</h3>

<form method="post" action="liste-diffusions.php">
	<p><a href="tuto.pdf">Comment diffuser via Dailymotion ?</a></p>
	<p>
		<label for="titre">Titre</label>
		<input type="text" name="titre" id="titre" required />
	</p>

	<p>
		<label>Date</label>

		<select name="jour">
			<?php
			for ($i = 1; $i <= 31; $i++) {
				if (strlen($i) == 1)
					$jour = '0' . $i;
				else
					$jour = $i;

				echo '<option value="' . $jour . '">' . $jour . '</option>';
			}
			?>
		</select>

		<select name="mois">
			<?php
			for ($i = 1; $i <= 12; $i++) {
				if (strlen($i) == 1)
					$mois = '0' . $i;
				else
					$mois = $i;

				echo '<option value="' . $mois . '">' . $mois . '</option>';
			}
			?>
		</select>

		<select name="an">
			<?php
			$an = date('Y');
			$max = $an + 80;
			for ($i = $an; $i <= $max; $i++) {
				echo '<option value="' . $i . '">' . $i . '</option>';
			}
			?>
		</select>
	</p>

	<p>
		<label>Heure</label>
		<select name="heure">
			<?php
			for ($i = 0; $i <= 23; $i++) {
				if (strlen($i) == 1)
					$heure = '0' . $i;
				else
					$heure = $i;

				echo '<option value="' . $heure . '">' . $heure . '</option>';
			}
			?>
		</select>h

		<select name="min">
			<?php
			for ($i = 0; $i <= 59; $i += 5) {
				if (strlen($i) == 1)
					$min = '0' . $i;
				else
					$min = $i;

				echo '<option value="' . $min . '">' . $min . '</option>';
			}
			?>
		</select>min
	</p>

	<p>
		<label for="lien">URL de la vidéo</label>
		<input type="text" name="lien" id="lien" required />
	</p>

	<p><input type="submit" value="Valider" /></p>
</form>
