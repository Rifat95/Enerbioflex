<?php

define('DROIT_ACCES', 'invite');
require('./lib/top.php');
require('./modeles/oubli.php');

if (!parametreValide('code', 'mail'))
	erreur404();

$user = getUserMail($_GET['mail']);

if (!$user)
	erreur404();

$code = crypterMdp($user['login']);
$code = substr($code, 0, 10);
$code = strtolower($code);

if ($code != $_GET['code'])
	erreur404();

$lien = 'oubli.php?code=' . $_GET['code'] . '&mail=' . $_GET['mail'];

if (isset($_POST['mdp']) && isset($_POST['mdp2'])) {
	if (strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 40)
		$_SESSION['msgErreur'] = 'Le mot de passe doit contenir entre 4 et 40 caractères';
	elseif ($_POST['mdp'] != $_POST['mdp2'])
		$_SESSION['msgErreur'] = 'Les mots de passe ne correspondent pas';
	else {
		changerMdp($user['id'], crypterMdp($_POST['mdp']));
		$_SESSION['msgSucces'] = 'Le mot de passe à été changé';
		header('Location: ./connexion.php');
		exit();
	}
}

define('TITRE', 'Récupérer le mot de passe');
require('./lib/affichage.php');
