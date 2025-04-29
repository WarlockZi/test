<?php
declare(strict_types=1);

namespace app\controller;

use app\model\Order;
use app\model\OrderItem;
use app\repository\CartRepository;
use app\repository\OrderRepository;
use app\service\AssetsService\UserAssets;
use app\service\Response;
use app\service\Router\Request;
use app\view\Cart\CartView;
use JetBrains\PhpStorm\NoReturn;

class CartController extends AppController
{
    public function __construct(
        protected CartView       $cartView,
        protected CartRepository $repo,
        protected UserAssets     $userAssets,
        protected Request        $route)
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $order    = OrderRepository::cart();
        $cartView = $this->cartView;

        $this->render('cart.index', compact('order', 'cartView', ));

    }

    public function actionDrop(): void
    {
        OrderItem::query()
            ->delete();
        if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
        Response::json(['ok' => true]);
    }

    public function actionSubmit(): void
    {
        $orderId = $this->ajax['orderId'];
        if (empty($orderId)) exit('No cart order id');
        Order::find($orderId)->update(['submitted' => 1]);
//        if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
        Response::json(['ok' => true]);
    }


    public function actionDeleterow(): void
    {
        $req        = $this->ajax;
        $product_id = $req['product_id'];
        $unit_ids   = $req['units'];

        if (!$product_id) Response::json(['msg' => 'No id']);
        $trashed = $this->orderRepo::detachItems($product_id, $unit_ids);

        if ($trashed) {
            Response::json(['ok' => true, 'popup' => 'Удален']);
        }
        Response::exitWithPopup('Не удален');

    }

    public function actionUpdateOrCreate(): void
    {
        OrderRepository::updateOrCreate($this->ajax);
    }
}

