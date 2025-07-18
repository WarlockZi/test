<?php


namespace app\repository;


use app\model\Answer;
use app\model\Test;
use app\service\FS;

class AnswerRepository
{

    public static function getImg(Answer $answer): string
    {
        if ($answer->pica) {
            $src = ImageRepository::getImg('/Pic/' . $answer->pica);
            return "<div class='apic'><img src='{$src}'></div>";
        }
        return '';
    }

    public static function empty()
    {
        $answer = new Answer;
        $i      = -1;
        return FS::getFileContent(ROOT . '/app/view/Question/Admin/edit_BlockAnswer.php');
    }

    public static function getAnswer(int $i, Answer $answer)
    {
        include ROOT . "/app/view/Question/Admin/edit_BlockAnswer.php";
    }


    public static function cacheCorrectAnswers(Test $test): void
    {
//        $res = $test->questions();
        $res                         = $test->questions->map(function ($q) {
            return $q->answers->filter(function ($v, $k) {
                return $v->correct_answer === 1;
            });
        })
            ->flatten()
            ->pluck('id') ?? '';
        $_SESSION['correct_answers'] = $res->toArray();
    }


}