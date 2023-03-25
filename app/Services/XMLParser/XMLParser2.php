<?php


namespace app\Services\XMLParser;


use app\core\FS;

class XMLParser2
{
	protected $file;

	public function __construct(string $file)
	{
		$this->file = FS::platformSlashes(ROOT . '/app/Services/XMLParser/' . $file . '.xml');

		$content = simplexml_load_file($this->file);
		$groups = $content->Классификатор->Группы;
//		$groups = json_decode(json_encode($groups), true)['Группа'];
		$str = $groups->asXML();

		$xml = new \SimpleXMLElement($str);
		$result_array = array();
		$this->xmlMap($result_array, $xml);

		var_dump($result_array);
		$this->run();
	}

//$result_array - массив, в котором будут храниться полученные данные (передаётся по ссылке)
//$xmlArray - собственно наша переменная $xml
//getObject($node) - функция для создания объекта в зависимости от узла
	public function xmlMap(&$result_array, $xmlArray): void
	{
		foreach($xmlArray as $key => $node) {
			$object = $this->getObject($node);
			if (!is_null($object)) {
				if (!is_null($object)) {
					if (!isset($result_array)) {
						$result_array = array();
					}
					$i=-1;
					foreach ($node as $child) {
						$object2 = $this->getObject($child);
						$i++;
						if (!is_null($object2)) {
							break;
						}
					}
					array_push($result_array, [$object, $node->children()[$i]->getName() => array()]);
					$this->xmlMap($result_array[count($result_array) - 1][$node->children()[$i]->getName()], $node);
				}
			}
		}
	}
	public function getObject($node)
	{
		switch ($node->getName()) {
			case XmlParser::NODE_SPORT:
				$object = $this->getSportOrCountry($node, new Sport());
				break;
			default:
				$object = null;
		}
		return $object;
	}
}

