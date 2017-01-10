<?php

define('DROIT_ACCES', 'membre');
require('./lib/top.php');
require './modeles/discussion.php';

if (!parametreValide('id'))
	erreur404();

$discussion = getDiscussion($_GET['id']);
if (!$discussion || $discussion['user1Id'] != $_SESSION['userId'])
	erreur404();

if (formulaireValide('message') && $discussion['user2Id'])
	envoyerMessage($discussion['user2Id'], $_POST['message']);

if (parametreValide('supprId', 'boite')) {
	if ($_GET['boite'] != 'envoye' && $_GET['boite'] != 'recu') {
		erreur404();
	} else {
		if ($_GET['boite'] == 'envoye')
			$boite = 'Envoi';
		else
			$boite = 'Reception';

		$msg = getMessage($_GET['supprId'], $boite);
		if (!$msg)
			erreur404();
		elseif (($boite == 'Envoi' && $msg['expediteurId'] != $_SESSION['userId']) || ($boite == 'Reception' && $msg['destinataireId'] != $_SESSION['userId']))
			erreur404();
		else {
			supprimerMessage($_GET['supprId'], $boite);
			header('Location: ./discussion.php?id=' . $_GET['id']);
			exit();
		}
	}
}

$messages = getMessages($_GET['id']);

securiserTab($discussion);
securiserTab($messages);

if (!$discussion['user2Id'])
	$discussion['user2Login'] = 'Compte supprimé';

define('TITRE', 'Discussion avec ' . $discussion['user2Login']);
require('./lib/affichage.php');
