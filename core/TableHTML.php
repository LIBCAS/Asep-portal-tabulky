<?php

class TableHTML
{

    private $fileId;

    private $file;

    public function __construct($fileId)
    {
        $this->fileId = $fileId;

        $this->file = dirname(__DIR__) . '/output/' . $fileId . '.xlsx';
    }

    public function create()
    {
        require dirname(__DIR__) . '/vendor/autoload.php';

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');

        $spreadsheet = $reader->load($this->file);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Html($spreadsheet);

        $table = $writer->generateSheetData();

        $table = preg_replace(
            '/font-family\s*:\s*[^;"]*;?/',
            '',
            $table
        );

        $table = preg_replace(
            '/font-size\s*:\s*[^;"]*;?/',
            '',
            $table
        );

        file_put_contents(dirname(__DIR__) . '/output/' . $this->fileId . '-table.html', $table);

        $table_styles = $writer->generateStyles();
        $table_styles = str_replace('<style type="text/css">', '', $table_styles);
        $table_styles = str_replace('</style>', '', $table_styles);
        file_put_contents(dirname(__DIR__) . '/output/' . $this->fileId . '.css', $table_styles);
    }
}
