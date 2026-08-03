<?php


namespace app\service\Storage;


use app\service\Fs\FS;

class StorageProd extends Storage
{
    protected string $syncPath;

    public function __construct()
    {
        parent::__construct();
        $this->syncPath = FS::platformSlashes(ROOT . '/storage/app/userData/');
        return $this;
    }

    public static function getFileContent($file): string
    {
        $self = new static();
        $file = $self->syncPath . $file . '.txt';
        return is_readable($file)
            ? file_get_contents($file)
            : '';
    }

    public static function putFileContent(string $filename, string $content)
    {
        $self = new static();
        $file = $self->syncPath . $filename . '.txt';
        return file_put_contents($file, $content);
    }

    public static function get1cPath()
    {
        $self = new static();
        return $self->syncPath . '1c_upload';
    }

    public function save(string $filename, array $files): array
    {
        $self = new static();
        move_uploaded_file($filename, $self->syncPath . $filename);
        return [];
    }
}