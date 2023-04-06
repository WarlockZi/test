<?php


namespace app\Storage;


use app\core\FS;

class Storage
{

  protected $storagePath;
  protected $path;
  protected $files;
  protected $dirs;

  public function __construct()
  {
    $this->storagePath = FS::platformSlashes(ROOT . '/app/Storage/');
    $this->path = $this->storagePath;
    $this->files = $this->getFiles();
    $this->dirs = $this->getDirs();
  }


  public function getFiles()
  {
  	echo $this->path;
    return glob("{$this->path}*.*");
  }

  public function getDirs()
  {
    $dirs = array();

    foreach (new \DirectoryIterator($this->path) as $file) {
      if ($file->isDir() && !$file->isDot()) {
        $dirs[] = $file->getFilename();
      }
    }
    return $this->dirs;
  }

  public function getFileNames()
  {
    $arr = [];
    foreach ($this->files as $file) {
      array_push($arr, basename($file,'.xml'));
    }
    return $arr;
  }


}