<?php

namespace app\Services\ZipService;

class ImportFiles
{
   public function __invoke():array
   {
      if ($_ENV['DEV'] == 1) {
         return [
            'import' => ROOT . '/app/Storage/dev/import0_1.xml',
            'offer' => ROOT . '/app/Storage/dev/offers0_1.xml',
         ];
      } else {
         return [
            'import' => ROOT . '/app/Storage/import/import0_1.xml',
            'offer' => ROOT . '/app/Storage/import/offers0_1.xml',
         ];
      }
   }
}