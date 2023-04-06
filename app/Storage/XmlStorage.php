<?php


namespace app\Storage;


class XmlStorage extends Storage
{

  protected $path;

  public function __construct()
  {
    parent::__construct();
    $this->path = $this->storagePath.'xml';
    return $this;
  }
}