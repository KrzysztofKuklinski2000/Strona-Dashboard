<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\ContextController;
use App\Security\Authenticator;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use JetBrains\PhpStorm\NoReturn;
use Throwable;
use App\Exception\ServiceException;

class AuthController extends AbstractController
{

    public function __construct(
        private readonly Authenticator $authenticator,
        ContextController              $contextController,
    )
    {
        parent::__construct($contextController);
    }

    /**
     * @throws ServiceException
     */
    public function loginAction(): void
    {
        if (!empty($this->sessionManager->get('user'))) {
            $this->redirect($this->contextController->config->getDashboardRoute());
            return;
        }

        $errors = [];

        if ($this->request->hasPost()) {
            try {
                $this->csrfMiddleware->verify('admin');
                $login = (string) $this->request->getFormParam('login');
                $password = (string) $this->request->getFormParam('password');

                if (empty($login) || empty($password)) {
                    $errors['general'] = "Podaj login i hasło.";
                } else {
                    $userDto = $this->authenticator->authenticate($login, $password);

                    $this->sessionManager->regenerate();
                    $this->sessionManager->set('user', $userDto);
                    $this->sessionManager->setFlash('info', 'Udało się zalogować');

                    $this->redirect($this->contextController->config->getDashboardRoute());
                    return;
                }

            } catch (ServiceException $e) {
                $errors['general'] = $e->getMessage();
            } catch (Throwable $e) {
                $errors['general'] = 'Wystąpił nieznany błąd serwera.';
            }
        }
        $this->view->renderDashboardView([
            'page' => 'login',
            'messages' => $errors,
            'csrf_token' => $this->csrfMiddleware->generateToken('admin')
        ]);
    }

    /**
     * @throws InvalidCsrfTokenException
     */
    #[NoReturn]
    public function logoutAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect($this->contextController->config->getDashboardRoute());
        }

        $this->csrfMiddleware->verify('admin');
        $this->sessionManager->destroy();

        $this->redirect($this->contextController->config->getLoginRoute());
    }
}