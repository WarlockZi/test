<?php


namespace app\Storage;


class Storage1c extends Storage
{
	protected $path;

	public function __construct()
	{
		parent::__construct();
		$this->path = $this->storagePath.'upload'.DIRECTORY_SEPARATOR;
	}

	public static function getPath(){
		$self = new self();
		return $self->path;
	}


}