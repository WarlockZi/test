<?php

namespace app\service\Sync;


use app\model\Category;
use app\model\CategoryProperty;
use app\service\Logger\ErrorLogger;
use app\service\Router\SlugService;
use app\service\Router\UrlService;
use app\service\ShortLink\ShortlinkService;
use Throwable;

class LoadCategories
{
    public function __construct(
        readonly private string      $file,
        private readonly ErrorLogger $logger = new ErrorLogger('error.txt'),
        private array                $data = [],
        public array                 $deleted = [],
        public array                 $created = [],
        private array                $existed = [],
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


    protected function run($groups, $level = 0, $parent = null): void
    {
        if (!$this->isAssoc($groups)) {
            foreach ($groups as $group) {
                $this->run($group, $level, $parent);
            }
        } else {
            $item                         = $this->fillItem($groups, $parent);
            $this->existed[$groups['Ид']] = $groups['Ид'];
            if (isset($groups['Группы'])) {
                $parent = $item['1s_id'];
                $this->run($groups['Группы']['Группа'], ++$level, $parent);
            }
        }
    }

    protected function fillItem(array $group, string|null $parent): Category
    {
        $item['1s_id']          = $group['Ид'];
        $item['1s_category_id'] = $parent;

        $item['name']       = $group['Наименование'];
        $item['slug']       = SlugService::slug($item['name']);
        $item['deleted_at'] = NULL;

        $cat      = Category::withTrashed()
            ->updateOrCreate(['1s_id' => $item['1s_id']], $item);
        $this->setCategoryOwnProps($cat);

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