<?php

namespace app\view\share;

use app\core\FS;
use Illuminate\Database\Eloquent\Collection;

class ShippableUnitsTable
{
    private FS $fs;
    private string $greenButton;
    private string $blueButton;
    private Collection $units;
    public function __construct(Collection $units)
    {
        $this->fs = new FS(__DIR__);
        $this->units = $units;
    }
    public function greenButton():string
    {
        return '';
    }
    public function blueButton():string
    {
        return '';

    }
    public function get()
    {
        $table = $this->fs->getContent('shippableUnitTable');
        return $table;
    }


}