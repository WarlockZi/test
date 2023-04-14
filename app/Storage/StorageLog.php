<?php


namespace app\Storage;


class StorageLog extends Storage
{
	protected $path;

	public function __construct()
	{
		parent::__construct();
		$this->path = $this->storagePath.'log'.DIRECTORY_SEPARATOR;
	}

//	public static function getPath(){
//		$self = new self();
//		return $self->path;
//	}
//	public static function getFile(string $file){
//		$self = new self();
//		return $self->path.$file;
//	}


}