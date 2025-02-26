<?php

namespace app\view\share\shippable;

use app\core\FS;
use app\model\Product;
use Illuminate\Database\Eloquent\Collection;

class ShippableUnitsTable
{
    private FS $fs;
    private Product $product;
    private Collection $units;
    private string $fontSize = '1';
    private string $baseUnitName;
    private string $blueButton = '';
    private string $greenButton = '';
    private bool $desription = false;
    private bool $totalRowSum = false;
    private float $price = 0;

    public function __construct(Product|array $product)
    {
        $this->fs           = new FS(__DIR__);
        $this->product      = $product;
        $this->price        = (float)$product->price;
        $this->units        = $product->shippableUnits;
        $this->baseUnitName = $product->baseUnit->name ?? '';
        $this->fontSize     = $this->fontSize((float)$this->fontSize)->fontSize ?? '';
    }

    public function greenButton(string $text = "Перейти в корзину"): ShippableUnitsTable
    {
        $this->greenButton = "<button class='button green-button'>{$text}</button>";
        return $this;
    }

    public function fontSize(float $fontSize): ShippableUnitsTable
    {
        $integerPart    = (int)$fontSize;
        $decimalPart    = (int)$fontSize - $integerPart;
        $this->fontSize = "font-size-{$integerPart}-{$decimalPart}-rem";
        return $this;
    }

    private function getGreenButton(): string
    {
        if ($this->greenButton)
            return "<div class='green-button-wrap'>{$this->greenButton}{$this->rows()}</div>";
        return $this->rows();
    }

    public function blueButton(string $text = "Добавить"): ShippableUnitsTable
    {
        $this->blueButton = "<button class='button blue-button'>{$text}</button>";
        return $this;
    }

    public function desription(): ShippableUnitsTable
    {
        $this->desription = true;
        return $this;
    }

    public function totalRowSum(): ShippableUnitsTable
    {
        $this->totalRowSum = true;
        return $this;
    }

    private function format(float $number)
    {
        return number_format($number, 2, '.', ' ') . ' ₽';
    }


    private function getRowSum(int $count, int $multiplier): string
    {
        if ($this->totalRowSum) {
            $rowSum = $this->format($multiplier * $this->price * $count);
            return "<div class='sub-sum' sub-sum>{$rowSum}</div>";
        }
        return '';
    }

    private function getCost(int $count, int $multiplier): string
    {
        return $this->format($count * $multiplier * (float)$this->price);
    }

    private function getDesription(int $count, int $multiplier): string
    {
        if ($this->desription) {
            $count = $this->getDesctiptionCount($count, $multiplier);
            $price = $this->getDesctiptionPrice($multiplier);
            return "<div class='description text-small'>{$count}{$price}</div>";
        }
        return '';
    }

    private function formatNumber(int $number): string
    {
        return number_format($number, 0, '', ' ');
    }

    private function getDesctiptionCount(int $count, int $multiplier): string
    {
        return "<span class='contains'>{$this->formatNumber($multiplier)} {$this->baseUnitName}</span>";
    }

    private function getDesctiptionPrice(int $multiplier): string
    {
        $cost  = $multiplier * $this->price;
        $price = $this->format($multiplier * $this->price);
        return "<span class='cost' data-cost='{$cost}'>{$price}</span>";
    }

    private function getCount($unit)
    {
        if (!isset($this->product->orders?->orderItems)) return 0;
        $o = $this->product->orders?->orderItems?->filter(
            function ($order) use ($unit) {
                return $order->unit_id === $unit['id'];
            }
        );
        return $o->first()->count ?? 0;
    }

    private function rows($rows = ''): string
    {
        $subSum = 0;
        foreach ($this->units as $unit) {
            $count       = $this->getCount($unit);
            $multiplier  = $unit->pivot->multiplier ?? 1;
            $orderItem = $this->product?->order?->orderItems->filter(function ($item)use($unit){
                return $item->unit_id === $unit['id'];
            });

            $arr         = [
                'orderItem' => $orderItem?->first(),
                "unit" => $unit,
                "baseUnit" => $this->baseUnitName,
                "count" => $count,
                "price" => $this->price,
                "multiplier" => $multiplier,
                "cost" => $this->getCost((int)$count, (int)$multiplier),
                "description" => $this->getDesription($count, $multiplier),
                "totalRowSum" => $this->getRowSum($count, $multiplier),
            ];

            $rows .= $this->fs->getContent('shippableUnitTable', $arr);
        }
        return $rows;
    }

    public function get(): string
    {
        return
            "<div class='shippable-table {$this->fontSize}' " .
            "data-price='{$this->product->price}'" .
            " shippable-table " .
            "data-1sid='{$this->product['1s_id']}'>" .
            $this->blueButton .
            $this->getGreenButton() .
            "</div>";
    }
}