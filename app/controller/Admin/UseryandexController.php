<?php

namespace app\controller\Admin;

use app\action\admin\UserYandexAction;
use app\model\User;
use app\model\UserYandex;
use app\repository\UserYandexRepository;
use app\service\AuthService\AuthService;
use app\service\Response;
use app\service\Router\IRequest;
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
        $content = UserView::getViewByRole($user, AuthService::getUser());

        $this->setVars(compact('content'));

        if ($user = $this->ajax) {
            $user['id'] = AuthService::getUser()->id;
            User::updateOrCreate($user);
            response()->popup('Сохранено');
        }
    }


    public function actionDelete(IRequest $request): void
    {
        if ($data = $this->ajax) {
            if (!AuthService::getUser()->can(['user_delete']))
                response()->json(['popup' => 'Не хватает прав']);
            User::find($data['id'])->delete();
            response()->json(['popup' => 'Удален']);
        }
    }

    public function actionChangeRole(): void
    {
        try {
            $this->repo->changeRole($this->ajax);
            response()->popup('изменено');
        } catch (Throwable $exception) {
            response()->popup('не изменено');
        }
    }
}
