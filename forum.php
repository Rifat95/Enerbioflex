<?php

define('DROIT_ACCES', 'membre');
require('./lib/top.php');
require './modeles/forum.php';

if (!parametreValide('id'))
	erreur404();

$forum = getForum($_GET['id']);
if (!$forum)
	erreur404();

if (formulaireValide('nom', 'message')) {
	if (strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 70)
		$_SESSION['msgErreur'] = 'Le nom doit contenir entre 2 et 70 caractères';
	else
		ajouterTopic($_POST['nom'], $_POST['message'], $_GET['id']);
}

if (parametreValide('supprId')) {
	$topic = getTopic($_GET['supprId']);
	if (!$topic)
		erreur404();
	elseif ($topic['auteurId'] != $_SESSION['userId'] && !$MODO)
		erreur404();
	else {
		supprimerTopic($_GET['supprId']);
		header('Location: ./forum.php?id=' . $_GET['id']);
		exit();
	}
}

$topics = getTopics($_GET['id']);

securiserTab($forum);
securiserTab($topics);

define('TITRE', 'Forum ' . $forum['nom']);
require('./lib/affichage.php');
