<?php

namespace app\controller\Admin;

use app\action\admin\UserAction;
use app\attributes\Validate\UserDTO;
use app\attributes\Validate\ValidationException;
use app\model\User;
use app\repository\UserRepository;
use app\service\AuthService\Auth;
use app\service\Response;
use app\service\Router\IRequest;
use app\view\User\UserView;
use Throwable;


class UserController extends AdminscController
{
    public function __construct(
        public UserAction $actions,
        public UserRepository $repo,
        public string         $model = User::class,
    )
    {
        parent::__construct();
    }

    public function actionTable(): void
    {
        $this->showTable();
    }

    public function actionEdit(IRequest $request): void
    {
        $user    = $this->model::find($request->id);
        $catItem = UserView::getViewByRole($user, Auth::getUser());
//        try {
//            $dto = UserDTO::fromArray($user->toArray());
//        } catch (ValidationException $e) {
//            print_r($e->errors());
//        }
        view('admin.components.catalogItem.adminCatalogItem', compact('catItem'));

//        if ($user = $this->ajax) {
//            $user['id'] = $_SESSION['id'];
//            User::updateOrCreate($user);
//            Response::exitWithPopup('Сохранено');
//        }
    }


    public function actionDelete(IRequest $request): void
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
