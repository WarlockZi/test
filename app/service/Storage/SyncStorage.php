<?php


namespace app\service\Storage;


use app\service\Fs\FS;
use app\service\Logger\SyncLogger;

class SyncStorage extends Storage
{
    private string $unzippedPath;
    private string $loadedPath;

    public function __construct()
    {
        parent::__construct();
        $this->syncPath     = '/storage/app/sync/';
        $this->unzippedPath = 'unzipped/';
        $this->loadedPath   = 'loaded/';
    }

    public static function getUnzippedFile(string $file): array|string
    {
        $self = new static();
        $file = $self::getUnzippedDir() . $file;
        if (!is_readable($file)) {
            return $file;
        }
        response()->popup(message: $file. ' не читается');
    }

    public static function getSyncDir(): array|string
    {
        $self = new static();
        return FS::createIfNotExist($self->syncPath);
    }

    public static function getUnzippedDir(): string
    {
        $self = new static();
        return FS::createIfNotExist($self->syncPath, $self->unzippedPath);
    }

    public static function getLoadedDir(): string
    {
        $self = new static();
        return FS::createIfNotExist($self->syncPath, $self->loadedPath);
    }
}