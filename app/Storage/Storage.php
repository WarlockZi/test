<?php


namespace app\Storage;


use app\core\FS;
use DirectoryIterator;

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
  }

  public function getFiles()
  {
    return glob("{$this->path}*.*");
  }

  public function getDirs()
  {
    $dirs = array();

    foreach (new DirectoryIterator($this->path) as $file) {
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

	public static function getPath(){
		$self = new static();
		return $self->path;
	}
	public static function getFileContent(string $file){
		$self = new static();
		return file_get_contents($self->path.$file);
	}
	public static function getFile(string $file){
		$self = new static();
		return $self->path.$file;
	}

	public function save(string $path){
  	$f = $_FILES;

	}


}