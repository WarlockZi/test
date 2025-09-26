<?php

namespace app\repository;

use app\model\Settings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SettingsRepository
{

    public static function initial(): array
    {
        return Settings::all()->keyBy('name')->toArray();
    }

    public function edit(int $id): Model
    {
        return Settings::query()->find($id);
    }

}
