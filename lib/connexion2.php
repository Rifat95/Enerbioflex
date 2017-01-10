<?php

try {
	$bdd = new PDO('mysql:host=db654192383.db.1and1.com;dbname=db654192383;charset=utf8', 'dbo654192383', 'canauxdediscussion');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	die('Erreur : ' . $e->getMessage());
}
