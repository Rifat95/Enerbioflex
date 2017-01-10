<?php

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

function ajouterMessage($message, $diffusionId) {
	global $bdd;

	$req = $bdd->prepare("
		INSERT INTO Chat
		VALUES(NULL, :m, NOW(), :auteurId, :diffusionId)
	");

	$req->bindValue(':m', $message);
	$req->bindValue(':auteurId', $_SESSION['userId']);
	$req->bindValue(':diffusionId', $diffusionId);
	$req->execute();
}

function getMessage($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT *
		FROM Chat
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function supprimerMessage($id) {
	global $bdd;

	$req = $bdd->prepare("
		DELETE FROM Chat
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();
}
