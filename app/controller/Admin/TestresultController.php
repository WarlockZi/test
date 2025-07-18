<?php

namespace app\controller\Admin;

use app\model\TestResult;
use app\service\AuthService\Auth;
use app\service\Response;
use PHPMailer\PHPMailer\PHPMailer;

class TestresultController extends AdminscController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $res  = TestResult::all()->toArray();
        $user = Auth::getUser();
        $this->setVars(compact('res', 'user'));
    }

    public function actionResult()
    {
        $res      = TestResult::find($this->route->id);
        $testHtml = $res->html;
        $this->setVars(compact('testHtml', 'res'));
    }


    private static function getMailsToSendIfRightResults($mailsTo, $errCount)
    {
        $sendIfLessOrEqualThen = 0;
        $mails                 = explode(',', env('TEST_EMAIL_ONLY_CORRECT'));

        if ((int)$errCount <= $sendIfLessOrEqualThen) {
            return array_merge($mailsTo, $mails);
        }
        return $mailsTo;
    }

    public function actionCreate()
    {
        if ($this->ajax) {
            $result = TestResult::create($this->ajax);
            if ($result->wasRecentlyCreated) {
                $this->sendTestResult($this->ajax, $result->id - 1);
                Response::exitWithPopup('Результат сохранен');
            } else {
                Response::exitWithPopup('Результат в базу не сохранен');
            }
        }
    }

    private function sendTestResult($post, $resid): void
    {
//        if (env('TEST_EMAIL_ALL_SEND']) {
//            Response::exitJson(['popup'=>'mail not sent']);
//        }
        $mailer = new PHPMailer('env');
//        $mailer = new PHPMail('yandexnew');

        $sent = $mailer->sendTestResults($post, $resid);
        Response::exitWithPopup('Результат сохранен');
    }


}