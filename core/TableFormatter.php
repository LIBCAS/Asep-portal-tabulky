<?php

use DiDom\Document;

class TableFormatter
{
    private $fileId;

    public function __construct($fileId)
    {
        $this->fileId = $fileId;
    }

    public function make()
    {
        (new DocDownloader($this->fileId))->download();

        (new TableHTML($this->fileId))->create();

        (new DomParser($this->fileId))->parse();

        (new StyleParser($this->fileId))->parse();

        (new InlineStyles($this->fileId))->make();

        $full_doc = new Document(
            dirname(__DIR__) . "/output/$this->fileId-table.html",
            true
        );

        file_put_contents(
            dirname(__DIR__) . "/output/$this->fileId.html",
            $full_doc->find('table')
        );
    }

    public function output()
    {
        readfile(dirname(__DIR__) . "/output/$this->fileId.html");
    }
}
