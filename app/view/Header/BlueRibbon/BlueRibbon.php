<?php


namespace app\view\Header\BlueRibbon;


use app\core\FS;
use app\Repository\BlueRibbonRepository;

class BlueRibbon
{
    private string $str;
	public function __construct()
	{
        $fs = new FS(__DIR__.'/templates');
        $data = BlueRibbonRepository::data();
        $this->str =  $fs->getContent('template', $data);
	}

    public function toString()
    {
        return $this->str;
    }
}