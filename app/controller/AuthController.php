<?php

namespace app\controller;

//use app\Actions\AuthAction;
use app\core\Auth;
use app\core\Mail\PHPMail;
use app\core\Request;
use app\core\Response;
use app\model\User;
use app\Repository\UserRepository;
use app\Services\TelegramBot\TelegramBot;
use app\view\User\UserView;
use JetBrains\PhpStorm\NoReturn;

class AuthController extends AppController
{
   protected PHPMail $mailer;
   protected UserRepository $actions;
   protected UserRepository $userRepository;

   public function __construct()
   {
      parent::__construct();
//		$bot = new TelegramBot();
//		$bot->send('Что так');

      $this->userRepository = new UserRepository();
      $this->actions = $this->userRepository;
      $this->mailer = new PHPMail('env');
      if (!$this->ajax) {
         $this->assets->setAuth();
      }
   }

   public function actionRegister(): void
   {
      $req = $this->ajax;
      if ($req) {
         if (!$req['email']) exit('empty email');

         if ($this->userRepository->findByMail($req['email'])) Response::exitWithMsg('mail exists');

         if (!$req['password']) exit('empty password');

         $user = $this->userRepository->createUser($req);
         if ($user) {
            $userMessage = "Пользователь создан";
         } else {
            $userMessage = "Пользователь не создан";
         }

         $sent = $this->mailer->sendRegistrationMail($user);

         Response::exitJson(['message' => 'confirmed', 'popup' => $userMessage . "\n" . $sent]);
      }
   }

   public function actionLogin(): void
   {
      if ($data = $this->ajax) {

         $req = new Request();
         $errors = $req->checkLoginCredentials($data);
         if ($errors)
            Response::exitJson(['errors' => $errors, 'popup' => $errors]);
         $user = $this->userRepository->findByMail($data['email'])->toArray();

         if (!$user['confirm'])
            Response::exitWithSuccess('Зайдите на почту чтобы подтвердить регистрацию');
         if ($user['password'] !== $this->userRepository->preparePassword($data['password'])) {
            if (!Auth::isSU($user)) {
               Response::exitWithError('Не верный email или пароль');// Если данные правильные, запоминаем пользователя (в сессию)
            }
         }
         Auth::setAuth($user);

//         $this->user = $user;
         if (User::can($user, ['role_employee'])) {
            Response::exitJson(['role' => 'employee', 'id' => $user['id']]);
         } else {
            Response::exitJson(['role' => 'user', 'id' => $user['id']]);
         }
      }
      $this->view = 'login';
   }


   public function actionProfile(): void
   {
      $userArr = Auth::getUser();
      $user = User::find($userArr['id']);

      if (User::can($userArr, ['role_employee'])) {
         if (User::can($userArr, ['role_admin'])) {
            $item = UserView::admin($user);
         } else {
            $item = UserView::employee($user);
         }

         $this->assets->unsetJs('auth.js');
         $this->assets->unsetCss('auth.css');

      } else {
//         $this-layout = 'vitex';
         $item = UserView::guest($user);;
      }

      $this->set(compact('item'));
   }

   public function actionChangePassword(): void
   {
      if ($data = $this->ajax) {
         if (!$data['old_password'] || !$data['new_password'])
            Response::exitWithError('Заполните старый и новый пароль');

         $old_password = $this->actions->preparePassword($data['old_password']);

         $user = User::where('password', $old_password)
            ->get()->toArray();

         if ($user) {
            $user = $user[0];
            $newPassword = $this->actions->preparePassword($data['new_password']);
            $res = User::where('id', $user['id'])
               ->update(['password' => $newPassword]);
            if ($res) {

               Response::exitWithSuccess('Пароль поменeн');
            } else {
               Response::exitWithMsg('Что-то пошло не так (');
            }
         } else {

            Response::exitWithError('Не правильный старый пароль (');
         }
      }
   }

   public function actionReturnpass(): void
   {
      if ($data = $this->ajax) {
         $_SESSION['id'] = '';
         $user = $this->userRepository->returnPassword($data);

         if ($user) {
            $password = $this->actions->randomPassword();
            $newPassword = $this->actions->preparePassword($password);
            User::where('id', $user['id'])
               ->update(['password' => $newPassword]);

            $this->mailer->returnPassword($data);
            Response::exitWithSuccess('Новый пароль проверьте на почте');
         } else {
            Response::exitWithError("Пользователя с таким e-mail нет");
         }
      }
   }


   #[NoReturn] public function actionLogout(): void
   {
      if (isset($_COOKIE[session_name()])) {
         setcookie(session_name(), '', time() - 86400, '/');
      }
      unset($_SESSION);
      header("Location: /");
      Response::exitJson(["response"=>'logout']);
   }


   public function actionConfirm(): void
   {
      $hash = $this->route->id;

      if (!$hash) header('Location:/');
      $user = User::where('hash', $hash)->first();

      if (!$user) {
         header('Location:/auth/login');
         exit();
      }

      $user['confirm'] = "1";
      Auth::setAuth($user->toArray());
      if ($user->update()) {
         header('Location:/auth/success');
         Response::exitWithPopup('"Вы успешно подтвердили свой E-mail."');
      }
   }


   public static function user(): array|bool
   {
      if (isset($_SESSION['id']) && $_SESSION['id']) return false;

      $user = User::where('id', $_SESSION['id'])->first();
      if (!$user) return false;

      return $user->toArray();

   }

   public function actionUnautherized(): void
   {
      $view = 'unautherized';
   }

   public function actionUnsubscribe(): void
   {
      $view = 'unautherized';
   }
}
