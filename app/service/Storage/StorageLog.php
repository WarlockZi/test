<?php


namespace app\service\Storage;


use app\service\Fs\FS;

class StorageLog extends Storage
{
    protected string $storagePath;

    public function __construct()
    {
        parent::__construct();
        $this->storagePath = FS::platformSlashes("$this->storagePath/logs/");
    }

    public function cleanFile(string $file){
        $file = $this->storagePath . $file;
        if(file_exists($file)){
            file_put_contents($file, "");
        }
    }
}