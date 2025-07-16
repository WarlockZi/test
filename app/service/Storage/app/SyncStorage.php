<?php


namespace app\service\Storage\app;


use app\service\Fs\FS;
use app\service\Storage\Storage;

class SyncStorage extends Storage
{
    public function __construct()
    {
        parent::__construct();
        $this->path = FS::platformSlashes(APP_STORAGE . 'sync/');
//        $this->file = $this->path.'syn';
    }
}