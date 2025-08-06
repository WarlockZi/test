<?php


namespace app\service\Storage;


use app\service\Fs\FS;

class StorageProd extends Storage
{
    protected string $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = FS::platformSlashes(ROOT . '/storage/app/userData/');
        return $this;
    }

    public static function getFileContent($file): string
    {
        $self = new static();
        $file = $self->path . $file . '.txt';
        return is_readable($file)
            ? file_get_contents($file)
            : '';
    }

    public static function putFileContent(string $filename, string $content)
    {
        $self = new static();
        $file = $self->path . $filename . '.txt';
        return file_put_contents($file, $content);
    }

    public static function get1cPath()
    {
        $self = new static();
        return $self->path . '1c_upload';
    }

    public function save(string $filename, array $files): array
    {
        $self = new static();
        move_uploaded_file($filename, $self->path . $filename);
        return [];
    }
}