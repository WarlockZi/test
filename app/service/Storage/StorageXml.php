<?php


namespace app\service\Storage;


class StorageXml extends Storage
{
    protected string $syncPath;

    public function __construct()
    {
        parent::__construct();
        $this->syncPath = $this->syncPath . 'app/xml' . DIRECTORY_SEPARATOR;
    }
}