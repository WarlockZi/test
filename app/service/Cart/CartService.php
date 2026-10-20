<?php

namespace app\service\Cart;

use app\model\Order;
use app\model\OrderItem;
use app\repository\CartRepository;
use app\service\AuthService\AuthService;
use app\strategy\CartStrategy\AccountCartStrategy;
use app\strategy\CartStrategy\GuestCartStrategy;
use app\strategy\CartStrategy\ICartStrategy;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    private ICartStrategy $strategy;
    private CartRepository $repository;

    public function __construct()
    {
        $this->strategy   = AuthService::accountId()
            ? new AccountCartStrategy()
            : new GuestCartStrategy();
        $this->repository = new CartRepository();
    }

    public function getCart(int $account_id=null): Collection|array
    {
        return $this->strategy->getCart($account_id);
    }

    public function submit()
    {
        $orderId = Order::create()->id;
        $cart    = $this->getCart();
        foreach ($cart as $product) {
            if ($product['cart_items']) {
                foreach ($product['cart_items'] as $cart_item) {
                    OrderItem::whereIn('id', [$cart_item['id']])
                        ->update(['order_id' => $orderId]);
                }
            }
        }
    }

    public function mergeCart($account_id): void
    {
        $guest_items = $_SESSION['cart_items'] ?? [];
        if (!$guest_items) return;
        foreach ($guest_items as $product_id => $units) {
            foreach ($units as $unit_id => $count) {
                $this->repository->incrementGuestToAccountCart($account_id, $product_id, $unit_id, $count);
            }
        }
        session()->forget('cart_items');
    }

    public function updateOrCreate(array $validated): void
    {
        $this->strategy->updateOrCreate($validated);
    }

    public static function cartCount(): int
    {
        $self = new self();
        return $self->strategy->cartCount();
    }

    public static function getCartFieldValue(): array
    {
        $user  = AuthService::getUser();
        $field = $user ? 'account_id' : 'vitex_guest_id';
        $value = AuthService::accountId() ?? $_COOKIE['vitex_guest_id'];
        return [$field, $value];
    }

}