<?php

namespace app\view\share\shippable;

use app\core\FS;
use app\model\Order;
use app\model\OrderItem;
use Illuminate\Database\Eloquent\Collection;

class ShippableUnitsTable
{
    private FS $fs;
    private OrderItem $orderItem;
    private Collection|null $shippableUnits;
    private string $fontSize = '1';
    private string $baseUnitName;
    private string $blueButton = '';
    private string $greenButton = '';
    private bool $desription = false;
    private bool $totalRowSum = false;
    private float $price = 0;

    public function __construct(OrderItem $orderItem)
    {
        $this->fs        = new FS(__DIR__);
        $this->orderItem = $orderItem;
        $this->price     = (float)$orderItem->product?->price;
//        $this->shippableUnits = $order->product?->shippableUnits;
        $this->baseUnitName   = $product->baseUnit->name ?? '';
        $this->fontSize       = $this->fontSize((float)$this->fontSize)->fontSize ?? '';
    }

    private function getCount($rowUnit)
    {
        $u = $this->orderItem->product->shippableUnits->filter(
            function ($shippableUnit) use ($rowUnit) {
                return $shippableUnit->id === $this->orderItem->unit_id;
            }
        );
        return $u->first()->count ?? 0;
//    return $this->orderItem->count ?? 0;
    }

    private function getUnit($orderUnit)
    {
        $u = $this->orderItem->product->shippableUnits->filter(
            function ($productUnit) use ($orderUnit) {
                return $productUnit->id === $productUnit;
            }
        );
        return $u->first() ?? null;

    }
    private function getOrderItem($productUnit)
    {
        $u = $this->orderItem->items->filter(
            function ($orderItem) use ($productUnit) {
                return $orderItem->unit_id === $productUnit->id;
            }
        );
        return $u->first() ?? null;

    }
    private function rows($rows = ''): string
    {
        $subSum = 0;
        foreach ($this->shippableUnits as $unit) {
            $orderItem = $this->getOrderItem($unit);
//            $count      = $this->orderItem->count??0;
            $count      = $this->getCount($unit);
            $unit       = $this->getUnit($unit);
            $multiplier = $unit->pivot->multiplier ?? 1;
            $arr        = [
                'orderItem' => $this->orderItem,
                "unit" => $this->orderItem->unit,
//                "unit" => $this->getUnit($unit),
                "baseUnit" => $this->baseUnitName,
                "count" => $this->orderItem->count,
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
            "data-price='{$this->orderItem->price}'" .
            " shippable-table " .
            "data-1sid='{$this->orderItem['1s_id']}'>" .
            $this->blueButton .
            $this->getGreenButton() .
            "</div>";
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

    private function format(float $number): string
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
}