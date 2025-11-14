<?php


namespace app\repository;


use app\model\Order;
use app\model\OrderItem;
use app\model\OrderProduct;
use app\model\Product;
use app\service\AuthService\Auth;
use app\service\Router\IRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;


class OrderRepository
{
    public static function deleteProduct(string $order_id, string $product_1s_id): bool
    {
        try {

            $orderProduct = OrderProduct::where([
                'order_id' => $order_id,
                'product_id' => $product_1s_id
            ])->first();

            OrderItem::where(['order_product_id' => $orderProduct->id,])
                ->get()
                ->each(function ($item) use ($order_id, $product_1s_id) {
                    $item->delete();
                });

            $orderProduct->delete();
            return true;

        } catch (Throwable $exception) {
            $exc = $exception;
            return false;
        }

    }

    public static function submitted(): Collection
    {
        return Order::whereNotNull('submitted')
            ->with('products.orderItems.unit')
            ->get();
    }

    public static function unsubmitted(): Collection
    {
        list($field, $value) = Auth::getCartFieldValue();
        $order = Order::where($field, $value)
            ->whereNull('submitted')
            ->with('products.orderItems.unit')
            ->get();
        return $order;
    }

    public static function usersOrder()
    {
        list($field, $value) = Auth::getCartFieldValue();

        $order = Order::where($field, $value)
            ->whereNull('submitted')
            ->with(['products' => function ($q) {
                $q
                    ->select('*')
                    ->whereHas('orderItems')
                    ->with(['orderitems' => function ($q) {
                        $q->with('unit', 'price.currency', 'price.type');
                    }])
                    ->withoutTrashed()
                ;
            }])
            ->first();
        if ($order) {
//            $order->products->each->append('mainImage');
//            $o = $order->toArray();
        }
        return $order;
    }

    public static function deleteOrderItem(Order $order, Product $product, string $unit_id,)
    {
        return OrderItem::where([
            'order_id' => $order->id,
            'product_id' => $product['1s_id'],
            'unit_id' => $unit_id,
        ])
            ->delete();
    }

    public static function updateOrCreateOrderItem(Order $order, Product $product, string $unit_id, $count)
    {
        return OrderItem::updateOrCreate([
            'order_id' => $order->id,
            'product_id' => $product['1s_id'],
            'unit_id' => $unit_id,
        ],
            [
                'order_id' => $order->id,
                'product_id' => $product['1s_id'],
                'unit_id' => $unit_id,
                'count' => $count,
            ]);
    }

    public static function firstOrCreateOrder(string $loc_storage_cart_id)
    {
        try {
            list($field, $value) = Auth::getCartFieldValue();
            $order = Order::firstOrCreate([
                $field => $value,
                'submitted' => NULL
            ], [
                $field => $value,
                'ip' => $_SERVER['SERVER_ADDR'],
            ]);

            return $order;
        } catch (Throwable $exception) {
            return null;
        }
    }

    public static function userOrder(): ?Order
    {
        list($field, $value) = Auth::getCartFieldValue();
        $order = Order::where([
            'submitted' => null,
            $field => $value,
        ])
            ->first();
        $o     = $order->toArray();
        return $order;
    }

    public static function detachItems(string $product_id, array $unitIds): bool
    {
        $order = OrderRepository::usersOrder();
        try {
            foreach ($unitIds as $unitId => $count) {
                $product = $order->products->where('1s_id', $product_id)->first();
                $a       = $product->toArray();
            }
            $order->products()->detach($product->id);
            return true;
        } catch (\Throwable $exception) {
            $exc = $exception;
            return false;
        }
    }

    private static function q2()
    {
        $orderItems = OrderItem::with('product')
            ->groupBy('sess')
            ->get('*');
        return $orderItems;
    }

    public static function edit(IRequest $request): Model|Collection|Builder|array|null
    {
        $orders = Order::
        with('user',
            'products.orderItems.unit',
            'products.activePromotions',
            'products.inactivePromotions')
            ->find($request->id);
        return $orders;
    }

    public static function productsCount(): int
    {
        list($field, $value) = Auth::getCartFieldValue();
//        $start = microtime(true);
        $order = Order::where($field, $value)
            ->whereNull('submitted')
            ->select('id')
            ->withCount(['products as products_count' => function ($query) {
                $query->where('order_product.deleted_at', NULL); // withoutTrashed() не работает
            }])
            ->first();

//        $time = (microtime(true) - $start)*1000;
        return $order->products_count ?? 0;
    }
}