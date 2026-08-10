<?php


namespace app\service\Storage;


use app\service\Fs\FS;

class SyncStorage extends Storage
{
    private string $unzippedPath;
    private string $loadedPath;

    public function __construct()
    {
        parent::__construct();
        $this->storagePath  = '/storage/app/sync/';
        $this->unzippedPath = 'unzipped/';
        $this->loadedPath   = 'loaded/';
    }

    public static function getSyncPath(): array|string
    {
        $self = new static();
        return $self->storagePath;
    }
    public static function getUnzippedFiles(): array{
        $loadFiles['import']    = SyncStorage::getUnzippedFile(env('SYNC_IMPORT_FILE'));
        $loadFiles['offer']    = SyncStorage::getUnzippedFile(env('SYNC_OFFER_FILE') );
        return $loadFiles;
    }
    public static function getUnzippedFile(string $file): ?string
    {
        $self = new static();
        $file = $self::getUnzippedDir() . $file;
        if (is_readable($file)) {
            return $file;
        }
        return null;
    }

    public static function getUnzippedDir(): string
    {
        $self = new static();
        return FS::createDirIfNotExist($self->storagePath, $self->unzippedPath);
    }
}