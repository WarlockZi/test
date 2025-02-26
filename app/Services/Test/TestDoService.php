<?php

namespace app\Services\Test;

use app\core\FS;
use app\model\Test;
use app\Repository\TestRepository;
use app\view\Accordion\AccordionView;
use app\view\Test\TestView;
use Illuminate\Database\Eloquent\Model;

class TestDoService
{
	protected string $accordion = '';
	protected string $pagination = '';
	protected Test $test;
	protected $content;
	protected $page_name;
	protected $noTestTitle = '';

	public function __construct($id)
	{
		if ($id === null) {
			$this->setNoTestTitle();
			$this->setContent($this->getNoTestTitle());
			$this->setAccordion();
		} else {
			$test = TestRepository::do($id);
			$this->setContent(
				FS::getFileContent(ROOT . '/app/view/Test/Admin/do_test-data.php', compact('test'))
			);
			$this->setPagination($test);
			$this->setAccordion();
		}
	}

	public function setPageName($page_name)
	{
		$this->page_name = $page_name;
	}

	public function setContent(string $content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setAccordion()
	{
		$this->accordion = AccordionView::testDo();
	}

	public function setPagination(Model $test)
	{
		$pagination = TestView::pagination($test->questions);
		$pagination = "<div class='navigation'>" .
			"<div class='test-name' data-test-id={$test->id}>{$test->name}</div>" .
			"{$pagination}</div>";
		$this->pagination = $pagination;
	}

	public function getTest()
	{
		return $this->test;
	}

	public function getAccordion()
	{
		return $this->accordion;
	}

	public function getPagination()
	{
		return $this->pagination;
	}

	public function getNoTestTitle()
	{
		return $this->noTestTitle;
	}

	public function setNoTestTitle()
	{
		$this->noTestTitle = "<h2>Выберите тест</h2>";
	}

	public function getPageName()
	{
		return $this->page_name;
	}

	public function getHtml()
	{
		$self = $this;
		return FS::getFileContent(ROOT . '/app/view/Test/Admin/do.php', ['test' => $self]);
	}
}