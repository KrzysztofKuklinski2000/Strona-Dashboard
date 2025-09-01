<?php 
declare(strict_types=1);
namespace App\Controller;

use App\Model\UserModel;
use App\Request;
use EasyCSRF\EasyCSRF;

class AuthController extends AbstractController {

  public UserModel $userModel;

  public function __construct(Request $request, UserModel $userModel, EasyCSRF $easyCSRF)
  {
    parent::__construct($request, $easyCSRF);
    $this->userModel = $userModel;
  }

  public function startAction(): void {
    if (!empty($this->request->getSession('user'))) header('location: /?dashboard=start');
    header('location: /?auth=login');
    exit;
  }

  public function loginAction(): void {
    if (!empty($this->request->getSession('user'))) header('location: /?dashboard=start');

    $errors = [];

    if ($this->request->hasPost()) {
      try {
				$this->easyCSRF->check('csrf_token', $this->request->postParam('csrf_token'));
        $login = $this->request->postParam('login');
        $password = $this->request->postParam('password');
        $user = $this->userModel->getUser($login);

        if ($user) {
          if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('location: /?dashboard=start');

          } else {
            $errors['password'] = "Nie poprawne hasło";

          }
        } else {
          $errors['login'] = "Nie poprawny login";
        }
        } catch (\EasyCSRF\Exceptions\InvalidCsrfTokenException $e) {
          $this->redirect("/?auth=start&error=csrf");
        }

    }
    $this->view->renderDashboardView(['page' => 'login', 'messages' => $errors, 'csrf_token' => $this->easyCSRF->generate('csrf_token')]);
  }

  public function logoutAction()
  {
    if (empty($this->request->getSession('user'))) header('location: /?dashboard=start');
    session_destroy();
    header("Location: /?auth=start");
  }
}