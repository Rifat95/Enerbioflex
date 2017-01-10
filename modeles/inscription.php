<?php

function membreExiste($login) {
	global $bdd;

	$req = $bdd->prepare("
		SELECT COUNT(*) as nbLogin
		FROM Userr
		WHERE login = :l
	");

	$req->bindValue(':l', $login);
	$req->execute();
	$login = $req->fetch();

	return $login['nbLogin'] > 0;
}

function ajouterMembre($login, $mdp, $type, $ip) {
	global $bdd;

	$req = $bdd->prepare("
		INSERT INTO Userr
		VALUES(NULL, :l, NULL, :mdp, NOW(), :type, :ip)
	");

	$req->bindValue(':l', $login);
	$req->bindValue(':mdp', $mdp);
	$req->bindValue(':type', $type);
	$req->bindValue(':ip', $ip);
	$req->execute();
}
