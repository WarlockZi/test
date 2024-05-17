<?php

namespace app\view\share;

use app\core\FS;
use Illuminate\Database\Eloquent\Collection;

class ShippableUnitsTable
{
    private FS $fs;
    private string $blueButton;
    private string $rows;
    private Collection $items;

    public function __construct(Collection $items)
    {
        $this->fs    = new FS(__DIR__);
        $this->items = $items;
        $this->rows();
    }

    public function greenButton(string $text = "Перейти в корзину"): ShippableUnitsTable
    {
        $this->rows =
            "<div class='button green-button-wrap'>" .
            "<button class='green-button-wrap'>{$text}</button>" .
            $this->rows .
            "</div>";
        return $this;
    }

    public function blueButton(string $text = "Добавить"): ShippableUnitsTable
    {
        $this->blueButton = "<button class='button blue-button'>{$text}</button>";
        return $this;
    }

    private function rows(): void
    {
        $rows = '';
        foreach ($this->items as $item) {

            $rows .= $this->fs->getContent('shippableUnitTable',compact('item'));
        }
        $this->rows = $rows;
    }

    public function get()
    {
        return
            "<div class='shippable-table'>" .
            $this->blueButton .
            $this->rows .
            "</div>";
    }


}