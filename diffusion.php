<?php

define('DROIT_ACCES', 'membre');
require('./lib/top.php');
require './modeles/diffusion.php';

if (!parametreValide('id'))
	erreur404();

if (parametreValide('supprId')) {
	$message = getMessage($_GET['supprId']);
	if (!$message)
		erreur404();
	elseif ($message['auteurId'] != $_SESSION['userId'] && !$MODO)
		erreur404();
	else {
		supprimerMessage($_GET['supprId']);
		header('Location: ./diffusion.php?id=' . $_GET['id']);
		exit();
	}
}

$diffusion = getDiffusion($_GET['id']);
if (!$diffusion)
	erreur404();

if (formulaireValide('message'))
	ajouterMessage($_POST['message'], $_GET['id']);

securiserTab($diffusion);

define('TITRE', $diffusion['titre']);
require('./lib/affichage.php');
