<?php

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
