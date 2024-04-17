<?php

namespace app\Actions\XMLParser;


use app\model\Category;
use app\Services\Logger\ILogger;
use app\Services\Slug;

class LoadCategories extends Parser
{
    protected $logger;
    protected $parent = 0;
//    protected $level = 0;

    public function __construct($file, ILogger $logger)
    {
        parent::__construct($file, 'category');
        $this->logger = $logger;
        $this->logger->write('--- category start ---' . $this->now());
        $this->run();
        $this->logger->write('--- category  stop ---' . $this->now());
    }

    protected function run():void
    {
        try {
            $this->recursion($this->data);
        } catch (\Exception $e) {
            $this->logger->write('--- category  error ---' . $this->now() . $e->getMessage());
        }
    }

    protected function recursion($groups)
    {
        if ($this->isAssoc($groups)) {
            $item = $this->fillItem($groups);
            if (isset($groups['Группы'])) {
//                $this->level++;
                $this->parent = $item['id'];
                $this->recursion($groups['Группы']['Группа']);
            }
        } else {
            foreach ($groups as $group) {
                $this->recursion($group);
            }
            $this->parent = null;
//            $this->level = 0;
        }
    }

    protected function fillItem(array $group)
    {
        $item['1s_id'] = $group['Ид'];
        $item['category_id'] = $this->parent;
        $item['show_front'] = (int)!(!!$this->parent);

        $item['name'] = $group['Наименование'];
        $item['slug'] = Slug::slug($item['name']);
        $item['deleted_at'] = NULL;

        return Category::withTrashed()
            ->updateOrCreate(['1s_id' => $item['1s_id']], $item)->toArray();

    }

    protected function ech(array $item)
    {
        echo "{$item['id']} {$item['pref']} {$item['name']}<br>";
    }


}