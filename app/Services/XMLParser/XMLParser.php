<?php


namespace app\Services\XMLParser;


use app\core\FS;

class XMLParser
{
	protected $file;

	public function __construct(string $file)
	{
		$this->file = FS::platformSlashes(ROOT . '/app/Services/XMLParser/' . $file . '.xml');
		$this->run();
	}

	protected function run()
	{
		$x = simplexml_load_file($this->file);
		$groups = $x->Классификатор->Группы;
		$g = json_decode(json_encode($groups), true)['Группа'];
		$this->recursion($g);

		$goods = $x[''];
	}

	protected function recursion($groups, $level = 0)
	{
		if (!isset($groups['Ид'])) {
			foreach ($groups as $i => $group) {
				$hash = (string)$group['Ид'];
				$name = (string)$group['Наименование'];
				$pref = str_repeat('- ', $level);
				echo "{$pref} #{$i} {$level} {$name}<br>";

				if (isset($group['Группы']))
					$this->recursion($group['Группы']['Группа'], ++$level);
			}
		}else{
				$hash = (string)$groups['Ид'];
				$name = (string)$groups['Наименование'];
				$pref = str_repeat('- ', $level);

				echo "{$pref} {$level} {$name}<br>";
		}
	}

//		$stream = fopen($this->file,'r');
//		$parser = xml_parser_create();
//		while (($data = fread($stream, 16384))) {
//			$str = $data;
//			xml_parse($parser, $data);
//		}
//
//		xml_parse($parser,'',true);
//		xml_parser_free($parser);
//		fclose($stream);


}