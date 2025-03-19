<?php


namespace app\Services\Storage;


class StorageDev extends Storage
{
    protected string $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = $this->storagePath . 'dev' . DIRECTORY_SEPARATOR;
    }
}