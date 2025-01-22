<?php

namespace app\Services\Sync;


use app\model\Category;
use app\model\CategoryProperty;
use app\Services\ShortlinkService;
use app\Services\SlugService;
use app\Services\UrlService;

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
        $this->deleteNonexisted();
    }

    protected function deleteNonexisted(): void
    {
        Category::all()->each(function (Category $cat) {
            if (!array_search($cat['1s_id'], $this->existed)) {
                $cat->delete();
            }
        });
    }

    protected function run($groups): void
    {
        if ($this->isAssoc($groups)) {
            $item                         = $this->fillItem($groups);
            $this->existed[$groups['Ид']] = $groups['Ид'];
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

        $item['name']       = $group['Наименование'];
        $item['slug']       = SlugService::slug($item['name']);
        $item['deleted_at'] = NULL;

        $cat      = Category::withTrashed()
            ->updateOrCreate(['1s_id' => $item['1s_id']], $item);
        $catProps = $this->setCategoryOwnProps($cat);

        if ($cat->wasRecentlyCreated) {
            $this->created[] = $cat['name'];
        }
        return $cat;
    }

    protected function setCategoryOwnProps(Category $category): CategoryProperty
    {
        $catProps = CategoryProperty::firstOrCreate(
            ['category_1s_id'=>$category['1s_id']],
            ['category_1s_id'=>$category['1s_id']],
        );
        if (!$catProps->short_link) {
            $catProps->short_link = ShortlinkService::getValidShortLink();
        }
        if (!$catProps->slug) {
            $catProps->slug = SlugService::getValidCategorySlug($category);
        }
        if (!$catProps->path) {
            UrlService::setCateoryOwnPropPath($category);
        }
        $catProps->save();
        return $catProps;
    }

    protected function isAssoc(array $arr): bool
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}