<?php

function changerMail($mail) {
	global $bdd;

	$req = $bdd->prepare("
		UPDATE Userr
		SET mail = :m
		WHERE id = :i
	");

	$req->bindValue(':m', $mail);
	$req->bindValue(':i', $_SESSION['userId']);
	$req->execute();
}

function changerMdp($mdp) {
	global $bdd;

	$req = $bdd->prepare("
		UPDATE Userr
		SET mdp = :m
		WHERE id = :i
	");

	$req->bindValue(':m', $mdp);
	$req->bindValue(':i', $_SESSION['userId']);
	$req->execute();
}

function supprimerCompte() {
	global $bdd;

	$req = $bdd->prepare("
		DELETE FROM Userr
		WHERE id = :i
	");

	$req->bindValue(':i', $_SESSION['userId']);
	$req->execute();
}
