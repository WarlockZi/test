<?php

use app\service\Sync\SyncService;

$_SERVER["REQUEST_URI"] = '/adminsc/sync/load';

require dirname(__DIR__, 3) . '/public/index.php';

try {
    $service = new SyncService();
    $service->load();
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
