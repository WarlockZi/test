<?php
declare(strict_types=1);

namespace app\controller;

use app\action\CartAction;
use app\formRequest\CartRequest;
use app\model\Order;
use app\model\OrderItem;
use app\repository\CartRepository;
use app\service\Response;
use app\service\Router\IRequest;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\NoReturn;

class CartController extends AppController
{
    public function __construct(
        protected CartRepository $repository,
        protected CartAction     $action,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $order = $this->repository::order();
        view('cart.cart', compact('order'));
    }

    #[NoReturn] public function actionDeleteRow(IRequest $request): void
    {
        $trashed = $this->action->deleteRow($request->body);

        $trashed
            ? response()->json(['deleted' => true, 'popup' => 'Удален'])
            : Response::exitWithPopup('Не удален');
    }

    #[NoReturn] public function actionUpdateOrCreateCustom(CartRequest $request): void
    {
        try {
            $validatedData = $request->validate();
            $this->repository->updateOrCreate($validatedData);
            response()->json(['ok' => true, 'popup' => 'Заказ изменен']);
        } catch (ValidationException $validator) {
            $errors = $validator->errors();
            response()->json(['console' => $errors, 'popup' => 'Ошибка обновления заказа']);
        }
    }

    #[NoReturn] public function actionDrop(): void
    {
        OrderItem::query()
            ->delete();
        if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
        response()->json(['ok' => true]);
    }

    #[NoReturn] public function actionSubmit(): void
    {
        $orderId = $this->ajax['orderId'];
        if (empty($orderId)) exit('No cart order id');
        Order::find($orderId)->update(['submitted' => 1]);
        response()->json(['ok' => true]);
    }


}

