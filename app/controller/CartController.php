<?php
declare(strict_types=1);

namespace app\controller;

use app\attributes\Validate\ValidationException;
use app\factory\CartStorageFactory;
use app\formRequest\CartAddRequest;
use app\formRequest\CartDeleteRowRequest;
use app\formRequest\CartRequest;
use app\formRequest\CartSubmitRequest;
use app\model\Order;
use app\model\OrderItem;
use app\repository\CartRepository;
use app\repository\OrderitemRepository;
use app\repository\OrderRepository;
use app\service\AuthService\AuthService;
use app\service\Cart\CartService;
use app\service\Response;
use app\strategy\CartStrategy\GuestCartStrategy;
use app\strategy\CartStrategy\AccountCartStrategy;
use JetBrains\PhpStorm\NoReturn;

class CartController extends AppController
{
    protected CartRepository $repository;

    public function __construct(
        private CartService $cartService,
    )
    {
        parent::__construct();
        $this->cartService = new CartService();
    }

    #[NoReturn]
    public function actionIndex(): void
    {
        $showToCartButton  = true;
        $order['products'] = $this->cartService->getCart(AuthService::accountId());
        view('cart.cart', compact('order', 'showToCartButton'));
    }

    #[NoReturn]
    public function actionSubmit(): void
    {
        $this->cartService->submit();

        response()->json(['ok' => true]);
    }

    public function actionAdd(CartAddRequest $request): Response
    {
        $validated = $request->validated();
        $this->cartService->updateOrCreate($validated);
        response()->json([
            'ok' => true,
            'popup' => 'Корзина обновлена',
            'cart_count'=>CartService::cartCount()
        ]);
    }

    #[NoReturn]
    public function actionDeleteRow(CartDeleteRowRequest $request): void
    {
        $req = $request->validated();
        OrderRepository::deleteProduct($req['order_id'], $req['product_1s_id'])
            ? response()->json(['deleted' => true, 'popup' => 'Удален'])
            : response()->popup('Не удален');
    }

    #[NoReturn]
    public function actionUpdateOrCreateOrderItem(CartRequest $request, OrderitemRepository $repo): void
    {
        try {
            $req      = $request->safe()->only(['count', 'unit_id', 'product_1s_id', 'vitex_guest_id']);
            $strategy = AuthService::getUser() ? new AccountCartStrategy() : new GuestCartStrategy();
            $repo->updateOrCreate($req, $strategy);
            response()->json(['ok' => true, 'popup' => 'Заказ изменен']);
        } catch (ValidationException $validator) {
            $errors = $validator->errors();
            response()->json(['console' => $errors, 'popup' => 'Ошибка обновления заказа']);
        }
    }
}

