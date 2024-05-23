<?php

namespace app\core;

class Zip
{
    private array $files;
    private string $zipname;
    private \ZipArchive $zip;

    public function __construct($files, $zipname)
    {
        try {
            $this->files   = $files;
            $this->zipname = $zipname;
            $this->createZip();
        } catch (\Throwable $exception) {
            $this->errorLogger->write('__const' . $exception->getMessage());
        }

    }

    private function createZip(): void
    {
        try {
            $zip = new \ZipArchive();
            $zip->open($this->zipname, \ZipArchive::CREATE);
            foreach ($this->files as $file) {
                if (file_exists($file)) {
                    $zip->addFile($file, basename($file));
                }
            }
            $this->zip = $zip;
        } catch (\Throwable $exception) {
            $this->errorLogger->write('create zip - ' . $exception->getMessage());
        }

    }

    public function download(): void
    {
        try {
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $this->zipname);
            header('Content-Length: ' . filesize($this->zipname));
            readfile($this->zipname);
            exit('downloaded');
        } catch (\Throwable $exception) {
            $this->errorLogger->write('download - ' . $exception->getMessage());
        }

    }


}