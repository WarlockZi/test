<?php

namespace app\Services\YandexDisk;

class YandexDiskService
{
    public function __construct(string $path)
    {
        $url = "https://cloud-api.yandex.net/v1/disk/resources/upload
? path=<путь, по которому следует загрузить файл>
& [overwrite=true]
& [fields=name,_embedded.items.path]
}";
    }
}
