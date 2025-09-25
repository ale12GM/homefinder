<?php
require __DIR__ ."/../vendor/autoload.php";
require 'database.php';
use Model\ActivaModelo;
$db=conectarDB();
ActivaModelo::setDB($db);
?>