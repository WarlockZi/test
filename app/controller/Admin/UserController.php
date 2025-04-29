<?php

namespace app\controller\Admin;

use app\model\User;
use app\repository\UserRepository;
use app\service\AuthService\Auth;
use app\service\Response;
use app\view\User\UserView;
use Throwable;


class UserController extends AdminscController
{
    public function __construct(
        public UserRepository $repo = new UserRepository,
        public string         $model = User::class,
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $content = UserView::listAll();
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
                Response::json(['popup' => 'Не хватает прав']);
            User::find($data['id'])->delete();
            Response::json(['popup' => 'Удален']);
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
