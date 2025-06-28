<?php


namespace app\repository;


use app\model\Order;
use app\model\OrderItem;
use app\model\Product;
use app\service\AuthService\Auth;
use app\service\Router\IRequest;
use Illuminate\Database\Eloquent\Collection;
use Throwable;


class OrderRepository
{
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
            ->get()
        ;
        return $order;
    }

    public static function usersOrder()
    {
        list($field, $value) = Auth::getCartFieldValue();
        $order = Order::where($field, $value)
            ->whereNull('submitted')
            ->with('products.orderItems.unit')
            ->first();
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

    public static function updateOrCreate(array $req): void
    {
        try {
            $order        = self::firstOrCreateOrder($req['loc_storage_cart_id']);
            $orderProduct = OrderProductRepository::firstOrCreate($order->id, $req['product_id']);
            $orderItem    = OrderItemRepository::updateOrCreate($orderProduct, $req);
            $order->load('products.orderItems.unit');
            response()->json(['popup' => 'заказ изменен', 'success' => "записано"]);
        } catch (Throwable $exception) {
            response()->json(['popup' => 'не записано', 'error' => "не записано"]);
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


//
    public static function edit(IRequest $request)
    {
        $orders = Order::
        with('user',
            'products.orderItems.unit',
            'products.activePromotions',
            'products.inactivePromotions')
            ->find($request->id);
        return $orders;
    }

    public static function count(): int
    {
        list($field, $value) = Auth::getCartFieldValue();

        $order = Order::where($field, $value)
            ->select('id')
            ->with(['products' => function ($q) {
                return $q->select('name');
            }])
            ->whereNull('submitted')
            ->first();

        return $order?->products->count() ?? 0;
    }
    //    public static function unsubmittedUsersOrder()
//    {
//        list($field, $value) = Auth::getCartFieldValue();
//        return Order::where($field, $value)
//            ->whereNull('submitted')
//            ->with('products.orderItems.unit')
//            ->first();
//    }

//    public static function unsubmitted(): Collection
//    {
//        return Order::whereNull('submitted')
//            ->with('products.orderItems.unit')
//            ->get();
//    }
}