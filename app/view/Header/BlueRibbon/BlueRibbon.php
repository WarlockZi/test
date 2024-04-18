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
        $this->data = BlueRibbonRepository::data();
        $this->fs = new FS(__DIR__.'/templates/');
	}
    public function getTemplate(){
        return $this->fs->getContent('template', $this->data);
    }

}