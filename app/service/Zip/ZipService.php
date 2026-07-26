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

        $this->safeOpen($zip, $path);

        try {
            $destinationPath = rtrim($this->path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($to, DIRECTORY_SEPARATOR);

            if (!is_dir($destinationPath)) {
                if (!mkdir($destinationPath, 0755, true)) {
                    throw new ZipException('Cannot create destination directory: ' . $destinationPath);
                }
            }

            if ($zip->extractTo($destinationPath) === false) {
                throw new ZipException('Failed to extract files from zip archive');
            }
        } finally {
            $zip->close();
        }
    }

    private function safeOpen(ZipArchive $zip, string $path): void
    {
        $isOpened = $zip->open($path);

        if ($isOpened !== true) {
            $errorMessages = [
                ZipArchive::ER_EXISTS => 'File already exists',
                ZipArchive::ER_INCONS => 'Zip archive inconsistent',
                ZipArchive::ER_INVAL => 'Invalid argument',
                ZipArchive::ER_MEMORY => 'Malloc failure',
                ZipArchive::ER_NOENT => 'No such file',
                ZipArchive::ER_NOZIP => 'Not a zip archive',
                ZipArchive::ER_OPEN => 'Can\'t open file',
                ZipArchive::ER_READ => 'Read error',
                ZipArchive::ER_SEEK => 'Seek error',
            ];

            $message = $errorMessages[$isOpened]
                ?? 'Failed to open zip file (code: ' . $isOpened . ')';

            throw new ZipException($message . '. Path: ' . $path);
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