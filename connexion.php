<?php

define('DROIT_ACCES', 'invite');
require('./lib/top.php');
require('./modeles/connexion.php');

if (isset($_POST['login']) && isset($_POST['mdp'])) {
	$_POST['mdp'] = crypterMdp($_POST['mdp']);

	$user = getUser($_POST['login'], $_POST['mdp']);

	if (!$user)
		$_SESSION['msgErreur'] = 'Identifiant ou mot de passe incorrecte';
	else {
		securiserTab($user);
		$_SESSION['userId'] = $user['id'];
		$_SESSION['userLogin'] = $user['login'];
		$_SESSION['userMail'] = $user['mail'];
		$_SESSION['userType'] = $user['type'];
		$_SESSION['userMdp'] = $user['mdp'];
		header('Location: ./index.php');
		exit();
	}
}

if (formulaireValide('mail')) {
	$user = getUserMail($_POST['mail']);

	if (!$user)
		$_SESSION['msgErreur'] = 'Ce mail n\'appartient à aucun compte';
	else {
		securiserTab($user);
		$code = crypterMdp($user['login']);
		$code = substr($code, 0, 10);
		$code = strtolower($code);
		$lien = 'http://' . $_SERVER['HTTP_HOST'] . '/s3a32016/oubli.php?code=' . $code . '&mail=' . $_POST['mail'];

		$destinataire = $_POST['mail'];
		$sujet = 'Changement de votre mot de passe';
		$message = 'CLiquez ici pour changer votre mot de passe : <a href="' . $lien . '">Changer le mot de passe</a>';
		$headers = 'From: ' . 'nepasrepondre@enerbioflex.fr' . PHP_EOL;
		$headers .= 'Content-Type: text/html; charset=ISO-8859-1\r\n';

		mail($destinataire, $sujet, $message, $headers);

		$_SESSION['msgSucces'] = 'Nouveau mot de passe envoyé par mail';
	}
}

define('TITRE', 'Connexion');
require('./lib/affichage.php');
