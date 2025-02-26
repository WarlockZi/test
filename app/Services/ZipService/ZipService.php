<?php

namespace app\Services\ZipService;

use app\core\FS;
use app\Services\Logger\ErrorLogger;
use Throwable;

class ZipService
{
    private array $files;
    private string $path;
    private string $zipname;
    private string $zippath;
    private \ZipArchive $zip;
    private ErrorLogger $errorLogger;

    public function __construct(array $files = [])
    {
        $this->errorLogger = new ErrorLogger('errors.txt');
        try {
            $this->files = $files;
        } catch (\Throwable $exception) {
            $this->errorLogger->write('__ZipService__' . $exception->getMessage());
        }
    }

    public function path(string $path): ZipService
    {
        $this->path = FS::platformSlashes(ROOT . $path);
        return $this;
    }

    public function files(array $files): ZipService
    {
        $this->files = $files;
        return $this;
    }

    public function zipname(string $zipname): ZipService
    {
        $this->zipname = $zipname;
        return $this;
    }

    public function createZip(): ZipService
    {
        try {
            $zip           = new \ZipArchive();
            $this->zippath = $this->path . $this->zipname;
            $this->errorLogger->write(PHP_EOL . 'zip path - ' . $this->zippath);
            $zip->open($this->zippath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
            $this->errorLogger->write(PHP_EOL . 'new zip created and opened');
            foreach ($this->files as $file) {
                $file = FS::platformSlashes($file);
                $this->errorLogger->write(PHP_EOL . 'file path - ' . $file);
                if (file_exists($file)) {
                    try {
                        if ($zip->addFile($file, basename($file))) {
                            $this->errorLogger->write(PHP_EOL . ' -- basename added- ' . basename($file));
                        } else {
                            $this->errorLogger->write(PHP_EOL . ' -- file not added');
                        }
                    } catch (Throwable $exception) {
                        $exc = $exception;
                        $this->errorLogger->write(PHP_EOL . ' -- file not added'.$exc);
                    }

                } else {
                    $this->errorLogger->write(PHP_EOL . $file . ' -- file not exists');
                }
            }
            $zip->close();
            $this->zip = $zip;
        } catch (\Throwable $exception) {
            $this->errorLogger->write('create zip error - ' . $exception->getMessage());
        }
        return $this;
    }

    public function download(): void
    {
        try {
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $this->zipname);
            header('Content-Length: ' . filesize($this->zippath));
            readfile($this->zippath);
            $this->errorLogger->write('download - done');
            exit();
        } catch (\Throwable $exception) {
            $this->errorLogger->write('download - ' . $exception->getMessage());
        }
    }
}