<?php

function getForum($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT *
		FROM Forum
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);;
}

function getTopics($forumId) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT Topic.id, Topic.nom, Topic.auteurId,
			DATE_FORMAT(Topic.dateCreation, '%d/%m/%y - %H:%i') AS dateCreation,
			IFNULL(MAX(Post.dateCreation), Topic.dateCreation) AS dernierPost,
			Userr.login AS loginAuteur,
			COUNT(Post.id) AS nbPost
		FROM Topic
		LEFT JOIN Userr
			ON Topic.auteurId = Userr.id
		LEFT JOIN Post
			ON Topic.id = Post.topicId
		WHERE Topic.forumId = :i
		GROUP BY Topic.id
		ORDER BY dernierPost DESC
	");

	$req->bindValue(':i', $forumId);
	$req->execute();

	return $req->fetchAll(PDO::FETCH_ASSOC);
}

function ajouterTopic($nom, $message, $forumId) {
	global $bdd;

	$req = $bdd->prepare("
		INSERT INTO Topic
		VALUES(NULL, :n, :m, NOW(), :auteurId, :forumId)
	");

	$req->bindValue(':n', $nom);
	$req->bindValue(':m', $message);
	$req->bindValue(':auteurId', $_SESSION['userId']);
	$req->bindValue(':forumId', $forumId);
	$req->execute();
}

function getTopic($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT *
		FROM Topic
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function supprimerTopic($id) {
	global $bdd;

	$req = $bdd->prepare("
		DELETE FROM Topic
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();
}
