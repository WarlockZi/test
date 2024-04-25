<?php


namespace app\view\Header\BlueRibbon;


use app\core\FS;
use app\Repository\BlueRibbonRepository;

class BlueRibbon
{
	protected $fs;
	protected $data;

	public function __construct()
	{
        $this->fs = new FS(__DIR__.'/templates/');
        $this->data = BlueRibbonRepository::data();
	}
    public function getTemplate(){
        return $this->fs->getContent('template', $this->data);
    }

}