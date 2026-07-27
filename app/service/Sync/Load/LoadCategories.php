<?php

namespace app\service\Sync\Load;


use app\model\Category;
use app\service\Router\UrlService;
use app\service\ShortLink\ShortlinkService;
use app\service\Slug\SlugService;
use Exception;
use Throwable;

class LoadCategories extends LoadService
{

    /**
     * @throws Exception
     */
    public function __construct(
        public array    $deleted = [],
        public array    $created = [],
        private array   $existed = [],
        protected array $categoryData = [],
//        protected SyncLogger $logger = new SyncLogger,
    )
    {
        parent::__construct();
        $this->setImportFile();
    }

    /**
     * @throws Exception
     */
    private function setImportFile(): void
    {
        $file = ROOT . env('SYNC_PATH') . 'unzipped/loaded/' . env('SYNC_IMPORT_FILE');
        $this->logger->write("--- xml file - $file ---");
        $xml        = simplexml_load_file($file);
        $importData = json_decode(json_encode($xml), true);
        // выбрать вторые Группы, тк есть Для мед орг и Для промышл орг
        $this->categoryData = $importData['Классификатор']['Группы']['Группа']['Группы']['Группа'];
    }


    public function load(): void
    {
        try {
            $this->exec($this->categoryData);
            $this->deleteNonexisted();
        } catch (LoadException $loadException) {
            $loadException->log();
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
        };
    }

    protected function deleteNonexisted(): void
    {
        Category::all()->each(function (Category $cat) {
            if (!array_search($cat['s_id'], $this->existed)) {
                $cat->delete();
            }
        });
    }

    protected function exec($groups, $level = 0, $parent = null): void
    {
        if (!$this->isAssoc($groups)) {
            foreach ($groups as $group) {
                $this->exec($group, $level, $parent);
            }
        } else {
            $item                         = $this->fillItem($groups, $parent);
            $this->existed[$groups['Ид']] = $groups['Ид'];
            if (isset($groups['Группы'])) {
                $parent = $item['s_id'];
                $this->exec($groups['Группы']['Группа'], ++$level, $parent);
            }
        }
    }

    /**
     * @throws Exception
     */
    protected function fillItem(array $group, string|null $parent): Category
    {
        $item['s_id']           = $group['Ид'];
        $item['category_1s_id'] = $parent;

        $item['name']       = $group['Наименование'];
//        $item['slug']       = SlugService::slug($item['name']);
        $item['deleted_at'] = NULL;

         $cat = Category::withTrashed()
            ->updateOrCreate(['s_id' => $item['s_id']], $item);
        $this->setCategoryOwnProps($cat);

        if ($cat->wasRecentlyCreated) {
            $this->created[] = $cat['name'];
        }
        return $cat;
    }

    /**
     * @throws Exception
     */
    protected function setCategoryOwnProps(Category $category): void
    {
        try {
//            $shortLink = $category?->ownProperties->short_link ?? ShortlinkService::getValidShortLink();
            $category->ownProperties()->updateOrCreate([
                'category_1s_id' => $category['s_id']
            ], [
                'category_1s_id' => $category['s_id'],
//                'short_link' => $shortLink,
//                'path' => UrlService::getCategoryOwnPropPath($category),
            ]);

        } catch (Throwable $exception) {
            $exc = 'load category own props failed: '
                . $exception->getMessage()
                . ' ---file - ' . $exception->getFile()
                . ' ---line - ' . $exception->getLine()
                . ' ---trace - ' . $exception->getTraceAsString();
            $this->logger->write($exc);
            throw new Exception($exc);
        }
    }

    protected function isAssoc(array $arr): bool
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}