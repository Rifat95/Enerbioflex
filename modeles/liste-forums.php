<?php

function getForums() {
	global $bdd;

	$req = $bdd->query("
		SELECT *
		FROM Forum
		ORDER BY nom
	");

	return $req->fetchAll(PDO::FETCH_ASSOC);;
}

function ajouterForum($nom, $description) {
	global $bdd;

	$req = $bdd->prepare("
		INSERT INTO Forum
		VALUES(NULL, :n, :d)
	");

	$req->bindValue(':n', $nom);
	$req->bindValue(':d', $description);
	$req->execute();
}

function getForum($id) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT *
		FROM Forum
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function supprimerForum($id) {
	global $bdd;

	$req = $bdd->prepare("
		DELETE FROM Forum
		WHERE id = :i
	");

	$req->bindValue(':i', $id);
	$req->execute();
}
