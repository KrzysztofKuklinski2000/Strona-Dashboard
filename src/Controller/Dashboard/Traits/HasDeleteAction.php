<?php

declare(strict_types=1);

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

    abstract protected function getDataToDelete(): ?int;

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
        $id = $this->getDataToDelete();

        if ($id === null) {
            $this->sessionManager->setFlash(
                'warning',
                'Nieprawidłowy identyfikator wpisu.'
            );

            $this->redirect(
                "{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}"
            );
        }


        $this->handleDelete($id);
        $this->sessionManager->setFlash('success', 'Udało się usunąć');
        $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}");
    }
}
