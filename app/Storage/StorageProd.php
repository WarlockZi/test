<?php


namespace app\Storage;


class StorageProd extends Storage
{
	protected string $path;

	public function __construct()
	{
		parent::__construct();
		$this->path = $this->storagePath . 'prod' . DIRECTORY_SEPARATOR;
		return $this;
	}

	public static function getFileContent($name): false|string
    {
		$self = new static();
		$file = $self->path . $name . '.txt';
		$content = file_get_contents($file);
		return $content;
	}

	public static function putFileContent(string $filename, string $content)
	{
		$self = new static();
		$file = $self->path . $filename . '.txt';
		return file_put_contents($file, $content);
	}

	public static function get1cPath()
	{
		$self = new static();
		return $self->path.'1c_upload';
	}

	public function save(string $filename, array $files):array
	{
		$self = new static();
		move_uploaded_file($filename, $self->path . $filename);
		return [];
	}
}