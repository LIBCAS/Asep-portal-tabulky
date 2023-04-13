<?php


class StyleParser
{

    private $fileId;

    public function __construct($fileId)
    {
        $this->fileId = $fileId;
    }

    public function parse()
    {
        require dirname(__DIR__) . '/vendor/autoload.php';

        $css_parser = new Sabberworm\CSS\Parser(
            file_get_contents(dirname(__DIR__) . '/output/' . $this->fileId . '.css')
        );

        $document = $css_parser->parse();

        foreach ($document->getAllRuleSets() as $rule) {
            $rule->removeRule('border-');
            $rule->removeRule('vertical-align');
            $rule->removeRule('width');
            $rule->removeRule('height');
            $rule->removeRule('font-size');
            $rule->removeRule('font-family');
            $rule->removeRule('text-align');
        }


        file_put_contents(
            dirname(__DIR__) . '/output/' . $this->fileId . '.css',
            $document->render()
        );
    }
}
