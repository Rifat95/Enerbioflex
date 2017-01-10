<?php

function getUser($login, $mdp) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT *
		FROM Userr
		WHERE login = :l AND mdp = :m
	");

	$req->bindValue(':l', $login);
	$req->bindValue(':m', $mdp);
	$req->execute();

	return $req->fetch(PDO::FETCH_ASSOC);
}

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
