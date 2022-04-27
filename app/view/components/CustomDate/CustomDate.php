<?php


namespace app\view\components\CustomDate;


class CustomDate
{
	private $field = '';
	private $className = '';

	private $title = '';

	private $min='';
	private $max='';
	private $value='';


	public $html = '';

	public function __construct($options)
	{
		$this->getOptions($options);
		$this->run();
	}

	protected function getOptions($options)
	{
		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

	public function run()
	{
		ob_start();
		include ROOT . '/app/view/components/CustomDate/CustomDateTemplate.php';
		$html = ob_get_clean();
		$this->html = $html;
	}


}