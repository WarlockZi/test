<?php


namespace app\service\Storage;


use app\service\Fs\FS;
use DirectoryIterator;

class Storage
{
    protected string $storagePath;
    protected string $file;
    protected string $relativePath;
    protected array|false $files;
    protected array $dirs;

    public function __construct()
    {
        $this->storagePath = storage_path();
    }

    public static function getFile(string $file): string
    {
        $self = new static();
        return $self->storagePath . $file;
    }

    public function getFiles(string $dir = null): false|array
    {
        return $dir
            ? glob("$dir*.*")
            : glob("{$this->storagePath}*.*");
    }

    public function getDirs(): array
    {
        foreach (new DirectoryIterator($this->storagePath) as $file) {
            if ($file->isDir() && !$file->isDot()) {
                $this->dirs[] = $file->getFilename();
            }
        }
        return $this->dirs;
    }


    public static function getFileContent(string $file): false|string
    {
        $self = new static();
        $path = $self->storagePath . $file;
        if (is_file($path) && is_readable($path)) {
            return file_get_contents($path);
        }
        $path = FS::createFileIfNotExist($path);
        return file_get_contents($path);

    }


    public function save(string $path, array $files): array
    {
        $to   = FS::platformSlashes($this->storagePath . $path . '/');
        $rel  = FS::platformSlashes($this->relativePath . $path . '/');
        $srcs = [];
        foreach ($files as $file) {

            if ($file['size'] > 2_000_000)
                response()->json(['error' => "file {$file['name']} - too big size {$file['size']}"]);

            $full = $to . $file['name'];
            $rel  = $rel . $file['name'];
            move_uploaded_file($file['tmp_name'], $full);
            $srcs['absoluteSrcs'][] = $full;
            $srcs['relativeSrcs'][] = $rel;
        }
        return $srcs;
    }

}