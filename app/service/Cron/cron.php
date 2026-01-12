<?php

use app\service\Logger\SyncLogger;
use app\service\Sync\Load\LoadService;
use app\service\Sync\SyncActions;
use prod\app\service\Sync\SyncService;

$_SERVER["REQUEST_URI"] = '/adminsc/sync/load';

require dirname(__DIR__, 3) . '/public/index.php';

try {
    $service     = new SyncService(new LoadService, new SyncLogger, new SyncActions(new SyncLogger));
    $service->requestFrom1s();
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
