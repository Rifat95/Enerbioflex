<?php

define('DROIT_ACCES', 'invite');
require('./lib/top.php');
require('./modeles/inscription.php');

if (isset($_POST['login']) && isset($_POST['mdp']) && isset($_POST['mdp2'])) {
	$ip = $_SERVER['REMOTE_ADDR'];
	$caracteresPermis = '#^([a-z0-9çàâäèéêëîïôöùûü]+)[_-]?([a-z0-9çàâäèéêëîïôöùûü]+)$#i';

	if (strlen($_POST['login']) < 2 || strlen($_POST['login']) > 15)
		$_SESSION['msgErreur'] = 'Le login doit contenir entre 2 et 15 caractères';
	elseif (strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 40)
		$_SESSION['msgErreur'] = 'Le mot de passe doit contenir entre 4 et 40 caractères';
	elseif (!preg_match($caracteresPermis, $_POST['login']))
		$_SESSION['msgErreur'] = 'Le login contient des caractères non autorisés';
	elseif ($_POST['mdp'] != $_POST['mdp2'])
		$_SESSION['msgErreur'] = 'Les mots de passe ne correspondent pas';
	elseif (!filter_var($ip, FILTER_VALIDATE_IP))
		$_SESSION['msgErreur'] = 'Asresse IP non valide';
	elseif (membreExiste($_POST['login']))
		$_SESSION['msgErreur'] = 'Ce login est déja pris';
	else {
		ajouterMembre($_POST['login'], crypterMdp($_POST['mdp']), 'membre', $ip);
		$_SESSION['msgSucces'] = 'Inscription effectué';
		header('Location: ./connexion.php');
		exit();
	}
}

define('TITRE', 'Inscription');
require('./lib/affichage.php');
