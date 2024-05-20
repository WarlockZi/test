<?php

namespace app\view\share;

use app\core\FS;
use app\model\Product;
use app\view\Testresult\testRestultView;
use Illuminate\Database\Eloquent\Collection;

class ShippableUnitsTable
{
    private FS $fs;
    private Product $product;
    private string $blueButton;
    private string $greenButton;
    private string $baseUnitName;
    private bool $rowSum;
    private float $price;
    private bool $totalBottom;
    private Collection $items;

    public function __construct(Product $product)
    {
        $this->fs           = new FS(__DIR__);
        $this->product      = $product;
        $this->items        = $product->shippableUnits;
        $this->blueButton   = '';
        $this->greenButton  = '';
        $this->rowSum       = false;
        $this->price        = 0;
        $this->totalBottom  = false;
        $this->baseUnitName = $product->baseUnit->name ?? '';
    }

    public function greenButton(string $text = "Перейти в корзину"): ShippableUnitsTable
    {
        $this->greenButton = "<button class='button green-button'>{$text}</button>";
        return $this;
    }

    private function getGreenButton(): string
    {
        if ($this->greenButton)
            return
                $this->rows() .
                $this->getTotal();
        return $this->rows();

    }

    public function blueButton(string $text = "Добавить"): ShippableUnitsTable
    {
        $this->blueButton = "<button class='button blue-button'>{$text}</button>";
        return $this;
    }

    public function rowSum(): ShippableUnitsTable
    {
        $this->price  = (float)$this->product->price;
        $this->rowSum = true;
        return $this;
    }

    public function totalBottom(): ShippableUnitsTable
    {
        $this->totalBottom = true;
        return $this;
    }

    private function getTotal(): string
    {
        if ($this->totalBottom) {
            return "<div class='total-bottom' data-total>0</div>";
        }
        return '';
    }

    private function rows(): string
    {
        $rows        = '';
        $price       = $this->price;
        $totalBottom = $this->totalBottom;
//        $greenButton = $this->greenButton;
        foreach ($this->items as $item) {
            $rowSum         = number_format($item->pivot->multiplier * $price, 2, '.', ' ') . ' ₽';
            $baseUnitName   = $this->baseUnitName;
            $unitsTable     = $this->product->unitsTable;
            $orderItemCount = $this->product->orderItems->filter(
                function ($orderItem) use ($item) {
                    return $orderItem->unit_id === $item['id'];
                }
            )->first()->count ?? 0;
            $rows           .= $this->fs->getContent('shippableUnitTable', compact('item', 'baseUnitName', 'price', 'rowSum', 'totalBottom', 'unitsTable', 'orderItemCount'));
        }
        return $rows;
    }

    public function get(): string
    {
        return
            "<div class='shippable-table' data-price='{$this->product->price}'data-1sid='{$this->product['1s_id']}'>" .
            $this->blueButton .
            $this->greenButton .
            $this->getGreenButton() .
            "</div>";
    }
}