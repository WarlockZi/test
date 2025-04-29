<?php


namespace app\service\Storage;


class StorageLog extends Storage
{
    protected string $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = $this->path . 'logs' . DIRECTORY_SEPARATOR. 'import'.DIRECTORY_SEPARATOR;
    }
}