<?php

session_start();
define('PAGE', basename($_SERVER['PHP_SELF'], '.php'));
require('./lib/connexion.php');
require('./lib/fonctions.php');

$MEMBRE = FALSE;
$MODO = FALSE;
$ADMIN = FALSE;

if (isset($_SESSION['userId'])) {
	switch ($_SESSION['userType']) {
		case 'membre':
			$MEMBRE = TRUE;
		break;

		case 'modo':
			$MODO = TRUE;
			$MEMBRE = TRUE;
		break;

		case 'admin':
			$ADMIN = TRUE;
			$MODO = TRUE;
			$MEMBRE = TRUE;
		break;
	}
}

switch (DROIT_ACCES) {
	case 'invite':
		if($MEMBRE) {
			header('Location: index.php');
			exit();
		}
	break;

	case 'membre':
		if(!$MEMBRE) {
			header('Location: connexion.php');
			exit();
		}
	break;

	case 'modo':
		if(!$MODO)
			erreur404();
	break;

	case 'admin':
		if(!$ADMIN)
			erreur404();
	break;
}
