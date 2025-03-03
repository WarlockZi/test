<?php


namespace app\Repository;


use app\model\Feedback;

class FeedbackRepository
{
    public static function getCount(): int
    {
        return Feedback::whereNull('done')->count();
    }
}