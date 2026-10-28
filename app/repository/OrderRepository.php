<?php


namespace app\repository;


use app\model\Account;
use app\model\Order;
use app\model\OrderItem;
use app\model\OrderProduct;
use app\model\Product;
use app\service\Cart\CartService;
use app\service\Router\IRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Throwable;


class OrderRepository
{


    public function accountsUsersCartitemsOrders(): array
    {
        $accounts = Account::query()
            ->with('users')
            ->with('yandex_users')
            ->get()->toArray();

        foreach ($accounts as &$account) {
            $account['cart_items'] = self::accountCartsOrders($account['id'], false);
            $account['orders']     = self::accountCartsOrders($account['id'], true);
        }
        return $accounts;
    }

    public static function deleteProduct(string $order_id, string $product_1s_id): bool
    {
        try {
            $orderProduct = OrderProduct::where([
                'order_id' => $order_id,
                'product_id' => $product_1s_id
            ])->first();
            if (!$orderProduct) {
                return false; // или throw new Exception(...)
            }
            OrderItem::where('order_product_id', $orderProduct->id)->delete();
            $orderProduct->delete();
            return true;

        } catch (Throwable $exception) {
            $exc = $exception;
            return false;
        }

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

    public static function accountCartsOrders(int $account_id, bool $order = true): array
    {
        $with_order       = $order;
        $where_order_null = !$order;
        $group_by_order   = $order;

        $query = OrderItem::query()
            ->where('account_id', $account_id)
            ->leftJoin('product_unit', function ($join) {
                $join->on('orderitems.product_1s_id', '=', 'product_unit.product_1s_id')
                    ->on('orderitems.unit_id', '=', 'product_unit.unit_id');
            })
            ->select('orderitems.*', 'product_unit.price', 'product_unit.divider', 'product_unit.multiplier')
            ->with(['product' => function ($q) {
                return $q->with('shippableUnits');
            }])
            ->with(['unit']);

        if ($with_order) {
            $query->with('order:id,created_at,in_process');
        }

        $where_order_null
            ? $query->whereNull('order_id')
            : $query->whereNotNull('order_id');

        $group_by_order = $group_by_order
            ? ['order_id', 'product_1s_id',]
            : ['product_1s_id'];

        $order_items = $query->get();

        if ($order) {
            $order = $order_items->groupBy($group_by_order)->toArray();
            return $order;
        } else {
            $cart = $order_items->groupBy($group_by_order)->toArray();
            return $cart;
        }
    }

    public static function usersOrder(int $id = null, string $onlyField = null, bool $currentUser = null, bool $submitted = null): Model|array|null
    {
        if (isset($_SESSION['cart_items'])) {
            return $_SESSION['cart_items'];
        }
        $order = Order::query();

        if ($currentUser) {
            list($field, $value) = CartService::getCartFieldValue();
            $order->where($field, $value);
        }
        if ($id) {
            $order->where('id', $id);
        }
        if (!$submitted && $submitted !== null) {
            $order->whereNotNull('submitted');
        } elseif ($submitted && $submitted !== null) {
            $order->whereNull('submitted');
        }
        if ($onlyField) {
            $o = $order->select($onlyField)->first();
            return $o?->toArray()[$onlyField] ?? '';
        }

        $order = $order->with(['products' => function ($q) {
            $q->whereHas('orderItems')
                ->withoutTrashed();
        }])
            ->first();

        $order?->products->each(function (Product $product) {
            $product->append('base_unit');
            $product->append('shippable_units');
        });
        return $order;
    }

    public static function inProcess(array $request): string
    {
        try {
            if ($request['in_process']) {
                Order::find($request['order_id'])
                    ->update(['in_process' => Carbon::now()->toDateString()]);
                return 'Заказ взят в работу';
            } else {
                Order::find($request['order_id'])->update(['in_process' => null]);
                return 'Заказ не обработан';
            }
        } catch (Throwable $exception) {
            $msg = $exception->getMessage();
            error_log($msg);
            return 'Ошибка изменения статуса заказа';
        }
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

}