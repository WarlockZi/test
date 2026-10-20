<?php

namespace app\service\Promotion;

use app\repository\PromotionRepository;

class PromotionService
{
    public function getActivePromotions(PromotionRepository $repository): array
    {
        $activePromotions = $repository::active()->toArray();
        if (empty($activePromotions)) return [];

        $promotionUnit = [];
        foreach ($activePromotions['product']['units'] as $unit) {
            if ((int)$unit['id'] === (int)$activePromotions['unit_id']) {
                $promotionUnit = $unit;
            }
        }
        return $promotionUnit;
    }

    public function getInactivePromotions(PromotionRepository $repository)
    {
        $inactivePromotions = $repository::inactive()->toArray();
        if (empty($inactivePromotions)) return [];

        $promotions = [];
        foreach ($inactivePromotions as $promotion) {

            foreach ($promotion['product']['units'] as $unit) {
                if ((int)$unit['id'] === (int)$promotion['unit_id']) {
                    $promotion['promotion_unit'] = $unit;
                    $promotions[$promotion['active_till']] = $promotion;
                }
            }
        }
        return $promotions;
    }
}