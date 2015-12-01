<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'autoload.php';

$sintegra = new Sintegra();
$data = $sintegra->parseContent('31.804.115-0002-43');

echo json_encode($data); 
