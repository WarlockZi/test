<?php


namespace app\Storage;


class StorageImg extends Storage
{

//  protected $path;

  public function __construct()
  {
    parent::__construct();
    $this->path = ROOT.DIRECTORY_SEPARATOR.'pic'.DIRECTORY_SEPARATOR;
    $this->relativePath = '/pic/';
    return $this;
  }
	public static function getFile($name){
		$self = new static();
		return $self->path.$name;
	}

  public static function getFileContent($name){
  	$self = new static();
  	$file = $self->path.$name;
  	return file_get_contents($file);
	}
}