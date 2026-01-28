<?php


namespace app\service\Storage;


use app\service\Sync\SyncException;
use Throwable;

class SyncStorage extends Storage
{
    private string $unzippedPath;
    private string $archivePath;
    public function __construct()
    {
        parent::__construct();
        $this->path         = '/storage/app/sync/';
        $this->unzippedPath = 'unzipped/';
        $this->archivePath  = 'archive/';
    }

    public static function getPath(): array|string
    {
        $self = new static();
        return $self->path;
    }

    /**
     * @throws SyncException
     */
    public static function getUnzippedDir(): string
    {
        $self = new static();
        $unzippedDir = ROOT. $self->path. $self->unzippedPath;
        if (!file_exists($unzippedDir)) {
            try {
                mkdir($unzippedDir, 0755, true);
            } catch (Throwable $exception) {
                throw new SyncException('unable to create uzipped path'. $exception->getMessage());
            }
        }
        return $self->path. $self->unzippedPath;
    }
    /**
     * @throws SyncException
     */
    public static function getArchivePath(): string
    {
        $self = new static();
        $archiveDir = ROOT. $self->path. $self->archivePath;
        if (!file_exists($archiveDir)) {
            try {
                mkdir($archiveDir, 0755, true);
            } catch (Throwable $exception) {
                throw new SyncException('unable to create archive path'. $exception->getMessage());
            }
        }
        return $self->path. $self->archivePath;
    }
}