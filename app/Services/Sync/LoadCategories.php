<?php

namespace app\Services\Sync;


use app\model\Category;
use app\model\CategoryProperty;
use app\Services\Logger\ErrorLogger;
use app\Services\ShortlinkService;
use app\Services\SlugService;
use app\Services\UrlService;
use Throwable;

class LoadCategories
{
    public function __construct(
        readonly private string $file,
        private array           $data = [],
        private string|null     $parent = NULL,
        public array            $deleted = [],
        public array            $created = [],
        private array           $existed = [],
        private ErrorLogger     $logger = new ErrorLogger,
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

    protected function run($groups, $level = 0): void
    {
        if (!$this->isAssoc($groups)) {
            foreach ($groups as $group) {
                if ($level === 0) {
                    $this->parent = null;
                }
                $this->run($group, 0);
            }
        } else {
            $item                         = $this->fillItem($groups);
            $this->existed[$groups['Ид']] = $groups['Ид'];
            if (isset($groups['Группы'])) {
                $this->parent = $item['1s_id'];
                $this->run($groups['Группы']['Группа'], ++$level);
            }
        }
    }

    protected function fillItem(array $group): Category
    {
        $item['1s_id']          = $group['Ид'];
        $item['1s_category_id'] = $this->parent;

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
        try {
            $catProps = CategoryProperty::firstOrCreate(
                ['1s_category_id' => $category['1s_id']],
                ['1s_category_id' => $category['1s_id']
//                'slug' => SlugService::getCategorySlug($category)
                ],
            );
            if (!$catProps->short_link) {
                $catProps->short_link = ShortlinkService::getValidShortLink();
            }
//        if (!$catProps->slug) {
//            $catProps->slug = SlugService::getCategorySlug($category);
//        }
            if (!$catProps->path) {
                UrlService::setCateoryOwnPropPath($category);
            }
            $catProps->save();
            return $catProps;
        } catch (Throwable $exception) {
            $exc = 'load category own props failed: ' . $exception->getTraceAsString();
            $this->logger->write($exc);
            throw new \Exception($exc);
        }

    }

    protected function isAssoc(array $arr): bool
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}