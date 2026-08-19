<?php


namespace app\service\Storage;


use app\service\Fs\FS;
use SplFileInfo;

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
        $loadFiles['import']    = SyncStorage::getUnzippedFileInfo(env('SYNC_IMPORT_FILE'));
        $loadFiles['offer']    = SyncStorage::getUnzippedFileInfo(env('SYNC_OFFER_FILE') );

        return $loadFiles;
    }
    public static function getUnzippedFileInfo(string $file): ?array
    {
        $self = new static();
        $file = $self::getUnzippedDir() . $file;
        if (is_readable($file)) {
            $file = new SplFileInfo($file);
            $readableDate = date('d.m.Y H:i:s', $file->getMTime());
            return ['path' => $file->getRealPath(), 'date' => $readableDate];
        }
        return null;
    }

    public static function getUnzippedDir(): string
    {
        $self = new static();
        return FS::ensureDir($self->storagePath, $self->unzippedPath);
    }
}