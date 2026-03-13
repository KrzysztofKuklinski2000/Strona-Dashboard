<?php 
declare(strict_types=1);
namespace App\Controller;

use App\View;
use Throwable;
use App\Core\Request;
use App\Service\AuthService;
use App\Middleware\CsrfMiddleware;
use App\Exception\ServiceException;

class AuthController extends AbstractController {

  public function __construct(
    Request $request, 
    public AuthService $authService, 
    View $view, 
    public CsrfMiddleware $csrfMiddleware
  ) {

    parent::__construct($request, $view);
  }

  public function loginAction(): void {
    if (!empty($this->request->getSession('user'))) {
      $this->redirect('/dashboard');
      return;
    }

    $errors = [];

    if ($this->request->hasPost()) {
      try {
				$this->csrfMiddleware->verify('admin');
        $login = $this->request->getFormParam('login');
        $password = $this->request->getFormParam('password');

        $errors = $this->authService->login($login, $password);

        if (empty($errors)) {
            $this->setFlash('info', 'Udało się zalogować', 'dashboard');
            $this->redirect('/dashboard');
        }

        }catch(ServiceException $e) {
          throw new ServiceException('Nie udało się zalogować', 400, $e);
        }catch (Throwable $e) {
          throw new ServiceException('Wystąpił nieznany błąd ', 500, $e);
        }
    }
    $this->view->renderDashboardView(['page' => 'login', 'messages' => $errors, 'csrf_token' => $this->csrfMiddleware->generateToken('admin')]);
  }

  public function logoutAction(){
    $this->request->removeSession('user');
    $this->redirect('/auth/login');
  }
}