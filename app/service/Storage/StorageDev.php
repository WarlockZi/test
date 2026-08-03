<?php


namespace app\service\Storage;


class StorageDev extends Storage
{
    protected string $syncPath;

    public function __construct()
    {
        parent::__construct();
        $this->syncPath = $this->syncPath . 'dev' . DIRECTORY_SEPARATOR;
    }
}