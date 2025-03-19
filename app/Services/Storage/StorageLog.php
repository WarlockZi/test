<?php


namespace app\Services\Storage;


class StorageLog extends Storage
{
    protected string $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = $this->storagePath . 'logs' . DIRECTORY_SEPARATOR;
    }
}