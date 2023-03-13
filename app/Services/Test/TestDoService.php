<?php


namespace app\Services\Test;


use app\model\Test;
use app\Repository\TestRepository;
use app\view\Accordion\AccordionView;
use app\view\Right\RightView;
use app\view\Test\TestView;use Illuminate\Database\Eloquent\Model;use MongoDB\BSON\Serializable;

class TestDoService
{
	protected string $accordion;
	protected string $pagination;
	protected $test;
	protected $content;

	public function __construct(int $id)
	{
		$model = TestRepository::do($id);
		$this->test = $model;
		$this->setAccordion();
		$this->setPagination($model);
	}

	public function getTest(){
		return $this->test;
	}

	public function setAccordion()
	{
		$this->accordion = AccordionView::testDo();
		return $this;
	}

	public function setPagination(Model $test)
	{
		$pagination = Test::pagination($test->questions);
		$pagination = "<div class='navigation'>".
			"<div class='test-name' data-test-id={$test->id}>{$test->name}</div>".
      "{$pagination}</div>";
		$this->pagination = $pagination;
		return $this;
	}


	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}

	public function getAccordion()
	{
		return $this->accordion;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getPagination()
	{
		return $this->pagination;
	}

	public function getNoTestTitle()
	{
		return 	"<h2>Выберите тест</h2>";
	}
}