<?php


namespace app\Storage;


class XmlStorage extends Storage
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
		echo $content;;
		return;
	}

	public static function save(string $filename)
	{
		$self = new static();
		move_uploaded_file($filename, $self->path . $filename);
	}
}