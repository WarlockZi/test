<?php

namespace app\Services\Sync;


use app\model\Category;
use app\Services\Slug;

class LoadCategories
{
    public function __construct(
        readonly private string $file,
        private array           $data = [],
        private int|null        $parent = 0,
        public array            $deleted = [],
        public array            $created = [],
        private array           $existed = [],
    )
    {
        $xml        = simplexml_load_file($this->file);
        $xmlObj     = json_decode(json_encode($xml), true);
        $this->data = $xmlObj['Классификатор']['Группы']['Группа']['Группы']['Группа'];

        $this->run($this->data);

    }

    protected function deleteNonexisted(): void
    {
        $cat               = Category::whereNotIn('1s_id', $this->existed)->pluck('1s_id');
        $this->deleted[] = $cat->toArray();
        $cat->each(function (Category $cat) {
            $cat->softDelete();
        });
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

    protected function fillItem(array $group): Category
    {
        $item['1s_id']       = $group['Ид'];
        $item['category_id'] = $this->parent;
        $item['show_front']  = (int)!(!!$this->parent);

        $item['name']       = $group['Наименование'];
        $item['slug']       = Slug::slug($item['name']);
        $item['deleted_at'] = NULL;

        $this->existed[$group['Ид']] = $group['Ид'];
        $cat                         = Category::withTrashed()
            ->updateOrCreate(['1s_id' => $item['1s_id']], $item);

        if ($cat->wasRecentlyCreated) {
            $this->created = $cat['name'];
        }
        return $cat;
    }

    protected function isAssoc(array $arr): bool
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}