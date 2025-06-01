<?php
declare(strict_types=1);

namespace app\controller;

use app\model\Order;
use app\model\OrderItem;
use app\repository\OrderRepository;
use app\service\Response;
use app\service\ShippableUnits\ShippableUnitsService;
use app\view\Cart\CartView;
use JetBrains\PhpStorm\NoReturn;

class CartController extends AppController
{
    public function __construct(
        protected CartView       $cartView,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $order    = OrderRepository::usersOrder();
        $shippableTable = new ShippableUnitsService('cart', null);

        view('cart.cart',
            compact('order','shippableTable'));
    }

    public function actionDrop(): void
    {
        OrderItem::query()
            ->delete();
        if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
        response()->json(['ok' => true]);
    }

    public function actionSubmit(): void
    {
        $orderId = $this->ajax['orderId'];
        if (empty($orderId)) exit('No cart order id');
        Order::find($orderId)->update(['submitted' => 1]);
        response()->json(['ok' => true]);
    }


    public function actionDeleterow(): void
    {
        $req        = $this->ajax;
        $product_id = $req['product_id'];
        $unit_ids   = $req['units'];

        if (!$product_id) response()->json(['msg' => 'No id']);
        $trashed = $this->orderRepo::detachItems($product_id, $unit_ids);

        if ($trashed) {
            response()->json(['ok' => true, 'popup' => 'Удален']);
        }
        Response::exitWithPopup('Не удален');

    }

    public function actionUpdateOrCreate(): void
    {
        OrderRepository::updateOrCreate($this->ajax);
    }
}

