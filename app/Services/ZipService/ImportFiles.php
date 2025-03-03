<?php

namespace app\Services\ZipService;

use app\core\FS;

class ImportFiles
{
   public function __invoke():array
   {
      if (DEV) {
          $f  =1;
      } else {
      }
         return [
            'import' => FS::platformSlashes(ROOT . '/app/Storage/import/import0_1.xml'),
            'offer' => FS::platformSlashes(ROOT . '/app/Storage/import/offers0_1.xml'),
         ];
   }
}