<?php


namespace app\repository;


use app\model\Feedback;

class FeedbackRepository
{
    public static function getCount(): int
    {
        return Feedback::whereNull('done')->count();
    }
}