<?php


namespace app\service\Storage;


class StorageDev extends Storage
{
    protected string $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = $this->path . 'dev' . DIRECTORY_SEPARATOR;
    }
}