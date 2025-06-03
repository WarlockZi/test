<?php

namespace app\service\ShippableUnits;

use app\model\Category;
use app\model\Order;
use app\model\Product;
use app\repository\OrderRepository;

class ShippableUnitsService
{
    public function __construct(
        private readonly string                $module,
        private readonly Category|Product|Order $model,
        public int                             $fontSize = 1,
        public bool                            $blueButton = true,
        public bool                            $greenButton = true,
        public bool                            $description = false,
        public int                             $orderId = 0,
        public array                           $rows = [],
    )
    {
        $this->factory($module);

        if ($model instanceof Product) {
            $this->setRows($model);
        } else if ($model instanceof Category) {
            foreach ($model?->products as $product) {
                $this->setRows($product);
            }
            foreach ($model?->products as $product) {
                $this->setRows($product);
            }
        } else {
            $this->orderId = $model->id;
            foreach ($model?->products as $product) {
                $this->setRows($product);
            }
        }
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    protected function setRows(Product $product): void
    {
        foreach ($product->shippableUnits as $unit) {
            foreach ($product->orderItems as $orderItem) {
                if ($orderItem->unit_id === $unit->id) {
//                    $this->rows[$product['1s_id']][$unit->id] = $orderItem->toArray();
                    $this->rows[$product['1s_id']][$unit->id] = ShippableUnitsRow::row($product, $unit, $orderItem);;
                }
            }
            if (empty($this->rows[$product['1s_id']][$unit->id])) {
                $this->rows[$product['1s_id']][$unit->id] = ShippableUnitsRow::row($product, $unit, null);;
            }
        }
    }

    public function factory(string $module)
    {
        if ($module === 'product') {
            $this->blueButton  = true;
            $this->greenButton = true;
            $this->description = true;
            $this->fontSize    = 2;
        } elseif ($module === 'productCard') {
            $this->fontSize = 2;
        } elseif ($module === 'category') {
            $this->fontSize = 2;
        } elseif ($module === 'cart') {
            $this->blueButton  = false;
            $this->greenButton = false;
            $this->description = true;
            $this->fontSize    = 1;
        }
    }
}