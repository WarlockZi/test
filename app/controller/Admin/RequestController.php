<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Answer;

class RequestController Extends AppController
{
	protected string $model = Answer::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex():void
	{
		if ($_ENV['MODE'] === 'production') {
			$content = file_get_contents('/var/www/vitexopt/data/logs/vitexopt.ru.access.log');
		} else {
			$content = file_get_contents(__DIR__ . '/vitexopt.ru.access.log');
		}
		$content = preg_replace("/\n/", "<br/>\n", $content);
		$content = $this->filter($content);
		$content = $this->decorate($content);

		$this->set(compact('content'));
	}

	public function actionPhpinfo()
	{
		ob_start();
		phpinfo();
		$content = ob_get_clean();
		$this->set(compact('content'));
	}

	public function actionTest()
	{
		$this->layout = 'test';
		$content = 'd';
		$this->set(compact('content'));
	}

	protected function decorate($content)
	{
		return "<div class='requests'>{$content}</div>";
	}

	protected function filter($content)
	{
		$content = preg_replace('#\n#', '', $content);
		$arr = explode('<br/>', $content);
		$res = '';
		foreach ($arr as $i => $str) {
			if (strpos($str, 'bot') ||
				strpos($str, 'GET /public/dist/')) {
				continue;
			}
			$marked = $this->markIp($str);
			$res .= $this->getString($marked, $i);
		}
		return $res;
	}

	protected function markIp($str)
	{
//		179.43.177.243 - - [15/Apr/2023:03:40:29 +0300] "POST /boaform/admin/formLogin HTTP/1.0" 301 253 "http://78.24.219.227:80/admin/login.asp" "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:71.0) Gecko/20100101 Firefox/71.0"
		preg_match("#(?<ip>\d{1,4}\.\d{1,4}\.\d{1,4}\.\d{1,4})\s.+\s\[(?<date>\d{2}\/\w+\/\d{4}):(?P<time>\d{2}\:\d{2}\:\d{2})\s.+]\s\"(?<group>(?P<method>\w{3,8})\s(?P<req>.+)\s(?P<protocol>.+))?\"\s(?P<redir>.+)\s(?P<length>.+)\s\"(?P<some>.+)\"\s\"(?P<agent>.+)\"#", $str, $matches);
		foreach ($matches as $key => $value) {
			if (is_int($key)) {
				unset($matches[$key]);
			}
		}
		if ($matches) {
			return $matches;
		}
		return [];
	}

	protected function getString(array $arr, int $int)
	{
		if (!isset($arr['agent'])) return '';
		return "<div class='request'><div class='line'><div class='time'>{$arr['time']}</div> <div class='date'>{$arr['date']}</div> <div class='method'>{$arr['method']}</div><div class='ip'>{$arr['ip']}</div></div> <div class='line'><div class='req'>{$arr['req']}</div></div> <div class='line'><div class='some'>{$arr['some']}</div> <div class='agent'>{$arr['agent']}</div></div></div><br/>";
	}
}
