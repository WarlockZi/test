<?php

namespace app\Services\Sync;

use app\model\Category;
use app\model\Price;
use app\model\Product;
use Carbon\Carbon;

class TrancateService
{
    public function softTrancate(): void
    {
        $this->removeCategories();
        $this->softRemoveProducts();
        $this->removePrices();
    }

    public function trancate(): void
    {
        $this->softTrancate();
//		$this->removeCategories();
//		$this->removeProducts();
//		$this->removePrices();
    }

    public function softRemoveProducts(): void
    {
        foreach (Product::all() as $model) {
            $this->softDelete($model);
        }
        $this->log('--- products  soft deleted ---');
    }
    public function softRemovePrices(): void
    {
        Price::truncate();
        $this->log('--- price  soft deleted ---');
    }
    public function softRemoveCategories(): void
    {
        foreach (Category::all() as $model) {
            $this->softDelete($model);
        }
        $this->log('--- category  soft deleted ---');
    }


    public function removePrices(): void
    {
        Price::truncate();
        $this->log('--- price  deleted ---');
    }
    private function removeProducts(): void
    {
        Product::truncate();
        $this->log('--- products  deleted ---');
    }
    private function removeCategories(): void
    {
        Category::truncate();
        $this->log('--- category  deleted ---');
    }


    protected function softDelete($model): void
    {
        $model->update(['deleted_at' => Carbon::today()]);
    }

}