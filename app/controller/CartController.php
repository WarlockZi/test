<?php
declare(strict_types=1);

namespace app\controller;

use app\attributes\Validate\ValidationException;
use app\formRequest\CartAddRequest;
use app\formRequest\CartDeleteRowRequest;
use app\formRequest\CartRequest;
use app\repository\CartRepository;
use app\repository\OrderitemRepository;
use app\repository\OrderRepository;
use app\service\AuthService\AuthService;
use app\service\Cart\CartService;
use app\service\Response;
use app\strategy\CartStrategy\AccountCartStrategy;
use app\strategy\CartStrategy\GuestCartStrategy;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

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
        $order['products'] = $this->cartService->getCart(AuthService::accountId());
        view('cart.cart', compact('order'));
    }

    #[NoReturn]
    public function actionSubmit(): void
    {
        try {
            $this->cartService->submit();
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            response()->json(['ok' => false, 'popup' => 'Ошибка']);
        }

        response()->json(['ok' => true]);
    }

    public function actionAdd(CartAddRequest $request): Response
    {
        $validated = $request->validated();
        $this->cartService->updateOrCreate($validated);
        response()->json([
            'ok' => true,
            'popup' => 'Корзина обновлена',
            'cart_count' => CartService::cartCount()
        ]);
    }

    #[NoReturn]
    public function actionDeleteRow(CartDeleteRowRequest $request): void
    {
        $req = $request->validated();
        try {
            OrderRepository::deleteProduct($req['order_id'], $req['product_1s_id']);
            response()->json(['deleted' => true, 'popup' => 'Удален']);
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            response()->popup('Не удален');
        }
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

