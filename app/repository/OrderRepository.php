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
            ->with('user')
            ->with('products', function ($query) {
                $query->whereHas('orderItems')
                    ->with(['orderitems' => function ($q) {
                        $q->with('productUnit.unit');
                    }]);
            })
            ->get();
    }

    public static function orders(bool $submitted = true): Collection
    {
        $query = Order::query();
        if ($submitted) {
            $query->whereNotNull('submitted');
        } else {
            $query->whereNull('submitted');
        };

        $orders = $query->with('user')
            ->with('products', function ($query) {
                $query->whereHas('orderItems')
                    ->with(['orderitems' => function ($q) {
                        $q->with('productUnit.unit');
                    }]);
            })
            ->get();
        return $orders;
    }

    public static function usersOrder(int $id = null, string $onlyField = null, bool $currentUser = null, bool $submitted = null): Order|string|null
    {
        $order = Order::query();

        if ($currentUser) {
            list($field, $value) = Auth::getCartFieldValue();
            $order->where($field, $value);
        }
        if ($id) {
            $order->where('id', $id);
        }
        if (!$submitted && $submitted!==null) {
            $order->whereNotNull('submitted');
        } elseif ($submitted && $submitted!==null) {
            $order->whereNull('submitted');
        }
        if ($onlyField) {
            $o = $order->select($onlyField)->first();
            return $o?->toArray()[$onlyField] ?? '';
        }

        $order = $order->with(['products' => function ($q) {
            $q->select('*')
                ->whereHas('orderItems')
                ->with(['orderitems' => function ($query) {
                    $query->with('productUnit.unit');
                }])
                ->withoutTrashed();
        }])
            ->first();
        $order?->products->each(function (Product $product) {
            $product->append('base_unit');
            $product->append('shippable_units');
        });
        return $order;
    }

    public static function edit(IRequest $request): Model|Collection|Builder|array|null
    {
        $orders = Order::query()
            ->with('user',
                'products.activePromotions',
                'products.inactivePromotions')
            ->with('products', function ($query) {
                $query->whereHas('orderItems')
                    ->with(['orderitems' => function ($q) {
                        $q->with('productUnit.unit');
                    }]);
            })
            ->find($request->id);
        return $orders;
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


    public static function productsCount(): int
    {
        list($field, $value) = Auth::getCartFieldValue();
        $order = Order::where($field, $value)
            ->whereNull('submitted')
            ->select('id')
            ->with('productsWithoutAppends', function ($q) {
                return $q
                    ->select('products.id', 'products.1s_id', 'products.name')
                    ->whereHas('orderItems', function ($q) {
                        return $q->where('count', '>', 0)
                            ->whereHas('productUnit.unit');
                    });
            })
            ->first();
        if ($order) {
            $order = $order->toArray();
            return count($order['products_without_appends']) ?? 0;
        }
        return 0;
    }
}