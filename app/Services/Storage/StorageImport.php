<?php


namespace app\Services\Storage;


class StorageImport extends Storage
{
    protected string $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = $this->path . 'import' . DIRECTORY_SEPARATOR;
    }

    public function getStoragePath(): string
    {
        return $this->path;
    }
}