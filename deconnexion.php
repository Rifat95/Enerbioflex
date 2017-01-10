<?php

define('DROIT_ACCES', 'membre');
require('./lib/top.php');

session_destroy();
header('Location: ./connexion.php');
exit();
