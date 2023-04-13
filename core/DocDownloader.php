<?php

class DocDownloader
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function download()
    {
        $client = new Google_Client();
        $client->setApplicationName('ASEP Docs');
        $client->setDeveloperKey(getenv('GOOGLE_DEVELOPER_KEY'));
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->addScope(Google_Service_Sheets::SPREADSHEETS);

        try {
            $response = (new Google_Service_Drive($client))->files->export(
                $this->file,
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                [
                    'alt' => 'media'
                ]
            );

            $outHandle = fopen(dirname(__DIR__) . "/output/{$this->file}.xlsx", 'w+');

            while (!$response->getBody()->eof()) {
                fwrite($outHandle, $response->getBody()->read(1024));
            }

            fclose($outHandle);
            header('HTTP/1.1 200 OK');
        } catch (\Exception $e) {
            $err = (array) json_decode($e->getMessage());
            header('HTTP/1.1 ' . $err['error']->code . ' ' . $err['error']->message);
            echo '<h2>' . $err['error']->code . '</h2>';
            die($err['error']->message);
        }
    }
}
