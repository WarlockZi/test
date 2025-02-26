<?php


namespace app\view\Header\BlueRibbon;


use app\core\FS;
use app\Repository\BlueRibbonRepository;
use Illuminate\Support\Collection;

class BlueRibbon
{
    private string $str;
	public function __construct(Collection $rootCategories)
	{
        $fs = new FS(__DIR__.'/templates');
        $data = BlueRibbonRepository::data($rootCategories);
        $this->str =  $fs->getContent('template', $data);
	}

    public function toString()
    {
        return $this->str;
    }
}