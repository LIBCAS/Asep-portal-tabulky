<?php

require 'src/bootstrap.php';

if (!isset($_GET['id'])) {
    header('HTTP/1.1 404 Not Found');
    die('Neexistující id');
}

$table = new TableFormatter($_GET['id']);

$table->make();

$table->output();
