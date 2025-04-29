<?php


namespace app\service\Storage;


class StorageXml extends Storage
{
    protected string $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = $this->path . 'app/xml' . DIRECTORY_SEPARATOR;
    }
}