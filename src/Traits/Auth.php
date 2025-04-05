<?php 
declare(strict_types=1);
namespace App\Traits;

trait Auth {
  protected function loginDashboardAction(): void
  {
    if (!empty($this->request->getSession('user'))) header('location: /?dashboard=start');
    $errors = [];
    if ($this->request->hasPost()) {
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
    }
    $this->view->renderDashboardView(['page' => 'login', 'messages' => $errors]);
  }

  protected function logoutDashboardAction()
  {
    if (empty($this->request->getSession('user'))) header('location: /?dashboard=start');
    session_destroy();
    header("Location: /?dashboard=start&subpage=login");
  }
}
