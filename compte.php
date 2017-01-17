<?php

define('DROIT_ACCES', 'membre');
require('./lib/top.php');
require('./modeles/compte.php');

if (formulaireValide('mail')) {
	if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
		$_SESSION['msgErreur'] = 'Le format de l\'adresse mail est incorrecte';
	else {
		changerMail($_POST['mail']);
		$_SESSION['userMail'] = $_POST['mail'];
		$_SESSION['msgSucces'] = 'L\'adresse mail à été changé';
	}
}

if (isset($_POST['mdp']) && isset($_POST['mdp2'])) {
	if (strlen($_POST['mdp']) < 6 || strlen($_POST['mdp']) > 40)
		$_SESSION['msgErreur'] = 'Le mot de passe doit contenir entre 6 et 40 caractères';
	elseif ($_POST['mdp'] != $_POST['mdp2'])
		$_SESSION['msgErreur'] = 'Les mots de passe ne correspondent pas';
	else {
		changerMdp(crypterMdp($_POST['mdp']));
		$_SESSION['msgSucces'] = 'Le mot de passe à été changé';
		$_SESSION['userMdp'] = crypterMdp($_POST['mdp']);
	}
}

if (formulaireValide('mdpSupprimer')) {
	if (crypterMdp($_POST['mdpSupprimer']) != $_SESSION['userMdp'])
		$_SESSION['msgErreur'] = 'Mot de passe incorrecte';
	else {
		supprimerCompte();
		header('Location: ./deconnexion.php');
		exit();
	}
}

define('TITRE', $_SESSION['userLogin']);
require('./lib/affichage.php');
