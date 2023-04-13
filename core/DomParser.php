<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use DiDom\Document;

class DomParser
{
    private $fileId;

    private $file;

    public function __construct($fileId)
    {
        $this->file = dirname(__DIR__) . "/output/$fileId-table.html";
    }

    public function parse()
    {
        $document = new Document($this->file, true);

        $table = $document->find('table');

        file_put_contents($this->file, $table);
    }
}
