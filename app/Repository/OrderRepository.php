<?php


namespace app\Repository;


use app\core\Auth;
use app\core\Response;
use app\model\Order;
use app\model\OrderItem;
use app\model\Product;
use Illuminate\Database\Eloquent\Collection;
use Throwable;


class OrderRepository
{
    public static function submitted(): Collection
    {
        return Order::
        whereNotNull('submitted')
            ->with('products.orderItems.unit')
            ->get();
    }

    public static function unsubmitted(): Collection
    {
        return Order::
        whereNull('submitted')
            ->with('products.orderItems.unit')
            ->get();
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

    public static function createOrder()
    {
        try {
            $user = Auth::getUser();
            if ($user) {
                $order = Order::firstOrCreate([
                    'user_id' => $user->id,
                    'submitted' => NULL
                ], [
                    'user_id' => $user->id,
                    'ip' => $_SERVER['SERVER_ADDR'],
                    'submitted' => NULL,
                ]);
                $order->load('products.orderItems.unit');

            } else {
                $order = Order::firstOrCreate([
                    'sess' => session_id(),
                    'submitted' => NULL
                ], [
                    'sess' => session_id(),
                    'ip' => $_SERVER['SERVER_ADDR'],
                    'submitted' => NULL,
                ]);
                $order->load('products.orderItems.unit');
            }
            return $order;
        } catch (Throwable $exception) {
            return null;
        }
    }

    public static function updateOrCreate(array $req): void
    {
        if (!$req) return;
        $order   = self::createOrder();
        $product = Product::where('1s_id', $req['product_id'])->first();
        $order->products()->sync($req['product_id'], false);

        if (!$req['count']) {
            $res = self::deleteOrderItem($order, $product, $req['unit_id']);
            if ($product->orderItems->count() === 0) {
                $order->products()->detach($product['1s_id']);
            }
        } else {
            $orderItm = self::updateOrCreateOrderItem($order, $product, $req['unit_id'], (int)$req['count']);
        }

        if ($orderItm->wasRecentlyCreated) {
            Response::exitJson(['popup' => "Добавлено в корзину"]);
        }
        if ($orderItm->wasChanged()) {
            Response::exitJson(['popup' => "Заказ изменен"]);
        }
        Response::exitJson(['popup' => 'не записано', 'error' => "не записано"]);
    }

    public static function detachItems(string $product_id, array $unitIds): bool
    {
        $order = CartRepository::main();
        try {
            foreach ($unitIds as $unitId => $count) {
//                $orderItem = $order->products->orderItems()->where('unit_id', $unitId)->first();
                $product = $order->products->where('1s_id', $product_id)->first();
                $deleted = $product->orderItems
                    ->where('unit_id', $unitId)
                    ->first()
                    ->forceDelete();

                $a = $product->toArray();

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

    public static function userUnsubmittedOrders(): Order
    {
        $user = Auth::getUser();
        if ($user) {
            $order = Order::where([
                'user_id' => $user->id,
                'submitted' => '0'
            ])->with('orderItems.product.units')->first();
        } else {
            $order = Order::where([
                'sess' => session_id(),
                'submitted' => '0'
            ])->with('orderItems.product.units')->first();
        }
        return $order;
    }

    public static function leadList()
    {
        $orderItems = self::q2();
        return $orderItems;
    }

//    public static function clientList()
//    {
//        $orders = User::query()
//            ->rightJoin('orders', function ($join) {
//                $join->on('orders.user_id', '=', 'users.id');
//            })
//            ->groupBy('users.id')
//            ->get();
//        return $orders;
//    }

    public static function edit($id)
    {
        $orders = Order::
            with('user',
            'products.orderItems.unit',
            'products.activePromotions',
            'products.inactivePromotions')
            ->find($id);
        return $orders;
    }

    public static function count(): int
    {
        $user = Auth::getUser();
        if ($user) {
            $order = Order::where('user_id', $user->id)
                ->select('id')
                ->with(['products' => function ($q) {
                    return $q->select('name');
                }])
                ->whereNull('submitted')
                ->first();
        } else {
            $order = Order::where('sess', session_id())
                ->select('id')
                ->with(['products' => function ($q) {
                    return $q->select('name');
                }])
                ->whereNull('submitted')
                ->first();
        }
        return $order?->products->count() ?? 0;
    }
}