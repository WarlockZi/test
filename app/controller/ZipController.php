<?php

namespace app\controller;

use app\Services\ZipService\ImportFiles;
use app\Services\ZipService\ZipService;

class ZipController extends AppController
{
   private ZipService $service;
   public function __construct()
   {
      $this->service = new ZipService();
   }
   public function actionImportFiles()
   {
      $files = (new ImportFiles)();
      $this->service
         ->files($files)
         ->zipname('import.zip')
         ->download();
      exit;
   }

}