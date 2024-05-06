<?php

namespace app\Domain\UseCase;

use app\model\Decorators\ProductDecorator;
use app\model\Product;

class CategoryUseCase
{
    protected ProductUseCase $productUseCase;
    protected ProductDecorator $productDecorator;

    public function __construct()
    {
        $this->productUseCase = new ProductUseCase();
        $this->productDecorator = new ProductDecorator();
    }

    public function showProductBaseUnitPrice(Product $product):string
    {
        $priceWithUnit = $this->productDecorator->pricesUnitsArray($product);
        if ($priceWithUnit['baseUnit']['price']) {
            return $product->instore ? $priceWithUnit['baseUnit']['price'] . ' ₽ за '
                . $priceWithUnit['baseUnit']['unit'] : 'уточняйте у менеджера';
        }
        return 'не установлена базовая единица';

    }

    public function showProductStatus(Product $product)
    {
        return !!$product->instore ? "в наличии" : "под заказ";
    }

    public function showProductPromotionLable(Product $product)
    {
        return $promotionLabel = $product->activepromotions->count() ? "<div class='promotion'>Акция</div>" : '';;
    }

}