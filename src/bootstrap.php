<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__) . '/');
$dotenv->load();

require dirname(__DIR__) . '/core/TableFormatter.php';
require dirname(__DIR__) . '/core/DocDownloader.php';
require dirname(__DIR__) . '/core/TableHTML.php';
require dirname(__DIR__) . '/core/DomParser.php';
require dirname(__DIR__) . '/core/StyleParser.php';
require dirname(__DIR__) . '/core/InlineStyles.php';
