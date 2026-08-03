<?php

namespace app\service\Sync\Config;

use app\service\Logger\SyncLogger;

class SyncConfig
{
    public function __construct(
        private readonly array $config,
    )
    {
    }

    public function getImportFile(): string
    {
        return $this->config['import_file'] ?? getenv("SYNC_IMPORT_FILE");
    }

    public function getOfferFile(): string
    {
        return $this->config['offer_file'] ?? getenv("SYNC_OFFER_FILE");
    }

    public function getLogger(): string
    {
        return $this->config['logger'] ?? SyncLogger::class;
    }

}