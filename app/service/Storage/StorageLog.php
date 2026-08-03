<?php


namespace app\service\Storage;


use app\service\Fs\FS;

class StorageLog extends Storage
{
    protected string $syncPath;

    public function __construct()
    {
        parent::__construct();
        $this->syncPath = FS::platformSlashes("$this->syncPath/logs/sync/");
    }
}