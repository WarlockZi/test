<?php


namespace app\Storage;


use app\core\FS;
use DirectoryIterator;

class Storage
{
	protected $storagePath;
	protected $path;
	protected $relativePath;
	protected $files;
	protected $dirs;

	public function __construct()
	{
		$this->storagePath = FS::platformSlashes(ROOT . '/app/Storage/');
		$this->path = $this->storagePath;
	}

	public static function getFile(string $file)
	{
		$self = new static();
		return $self->path . $file;
	}

	public function getFiles()
	{
		return glob("{$this->path}*.*");
	}

	public function getDirs()
	{
		$dirs = array();

		foreach (new DirectoryIterator($this->path) as $file) {
			if ($file->isDir() && !$file->isDot()) {
				$dirs[] = $file->getFilename();
			}
		}
		return $this->dirs;
	}

	public function getFileNames()
	{
		$arr = [];
		foreach ($this->files as $file) {
			array_push($arr, basename($file, '.xml'));
		}
		return $arr;
	}

	public static function getPath()
	{
		$self = new static();
		return $self->path;
	}

	public static function getFileContent(string $file)
	{
		$self = new static();
		return file_get_contents($self->path . $file);
	}


	public function save(string $path, array $files):array
	{
		$to = $this->path . $path . DIRECTORY_SEPARATOR;
		$rel = $this->relativePath . $path.'/';
		$srcs = [];
		foreach ($files as $file) {

			if ($file['size']>2000000)
				exit(json_encode(['error'=>"file {$file['name']} - too big size {$file['size']}"]));
			$full = $to . $file['name'];
			$rel = $rel . $file['name'];
			move_uploaded_file($file['tmp_name'], $full);
			$srcs['absoluteSrcs'][] = $full;
			$srcs['relativeSrcs'][] = $rel;
		}
		return $srcs;

	}

}