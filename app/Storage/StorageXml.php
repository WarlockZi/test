<?php


namespace app\Storage;


class StorageXml extends Storage
{
	protected $path;

	public function __construct()
	{
		parent::__construct();
		$this->path = $this->storagePath.'xml'.DIRECTORY_SEPARATOR;
	}




}