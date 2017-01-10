<?php

function getDiscussion($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT Discussion.*,
			Userr.login as user2Login
		FROM Discussion
		LEFT JOIN Userr
			ON Discussion.user2Id = Userr.id
		WHERE Discussion.id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function getMessages($discussionId) {
	global $bdd;

	$req = $bdd->prepare("
		UPDATE Reception
		SET lu = true
		WHERE destinataireId = :destid
		AND discussionId = :di
	");

	$req->bindValue(':destid', $_SESSION['userId']);
	$req->bindValue(':di', $discussionId);
	$req->execute();

	$req = $bdd->prepare("
		SELECT id,
			'recu' AS type,
			contenu,
			dateEnvoi
		FROM Reception
		WHERE discussionId = :i

		UNION ALL

		SELECT id,
			'envoye' AS type,
			contenu,
			dateEnvoi
		FROM Envoi
		WHERE discussionId = :i

		ORDER BY dateEnvoi
	");

	$req->bindValue(':i', $discussionId);
	$req->execute();

	return $req->fetchAll(PDO::FETCH_ASSOC);
}

function envoyerMessage($destinataireId, $message) {
	global $bdd;

	$req = $bdd->prepare("
		INSERT INTO Envoi
		VALUES(NULL, :m, NOW(), :expid, :destid, NULL)
	");

	$req->bindValue(':m', $message);
	$req->bindValue(':expid', $_SESSION['userId']);
	$req->bindValue(':destid', $destinataireId);

	$req->execute();
}

function getMessage($id, $boite) {
	global $bdd;

	$sql = 'SELECT * FROM ' . $boite . ' WHERE id = :i';
	$req = $bdd->prepare($sql);

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function supprimerMessage($id, $boite) {
	global $bdd;

	$sql = 'DELETE FROM ' . $boite . ' WHERE id = :i';
	$req = $bdd->prepare($sql);

	$req->bindValue(':i', $id);
	$req->execute();
}
