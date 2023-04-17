<?php


namespace app\Storage;


class StorageTxt extends Storage
{

	protected $path;

	public function __construct()
	{
		parent::__construct();
		$this->path = $this->storagePath . 'xml' . DIRECTORY_SEPARATOR;
		return $this;
	}

	public static function getFileContent($name)
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

	public static function save(string $filename)
	{
		$self = new static();
		move_uploaded_file($filename, $self->path . $filename);
	}
}