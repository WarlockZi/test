<?php

namespace app\Services\ZipService;

use app\core\FS;
use app\Services\Logger\ErrorLogger;

class ZipService
{
    private array $files;
    private string $zipname;
    private \ZipArchive $zip;
    private ErrorLogger $errorLogger;

    public function __construct(array $files=[], string $zipname='')
    {
        $this->errorLogger = new ErrorLogger('errors.txt');
        try {
            $this->files   = $files;
            $this->zipname = $zipname;
            $this->createZip();
        } catch (\Throwable $exception) {
            $this->errorLogger->write('__ZipService__' . $exception->getMessage());
        }
    }

    public function files(array $files):ZipService
    {
       $this->files = $files;
       return $this;
    }
   public function zipname(string $zipname):ZipService
   {
      $this->zipname = $zipname;
      return $this;
   }
    private function createZip(): void
    {
        try {
            $zip = new \ZipArchive();
            $zip->open($this->zipname, \ZipArchive::CREATE);
            foreach ($this->files as $file) {
                $file = FS::platformSlashes($file);
                $this->errorLogger->write(PHP_EOL . $file);
                if (file_exists($file)) {
                    $this->errorLogger->write( PHP_EOL . file_exists($file). ' -- file exists');
                    $zip->addFile($file, basename($file));
                }else{
                    $this->errorLogger->write(PHP_EOL . $file. ' -- file not exists');
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
            $this->errorLogger->write('download - done');
            exit();
        } catch (\Throwable $exception) {
            $this->errorLogger->write('download - ' . $exception->getMessage());
        }
    }
}