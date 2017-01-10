<?php

define('DROIT_ACCES', 'modo');
require('./lib/top.php');
require './modeles/liste-membres.php';

$users = getUsers();
securiserTab($users);

define('TITRE', 'Liste des utilisateurs');
require('./lib/affichage.php');
