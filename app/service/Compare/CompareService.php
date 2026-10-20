<?php

namespace app\service\Compare;

use app\repository\CompareRepository;
use app\service\AuthService\AuthService;
use app\strategy\CompareToggleStrategy\AccountCompareToggleStrategy;
use app\strategy\CompareToggleStrategy\GuestCompareToggleStrategy;
use app\strategy\CompareToggleStrategy\ICompareToggleStrategy;

class CompareService
{
    private CompareRepository $compareRepository;
    private ICompareToggleStrategy $strategy;
    public function __construct()
    {
        $this->compareRepository = new CompareRepository();
        $this->strategy = $this->resolveStrategy();
    }
    public function toggle($req): bool
    {
        return $this->strategy->toggleCompare($req);
    }
    public function mergeCompares()
    {
        $account_id = AuthService::accountId();
        $likes = $_SESSION['compare'] ?? [];
        if (!$likes) return;

        foreach ($likes as $product_id) {
            $this->compareRepository->addCompare($account_id, $product_id);
        }
        session()->forget('likes');
    }
    private function resolveStrategy()
    {
        if (AuthService::accountId()) {
            return new AccountCompareToggleStrategy();
        }
        return new GuestCompareToggleStrategy();
    }
}