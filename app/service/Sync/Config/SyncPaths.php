<?php

namespace app\service\Sync\Config;

use app\service\Storage\SyncStorage;

class SyncPaths
{
    private string $archiveDir;
    private string $unzippedDir;
    private string $importFile;
    private string $offerFile;

    public function __construct(
        protected SyncConfig $config,
    )
    {
        $this->archiveDir  = SyncStorage::getSyncPath();
        $this->unzippedDir = SyncStorage::getUnzippedDir();
        $this->importFile  = $this->unzippedDir . $this->config->getImportFile();
        $this->offerFile   = $this->unzippedDir . $this->config->getOfferFile();
    }

    public function getArchiveDir(): string
    {
        return $this->archiveDir;
    }

    public function getUnzippedDir(): string
    {
        return $this->unzippedDir;
    }

    public function getImportFile(): string
    {
        return $this->importFile;
    }

    public function getOfferFile(): string
    {
        return $this->offerFile;
    }
}