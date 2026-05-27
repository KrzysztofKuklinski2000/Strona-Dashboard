<?php

namespace App\Controller\Dashboard\Traits;

use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use JetBrains\PhpStorm\NoReturn;

/**
 * @property Request $request
 * @property CsrfMiddleware $csrfMiddleware
 * @method void redirect(string $to)
 * @method void setFlash(string $type, $message, string $prefix = 'dashboard')
 * @method string getModuleName()
 */

trait HasDeleteAction
{
    abstract protected function handleDelete(int $id): void;

    /**
     * @throws InvalidCsrfTokenException
     */
    #[NoReturn]
    public function deleteAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}");
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $id = (int) $this->request->getFormParam('postId');
        $this->handleDelete($id);
        $this->sessionManager->setFlash('success', 'Udało się usunąć');
        $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}");
    }
}