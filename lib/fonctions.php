<?php

function erreur404() {
	header('Location: ./index.php');
	exit();
}

function crypterMdp($mdp) {
	$sel = strlen($mdp)*10/02/2004;
	$mdpCrypte = sha1(md5($sel).md5($mdp));
	$mdpCrypte = strtoupper($mdpCrypte);

	return $mdpCrypte;
}

function securiserTab(&$tab) {
	foreach ($tab as $i => $val) {
		if (is_array($tab[$i]))
			securiserTab($tab[$i]);
		else {
			$tab[$i] = htmlspecialchars($val, ENT_QUOTES);
			$tab[$i] = nl2br($val);
		}
	}
}

function formulaireValide() {
	$champs = func_get_args();

	foreach($champs as $champ) {
		if (isset($_POST[$champ])) {
			$_POST[$champ] = trim($_POST[$champ]);
			if (empty($_POST[$champ]))
				return false;
		} else
			return false;
	}

	return true;
}

function parametreValide() {
	$champs = func_get_args();

	foreach($champs as $champ) {
		if (isset($_GET[$champ])) {
			$_GET[$champ] = trim($_GET[$champ]);
			if (empty($_GET[$champ]))
				return false;
		} else
			return false;
	}

	return true;
}

function formaterDate($date) {
	$date = new DateTime($date);

	return $date->format('d/m/y - H:i');
}

function nbMessage() {
	global $bdd;

	$req = $bdd->prepare("
		SELECT COUNT(*) AS nbMessage
		FROM Reception
		WHERE destinataireId = :i
		AND lu = 'false'
	");

	$req->bindValue(':i', $_SESSION['userId']);
	$req->execute();

	$messages = $req->fetch();

	if ($messages['nbMessage'] > 0)
		return '(' . $messages['nbMessage'] . ')';
	else
		return '';
}

function dateIntelligente($date) {
	$auj = new DateTime('now');
	$date = new DateTime($date);

	if($date->format('d/m/Y') < $auj->format('d/m/Y') )
		return $date->format('d/m/y - H:i');
	else
		return $date->format('H:i');
}
