<?php

namespace app\service\Zip;

use app\service\Fs\FS;
use app\service\Logger\ErrorLogger;
use ZipArchive;

class ZipService
{
    private array $files;
    private string $path;
    private string $zipname;
    private string $zippath;
    private ZipArchive $zip;
    private ErrorLogger $errorLogger;

    public function __construct(array $files = [])
    {
        $this->errorLogger = new ErrorLogger('errors.txt');
        $this->files       = $files;
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
    public function unzip(string $to): void
    {
        if (!$to) throw new ZipException('destination path is empty');
        if (!$this->zipname) throw new ZipException('zipname is empty');
        if (!$this->path) throw new ZipException('zippath is empty');
        $path = $this->path . $this->zipname;
        if (!file_exists($path)) throw new ZipException('zipfile not found');

        $zip = new ZipArchive();
        if ($zip->open($path) === TRUE) {
            $zip->extractTo($this->path.$to);
            $zip->close();
        } else {
            throw new ZipException('unzip fail');
        }


    }
    public final function createZip(): ZipService
    {
        try {
            $zip           = new ZipArchive();
            $this->zippath = $this->path . $this->zipname;
            $zip->open($this->zippath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            foreach ($this->files as $file) {
                $file = FS::platformSlashes($file);

                if (file_exists($file)) {
                    $zip->addFile($file, basename($file));
                }
            }
            $zip->close();
            $this->zip = $zip;
        } catch (\Throwable $exception) {
            $this->errorLogger->write('create zip error - ' . $exception->getMessage());
        }
        return $this;
    }

    public final function download(): void
    {
        if (!$this->zipname) throw new ZipException('zipname is empty');
        if (!$this->zippath) throw new ZipException('zippath is empty');

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