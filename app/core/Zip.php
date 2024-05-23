<?php

namespace app\core;

class Zip
{
    private array $files;
    private string $zipname;
    private \ZipArchive $zip;
    public function __construct($files ,$zipname)
    {
        $this->files = $files;
        $this->zipname = $zipname;
        $this->createZip();
    }

    private function createZip():void
    {
        $zip = new \ZipArchive();
        $zip->open($this->zipname, \ZipArchive::CREATE);
        foreach ($this->files as $file) {
            if (file_exists($file)) {
                $zip->addFile($file, basename($file));
            }
        }
        $this->zip = $zip;
    }

    public function download():void
    {
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $this->zipname);
        header('Content-Length: ' . filesize($this->zipname));
        readfile($this->zipname);
        exit();
    }



}