<?php

namespace app\view\Test;

use app\core\FS;
use app\Repository\TestRepository;
use app\view\Accordion\AccordionView;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Traits\CleanString;
use Illuminate\Database\Eloquent\Collection;


class TestView
{
    use CleanString;
    private FS $fs;
    protected string $pagination = '';
    protected string $title = '<h2>Выберите тест</h2>';

    public function __construct()
    {
        $this->fs = new FS(__DIR__);
    }

    public function getAccordion(): string
    {
        return AccordionView::testDo();
    }

    public function getContent($test): string
    {
        return FS::getFileContent(ROOT . '/app/view/Test/Admin/do_test-data.php', compact('test'));
    }


    public function getPagination($test): string
    {
        $pagination = $this->pagination($test->questions);
        return "<div class='navigation'><div class='test-name' data-test-id={$test->id}>{$test->name}</div>{$pagination}</div>";
    }

    public function pagination(Collection $questions): string
    {
        $pagination = '';
        $i          = 0;
        foreach ($questions as $id => $el) {
            $i++;
            $d          = "<div data-pagination={$el['id']}>{$i}</div>";
            $pagination .= $d;
        }

        return "<div class='pagination'>{$pagination}</div>";
    }

    public function getTestContent(int $id): string
    {
        $h = new TestDoService($id);
        return "<div class='test-do'>" . $h->getPagination() . $h->getContent() . "</div>";
    }


    public function testSelector(int $selected, int $excluded): string
    {
        return $this->clean(SelectBuilder::build(
            TreeOptionsBuilder::build(TestRepository::treeAll(), 'children', 2)
                ->initialOption()
                ->selected($selected)
                ->excluded($excluded)
                ->get()
        )
            ->field('test_id')
            ->get()
        );
    }

}