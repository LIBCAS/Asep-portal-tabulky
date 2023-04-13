<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;


class InlineStyles
{
    private $fileId;

    public function __construct($fileId)
    {
        $this->fileId = $fileId;
    }

    private function createFullHTML()
    {
        $html = file_get_contents(dirname(__DIR__) . '/template/header.php');
        $html .= file_get_contents(dirname(__DIR__) . '/output/' . $this->fileId .'-table.html');
        $html .= file_get_contents(dirname(__DIR__) . '/template/header.php');

        file_put_contents(
            dirname(__DIR__) . '/output/' . $this->fileId .'-full.html',
            $html
        );
    }

    public function make()
    {
        $cssToInlineStyles = new CssToInlineStyles();

        self::createFullHTML();

        $html = file_get_contents(dirname(__DIR__) . '/output/' . $this->fileId . '-full.html');
        $css = file_get_contents(dirname(__DIR__) . '/output/' . $this->fileId . '.css');

        $inlined = $cssToInlineStyles->convert(
            $html,
            $css
        );

        file_put_contents(
            dirname(__DIR__) . '/output/' . $this->fileId . '-table.html',
            $inlined
        );
    }
}
