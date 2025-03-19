<?php


namespace app\Services\Storage;


class StorageXml extends Storage
{
    protected string $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = $this->storagePath . 'xml' . DIRECTORY_SEPARATOR;
    }


}