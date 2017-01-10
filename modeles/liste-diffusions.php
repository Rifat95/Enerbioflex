<?php

function getDiffusions() {
	global $bdd;

	$req = $bdd->query("
		SELECT Diffusion.id, Diffusion.titre, Diffusion.auteurId,
			DATE_FORMAT(Diffusion.debut, '%d/%m/%y - %H:%i') AS debut,
			Userr.login AS loginAuteur,
			COUNT(Chat.id) AS nbMessage
		FROM Diffusion
		LEFT JOIN Userr
			ON Diffusion.auteurId = Userr.id
		LEFT JOIN Chat
			ON Diffusion.id = Chat.DiffusionId
		GROUP BY Diffusion.id
		ORDER BY Diffusion.id DESC
	");

	return $req->fetchAll(PDO::FETCH_ASSOC);
}

function ajouterDiffusion($titre, $lien, $dateDebut) {
	global $bdd;

	$req = $bdd->prepare("
		INSERT INTO Diffusion
		VALUES(NULL, :t, :l, :d, :i)
	");

	$req->bindValue(':t', $titre);
	$req->bindValue(':l', $lien);
	$req->bindValue(':d', $dateDebut);
	$req->bindValue(':i', $_SESSION['userId']);
	$req->execute();
}

function getDiffusion($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT Diffusion.id, Diffusion.titre, Diffusion.lien, Diffusion.auteurId,
			DATE_FORMAT(Diffusion.debut, '%d/%m/%y - %H:%i') AS debut,
			Userr.login AS loginAuteur,
			COUNT(Chat.id) AS nbMessage
		FROM Diffusion
		LEFT JOIN Userr
			ON Diffusion.auteurId = Userr.id
		LEFT JOIN Chat
			ON Diffusion.id = Chat.diffusionId
		WHERE Diffusion.id = :id
		GROUP BY Diffusion.id
	");

	$req->bindValue(':id', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function supprimerDiffusion($id) {
	global $bdd;

	$req = $bdd->prepare("
		DELETE FROM Diffusion
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();
}
