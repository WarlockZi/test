<?php


namespace app\Storage;


class StorageLog extends Storage
{
	protected string $path;

	public function __construct()
	{
		parent::__construct();
		$this->path = $this->storagePath.'log'.DIRECTORY_SEPARATOR;
	}
}