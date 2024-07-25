<?php

namespace app\Services\Sync;


use app\model\Category;
use app\Services\Slug;

class LoadCategories
{
    public function __construct(
        private array $file,
        private array $data,
        private $parent = 0,
    )
    {
        $xml        = simplexml_load_file($file);
        $xmlObj     = json_decode(json_encode($xml), true);
        $this->data = $xmlObj['Классификатор']['Группы']['Группа']['Группы']['Группа'];

        $this->run($this->data);
    }


    protected function run($groups): void
    {
        if ($this->isAssoc($groups)) {
            $item = $this->fillItem($groups);
            if (isset($groups['Группы'])) {
                $this->parent = $item['id'];
                $this->run($groups['Группы']['Группа']);
            }
        } else {
            foreach ($groups as $group) {
                $this->run($group);
            }
            $this->parent = null;
        }
    }

    protected function fillItem(array $group): array
    {
        $item['1s_id']       = $group['Ид'];
        $item['category_id'] = $this->parent;
        $item['show_front']  = (int)!(!!$this->parent);

        $item['name']       = $group['Наименование'];
        $item['slug']       = Slug::slug($item['name']);
        $item['deleted_at'] = NULL;

        return Category::withTrashed()
            ->updateOrCreate(['1s_id' => $item['1s_id']], $item)->toArray();
    }

    protected function isAssoc(array $arr): bool
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}