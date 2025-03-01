<?php


namespace app\Storage;


class StorageImport extends Storage
{
	protected string $path;

	public function __construct()
	{
		parent::__construct();
		$this->path = $this->storagePath.'import'.DIRECTORY_SEPARATOR;
	}

    public function getStoragePath(): string
    {
       return $this->path;
    }
}