<?php

namespace app\service\Like;

use app\model\Product;
use app\repository\LikeRepository;
use app\service\AuthService\AuthService;
use app\service\Cart\CartService;
use app\strategy\LikeUpdateStrategy\AccountLikeToggleStrategy;
use app\strategy\LikeUpdateStrategy\GuestLikeToggleStrategy;
use app\strategy\LikeUpdateStrategy\ILikeToggleStrategy;

class LikeService
{
    private LikeRepository $repo;
    private ILikeToggleStrategy $strategy;

    public function __construct()
    {
        $this->repo = new LikeRepository();
        $this->strategy = $this->resolveStrategy();
    }

    public function index()
    {
        return $this->strategy->index();
    }

    public function toggle($req): bool
    {
        return $this->strategy->toggleLike($req);
    }

    public function mergeLikes(mixed $account_id): void
    {
        $likes = $_SESSION['likes'] ?? [];
        if (!$likes) return;

        foreach ($likes as $product_id) {
            $this->repo->addLikes($account_id, $product_id);
        }
        session()->forget('likes');
    }
    private function resolveStrategy(): ILikeToggleStrategy
    {
        if (AuthService::accountId()) {
            return new AccountLikeToggleStrategy();
        }
        return new GuestLikeToggleStrategy();
    }
}