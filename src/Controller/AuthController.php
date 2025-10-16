<?php 
declare(strict_types=1);
namespace App\Controller;

use App\Exception\ServiceException;
use App\Middleware\CsrfMiddleware;
use App\Core\Request;
use App\Service\AuthService;
use EasyCSRF\EasyCSRF;
use Throwable;

class AuthController extends AbstractController {

  public CsrfMiddleware $csrfMiddleware;

  public function __construct(Request $request, public AuthService $authService, EasyCSRF $easyCSRF) {

    parent::__construct($request, $easyCSRF);
    $this->csrfMiddleware = new \App\Middleware\CsrfMiddleware($easyCSRF, $this->request);
    
  }

  public function indexAction(): void {
    if (!empty($this->request->getSession('user'))) $this->redirect('/?dashboard=start');

    $this->redirect('/?auth&action=login');
  }

  public function loginAction(): void {
    if (!empty($this->request->getSession('user'))) $this->redirect('/?dashboard=start');
    $errors = [];

    if ($this->request->hasPost()) {
      try {
				$this->csrfMiddleware->verify();
        $login = $this->request->postParam('login');
        $password = $this->request->postParam('password');

        $errors = $this->authService->login($login, $password);

        if (empty($errors)) {
            $this->setFlash('info', 'Udało się zalogować');
            $this->redirect('/?dashboard=start');
        }

        }catch(ServiceException $e) {
          throw new ServiceException('Nie udało się zalogować', 400, $e);
        }catch (Throwable $e) {
          throw new ServiceException('Wystąpił nieznany błąd ', 500, $e);
        }
    }
    $this->view->renderDashboardView(['page' => 'login', 'messages' => $errors, 'csrf_token' => $this->csrfMiddleware->generateToken()]);
  }

  public function logoutAction(){
    if (empty($this->request->getSession('user'))) $this->redirect('/?dashboard=start');
    $this->request->removeSession('user');
    $this->redirect('/?auth&action=login');
  }
}