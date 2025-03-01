<?php


namespace app\Storage;


class StorageDev extends Storage
{
	protected $path;

	public function __construct()
	{
		parent::__construct();
		$this->path = $this->storagePath.'dev'.DIRECTORY_SEPARATOR;
	}
}