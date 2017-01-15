<?php

define('DROIT_ACCES', 'membre');
require('./lib/top.php');
require './modeles/user.php';

if (!parametreValide('id'))
	erreur404();

$user = getUser($_GET['id']);
if (!$user)
	erreur404();

if (formulaireValide('type') && $ADMIN) {
	$chaines = [
		'membre' => 'membre',
		'modo' => 'modérateur',
		'admin' => 'administrateur'
	];

	modifierUser($_POST['type'], $_GET['id']);
	$_SESSION['msgSucces'] = $user['login'] . ' est désormais un ' . $chaines[$_POST['type']];
	header('Location: ./user.php?id=' . $_GET['id']);
	exit();
}

if (parametreValide('action') && $_GET['action'] == 'supprimer' && $ADMIN) {
	supprimerUser($_GET['id']);
	$_SESSION['msgSucces'] = $user['login'] . ' à été supprimé';
	header('Location: ./liste-membres.php');
	exit();
}

securiserTab($user);

function afficherTypes()
{
	global $user;
	$types = array('membre', 'modo', 'admin');

	echo '<option value="' . $user['type'] . '" selected="selected">' . $user['type'] . '</option>';
	foreach ($types as $type) {
		if ($type != $user['type'])
			echo '<option value="' . $type . '">' . $type . '</option>';
	}
}

define('TITRE', 'Profil de ' . $user['login']);
require('./lib/affichage.php');
