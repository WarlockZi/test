<?php


namespace app\Repository;


use app\core\Auth;
use app\core\Response;
use app\model\Order;
use app\model\OrderItem;
use app\model\Product;
use app\model\User;
use Throwable;


class OrderRepository
{
    public static function updateOrCreate(array $req): void
    {
        if (!$req) return;
        $user = Auth::getUser();
        if ($user) {
            $order = Order::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'user_id' => $user->id,
                'ip' => $_SERVER['SERVER_ADDR'],
            ]);
        } else {
            $order = Order::firstOrCreate([
                'sess' => session_id(),
            ], [
                'sess' => session_id(),
                'ip' => $_SERVER['SERVER_ADDR'],
            ]);
        }

        $product = Product::where('1s_id', $req['product_id'])->first();
        $order->products()->syncWithoutDetaching($product['1s_id']);
        $orderItm = OrderItem::updateOrCreate(
            [
                'order_id' => $order->id,
                'product_id' => $req['product_id'],
                'unit_id' => $req['unit_id'],
            ],
            [
                'order_id' => $order->id,
                'product_id' => $req['product_id'],
                'unit_id' => $req['unit_id'],
                'count' => $req['count'],
            ]
        );
        try {
            $order->products()->orderItems()->updateOrCreate($orderItm->id);
            $product->orderItems()->associate($orderItm->id);
        } catch (Throwable $exception) {
            $exc = $exception;
        }

        if ($orderItm->wasRecentlyCreated) {
            Response::exitJson(['popup' => "Добавлено в корзину"]);
        }
        if ($orderItm->wasChanged()) {
            Response::exitJson(['popup' => "Заказ изменен"]);
        }
        Response::exitJson(['popup' => 'не записано', 'error' => "не записано"]);
    }

    public static function deleteItems(string $sess, string $product_id, array $unitIds)
    {
        try {
            foreach ($unitIds as $unitId) {
                $order = Order::query()
                    ->where('sess', $sess)
                    ->where('product_id', $product_id)
                    ->where('unit_id', $unitId)
                    ->first();
                if ($order) $order->delete();
            }
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

    public static function clientList()
    {

        $orders = User::query()
            ->rightJoin('orders', function ($join) {
                $join->on('orders.user_id', '=', 'users.id');
            })
            ->groupBy('users.id')
            ->get();
        return $orders;
    }

    public static function edit($id)
    {
        $userId = Order::where('id', $id)->first()->user_id;
        $orders = Order::query()
            ->select('product_id', 'id', 'user_id', 'count', 'unit_id', 'created_at')
            ->selectRaw('SUM(count) as total_count')
            ->where('user_id', $userId)
            ->with('user', 'product', 'product.activePromotions', 'product.inactivePromotions', 'unit')
            ->groupBy('product_id')
            ->get();
        $a      = $orders->toArray();
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