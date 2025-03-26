<?php

namespace app\Services\ZipService;

use app\Services\FS;

class ImportFiles
{
    public function __invoke(): array
    {
        if (DEV) {
            $f = 1;
        } else {
        }
        return [
            'import' => FS::platformSlashes(ROOT . '/storage/app/import/import0_1.xml'),
            'offer' => FS::platformSlashes(ROOT . '/storage/app/import/offers0_1.xml'),
        ];
    }
}