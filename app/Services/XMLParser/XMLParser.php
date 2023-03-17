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
		$this->recursion($groups);

		$goods = $x[''];
	}

	protected function recursion($groups, $level = 0)
	{
		$length = $groups->Группа->count();
		$i = 0;
		$g = json_decode($groups->Группа);
		while ($i < $length) {
			$hash = (string)$groups->Группа[$i]->Ид;
			$name = (string)$groups->Группа[$i]->Наименование;
			$pref = str_repeat('- ', $level);
			echo "{$pref} {$level} {$name}<br>";
			$i++;
			if (isset($groups->Группа[$i]->Группы))
				$this->recursion($groups->Группа[$i]->Группы, ++$level);
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