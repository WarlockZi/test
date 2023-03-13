<?php


namespace app\Services\Test;


class TestEditService
{
	protected $title;
	protected $accordion;
	protected $content;

	public function __construct()
	{

	}

	public function getTitle()
	{

	}

	public function setTitle()
	{

	}

	public function getAccordion()
	{
		return $this->accordion;
	}

	public function setAccordion($accordion)
	{
		$this->accordion = $accordion;
		return $this;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}

}