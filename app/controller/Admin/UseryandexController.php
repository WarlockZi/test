<?php

namespace app\controller\Admin;

use app\core\Auth;
use app\core\Response;
use app\model\User;
use app\model\UserYandex;
use app\Repository\UserYandexRepository;
use app\view\User\UserView;
use app\view\UserYandex\UserYandexView;
use Throwable;


class UseryandexController extends AdminscController
{
    public function __construct(
        public UserYandexRepository $repo = new UserYandexRepository,
        public string         $model = UserYandex::class,
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $content = UserYandexView::listAll();
        $this->setVars(compact('content'));
    }


    public function actionEdit(): void
    {
        $user    = $this->model::find($this->route->id);
        $content = UserView::getViewByRole($user, Auth::getUser());

        $this->setVars(compact('content'));

        if ($user = $this->ajax) {
            $user['id'] = $_SESSION['id'];
            User::updateOrCreate($user);
            Response::exitWithPopup('Сохранено');
        }
    }


    public function actionDelete(): void
    {
        if ($data = $this->ajax) {
            if (!Auth::getUser()->can(['user_delete']))
                Response::json(['popup'=>'Не хватает прав']);
            User::find($data['id'])->delete();
            Response::json(['popup'=>'Удален']);
        }
    }

    public function actionChangeRole(): void
    {
        try {
            $this->repo->changeRole($this->ajax);
            Response::exitWithPopup('изменено');
        } catch (Throwable $exception) {
            Response::exitWithPopup('не изменено');
        }
    }
}
