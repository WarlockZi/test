<?php


namespace app\repository;



use app\model\Herocategory;
use Illuminate\Database\Eloquent\Collection;

class HeroCategroyRepository
{
    public static function hero(): Collection|array
    {
        return Herocategory::with('category.ownProperties')
            ->get();
    }

}