<?php

function getMessages($diffusionId) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT Chat.id, Chat.message, Chat.auteurId,
			DATE_FORMAT(Chat.dateMessage, '%d/%m/%y - %H:%i:%s') AS dateMessage,
			Userr.login AS loginAuteur
		FROM Chat
		LEFT JOIN Userr
			ON Chat.auteurId = Userr.id
		WHERE Chat.diffusionId = :id
		GROUP BY Chat.id
		ORDER BY Chat.id
	");

	$req->bindValue(':id', $diffusionId);
	$req->execute();

	return $req->fetchAll(PDO::FETCH_ASSOC);
}
