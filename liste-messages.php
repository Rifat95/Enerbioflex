<?php

define('DROIT_ACCES', 'membre');
require('./lib/top.php');
require './modeles/liste-messages.php';

if (formulaireValide('destinataire', 'message')) {
	$user = getUser($_POST['destinataire']);

	if (!$user)
		$_SESSION['msgErreur'] = 'Destinataire inconnu';
	else {
		envoyerMessage($_POST['destinataire'], $_POST['message']);
		$_SESSION['msgSucces'] = 'Message envoyé';
	}
}

if (parametreValide('supprId')) {
	$disc = getDiscussion($_GET['supprId']);
	if (!$disc)
		erreur404();
	elseif ($disc['user1Id'] != $_SESSION['userId'])
		erreur404();
	else {
		supprimerDiscussion($_GET['supprId']);
		header('Location: ./liste-messages.php');
		exit();
	}
}

$discussions = getDiscussions($_SESSION['userId']);
$users = getUsers();

securiserTab($discussions);
securiserTab($users);

define('TITRE', 'Liste des messages');
require('./lib/affichage.php');
