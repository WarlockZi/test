<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Answer;
use app\service\Logger\FileLogger;
use Carbon\Traits\Date;
use Exception;

class GithubController extends AdminscController
{
    protected string $model = Answer::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function actionWebhook()
    {

        try {
            $logger = new FileLogger();
            $time   = date('m/d/Y h:i:s a', time());
            $logger->write("time {$time} " . PHP_EOL);
//			$content = file_get_contents('php://input');
//			$objec = json_decode($content);

            $e = shell_exec("cd /var/www/vitexopt/data/www/vitexopt.ru && npm run build 2>&1");
            $logger->write("exe {$e}" . PHP_EOL);

            http_response_code(200);
            exit('type:' . PHP_EOL);

        } catch (Exception $e) {
            $logger->write('error' . $e->getMessage());
        }
    }
}
