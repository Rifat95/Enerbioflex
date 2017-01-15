<?php

function getDiscussions($user1Id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT Discussion.*,
			Userr.login as user2Login,
			GREATEST(
				(SELECT IFNULL(MAX(Reception.dateEnvoi), '2000-01-01 00:00:00')
				FROM Reception
				WHERE Reception.destinataireId = :i
				AND Reception.discussionId = Discussion.id),

				(SELECT IFNULL(MAX(Envoi.dateEnvoi), '2000-01-01 00:00:00')
				FROM Envoi
				WHERE Envoi.expediteurId = :i
				AND Envoi.discussionId = Discussion.id)
			) as dateDernierMsg

		FROM Discussion
		LEFT JOIN Userr
			ON Discussion.user2Id = Userr.id
		WHERE Discussion.user1Id = :i
		GROUP BY Discussion.id
		ORDER BY dateDernierMsg DESC
	");

	$req->bindValue(':i', $user1Id);
	$req->execute();

	return $req->fetchAll(PDO::FETCH_ASSOC);
}

function nbNouveauMsg($user1Id, $discussionId) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT COUNT(*) AS nbNouveauMsg
		FROM Reception
		WHERE destinataireId = :ui
		AND discussionId = :di
		AND lu = 'false'
	");

	$req->bindValue(':ui', $user1Id);
	$req->bindValue(':di', $discussionId);
	$req->execute();

	$messages = $req->fetch();

	if ($messages['nbNouveauMsg'] > 0)
		return '&nbsp; &nbsp; <img src="vues/img/chat.png" alt="chat" />' . $messages['nbNouveauMsg'];
	else
		return '';
}

function getUsers() {
	global $bdd;

	$req = $bdd->prepare("
		SELECT *
		FROM Userr
		WHERE id <> :i
	");

	$req->bindValue(':i', $_SESSION['userId']);
	$req->execute();

	return $req->fetchAll(PDO::FETCH_ASSOC);
}

function getUser($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT *
		FROM Userr
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
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

function getDiscussion($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT *
		FROM Discussion
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function supprimerDiscussion($id) {
	global $bdd;

	$req = $bdd->prepare("
		DELETE FROM Discussion
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();
}
