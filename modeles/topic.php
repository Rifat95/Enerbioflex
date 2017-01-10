<?php

function getTopic($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT Topic.id, Topic.nom, Topic.message, Topic.auteurId,
			DATE_FORMAT(Topic.dateCreation, '%d/%m/%y - %H:%i') AS dateCreation,
			Userr.login AS loginAuteur
		FROM Topic
		LEFT JOIN Userr
			ON Topic.auteurId = Userr.id
		WHERE Topic.id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function getPosts($topicId) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT Post.id, Post.contenu, Post.auteurId,
			DATE_FORMAT(Post.dateCreation, '%d/%m/%y - %H:%i') AS dateCreation,
			Userr.login AS loginAuteur
		FROM Post
		LEFT JOIN Userr
			ON Post.auteurId = Userr.id
		WHERE Post.topicId = :i
		GROUP BY Post.id
		ORDER BY Post.id
	");

	$req->bindValue(':i', $topicId);
	$req->execute();

	return $req->fetchAll(PDO::FETCH_ASSOC);
}

function ajouterPost($message, $topicId) {
	global $bdd;

	$req = $bdd->prepare("
		INSERT INTO Post
		VALUES(NULL, :m, NOW(), :auteurId, :topicId)
	");

	$req->bindValue(':m', $message);
	$req->bindValue(':auteurId', $_SESSION['userId']);
	$req->bindValue(':topicId', $topicId);

	$req->execute();
}

function getPost($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT *
		FROM Post
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function supprimerPost($id) {
	global $bdd;

	$req = $bdd->prepare("
		DELETE FROM Post
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();
}
