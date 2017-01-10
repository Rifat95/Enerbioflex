<?php

function getUserMail($mail) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT *
		FROM Userr
		WHERE mail = :m
	");

	$req->bindValue(':m', $mail);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

function changerMdp($userId, $mdp) {
	global $bdd;

	$req = $bdd->prepare("
		UPDATE Userr
		SET mdp = :m
		WHERE id = :i
	");

	$req->bindValue(':m', $mdp);
	$req->bindValue(':i', $userId);
	$req->execute();
}
