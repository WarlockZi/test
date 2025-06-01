<?php

namespace app\controller\Admin;

use app\action\admin\UserYandexAction;
use app\model\User;
use app\model\UserYandex;
use app\repository\UserYandexRepository;
use app\service\AuthService\Auth;
use app\service\Response;
use app\view\User\UserView;
use JetBrains\PhpStorm\NoReturn;
use Throwable;


class UseryandexController extends AdminscController
{
    public function __construct(
        protected UserYandexAction  $actions,
        public UserYandexRepository $repo = new UserYandexRepository,
        public string               $model = UserYandex::class,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $this->showTable();
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
                response()->json(['popup' => 'Не хватает прав']);
            User::find($data['id'])->delete();
            response()->json(['popup' => 'Удален']);
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
