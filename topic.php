<?php

define('DROIT_ACCES', 'membre');
require('./lib/top.php');
require './modeles/topic.php';

if (!parametreValide('id'))
	erreur404();

$topic = getTopic($_GET['id']);
if (!$topic)
	erreur404();

if (formulaireValide('message'))
	ajouterPost($_POST['message'], $_GET['id']);

if (parametreValide('supprId')) {
	$post = getPost($_GET['supprId']);
	if (!$post)
		erreur404();
	elseif ($post['auteurId'] != $_SESSION['userId'] && !$MODO)
		erreur404();
	else {
		supprimerPost($_GET['supprId']);
		header('Location: ./topic.php?id=' . $_GET['id']);
		exit();
	}
}

$posts = getPosts($_GET['id']);

securiserTab($topic);
securiserTab($posts);

define('TITRE', 'Sujet ' . $topic['nom']);
require('./lib/affichage.php');
