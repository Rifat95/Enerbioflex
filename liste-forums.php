<?php

define('DROIT_ACCES', 'membre');
require('./lib/top.php');
require './modeles/liste-forums.php';

if (formulaireValide('nom', 'description') && $MODO) {
	if (strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 25)
		$_SESSION['msgErreur'] = 'Le nom doit contenir entre 2 et 25 caractères';
	elseif (strlen($_POST['description']) < 2 || strlen($_POST['description']) > 100)
		$_SESSION['msgErreur'] = 'La description doit contenir entre 2 et 100 caractères';
	else
		ajouterForum($_POST['nom'], $_POST['description']);
}

if (parametreValide('supprId') && $MODO) {
	$forum = getForum($_GET['supprId']);
	if (!$forum)
		erreur404();
	else {
		supprimerForum($_GET['supprId']);
		header('Location: ./liste-forums.php');
		exit();
	}
}

$forums = getForums();
securiserTab($forums);

define('TITRE', 'Liste des forums');
require('./lib/affichage.php');
