<?php


namespace app\service\Storage;


use app\service\Fs\FS;
use app\service\Sync\SyncException;
use Throwable;

class SyncStorage extends Storage
{
    private string $unzippedPpath;
    public function __construct()
    {
        parent::__construct();
        $this->path = '/storage/app/sync/';
        $this->unzippedPpath = 'unzipped/';
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
        $unzippedDir = ROOT. $self->path. $self->unzippedPpath;
        if (!file_exists($unzippedDir)) {
            try {
                mkdir($unzippedDir, 0755, true);
            } catch (Throwable $exception) {
                throw new SyncException('unable to create uzipped path'. $exception->getMessage());
            }
        }
        return $self->path. $self->unzippedPpath;
    }

}