<?php

namespace app\controller\Admin;

use app\formRequest\OrderInProcessRequest;
use app\formRequest\OrderRequest;
use app\model\Account;
use app\model\Order;
use app\model\OrderItem;
use app\repository\OrderRepository;
use app\service\Admin\AdminOrderService;
use app\service\AuthService\AuthService;
use app\service\Response;
use app\service\Router\IRequest;
use app\strategy\CartStrategy\AccountCartStrategy;
use app\view\Order\OrderView;
use Carbon\Carbon;
use JetBrains\PhpStorm\NoReturn;

class OrderController extends AdminscController
{
    protected string $model = Order::class;

    public function __construct()
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(AdminOrderService $service)
    {
        $accounts = $service->accountsUsersOrders();
//        $a = [];
//        foreach (Account::all() as $acc) {
//            $a[$acc->id] = OrderRepository::accountOrders($acc->id)->toArray();
//        }
//        $orde = OrderRepository::accountOrders(AuthService::accountId())->toArray();
//        $orders = $servie->accountsOrders();
        $showToCartButton  = false;
        view('admin.order.index',
            compact(
                'accounts',
//                'orders',
                'showToCartButton'
            ));

    }
    #[NoReturn] public function actionInprocess(OrderInProcessRequest $request, OrderRepository $repository)
    {
        $validated = $request->validated();
        response()->popup($repository->inProcess($validated));
    }

    #[NoReturn] public function actionEdit(IRequest $request): void
    {
        $order      = OrderRepository::usersOrder(id:$request->id);
        $table      = OrderView::editOrder($order);
        view('admin.order.edit',
            compact('table'));
    }

    public static function updateOrCreate(array $req): void
    {
        if (!$req) return;

        $order = OrderItem::updateOrCreate(
            [
                'product_id' => $req['product_id'],
                'unit_id' => (int)$req['unit_id'],
                'deleted_at' => null,
            ],
            [
                'product_id' => $req['product_id'],
                'unit_id' => (int)$req['unit_id'],
                'count' => (int)$req['count'],
                'ip' => $_SERVER['REMOTE_ADDR'],
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]
        );
        if ($order->wasRecentlyCreated) {
            response()->json(['popup' => "Добавлено в корзину"]);
        }
        if ($order->wasChanged()) {
            response()->json(['popup' => "Заказ изменен"]);
        }
        response()->json(['popup' => 'не записано', 'error' => "не записано"]);
    }

    public function actionDelete(OrderRequest|IRequest $request): void
    {
        $req = $this->ajax;
        try {
            foreach ($req['unit_ids'] as $unit_id) {
                Order::query()
                    ->where('product_id', $req['product_id'])
                    ->where('unit_id', $unit_id)
                    ->whereNull('deleted_at')
                    ->update(['deleted_at' => Carbon::today()]);
            }
            response()->json(['ok' => 'ok', 'popup' => 'удален']);
        } catch (\Throwable $exception) {
            response()->json(['error' => 'не удален', 'popup' => 'не удален']);
        }
    }
}
