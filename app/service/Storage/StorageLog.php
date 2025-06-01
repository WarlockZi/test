<?php


namespace app\service\Storage;


use app\service\FS;

class StorageLog extends Storage
{
    protected string $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = FS::platformSlashes("$this->path/logs/sync/");
    }
}