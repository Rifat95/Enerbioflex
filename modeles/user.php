<?php

function getUser($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT Userr.id, Userr.login, Userr.mail, Userr.type, Userr.adresseIp,
			DATE_FORMAT(Userr.dateInscription, '%d/%m/%Y') AS dateInscription,
			COUNT(Diffusion.id) as nbDiffusion,
			COUNT(Topic.id) as nbTopic,
			COUNT(Post.id) as nbPost
		FROM Userr
		LEFT JOIN Diffusion
			ON Userr.id = Diffusion.auteurId
		LEFT JOIN Topic
			ON Userr.id = Topic.auteurId
		LEFT JOIN Post
			ON Userr.id = Post.auteurId
		WHERE Userr.id = :i
		GROUP BY Userr.id
	");

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function modifierUser($type, $id)
{
	global $bdd;

	$req = $bdd->prepare("
		UPDATE Userr
		SET type = :t
		WHERE id = :i
	");

	$req->bindValue(':t', $type);
	$req->bindValue(':i', $id);
	$req->execute();
}

function supprimerUser($id) {
	global $bdd;

	$req = $bdd->prepare("
		DELETE FROM Userr
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();
}
