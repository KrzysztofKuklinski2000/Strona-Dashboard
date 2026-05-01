<?php

namespace App\Controller\Dashboard\Traits;

use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;

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
    public function deleteAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $id = (int)$this->request->getFormParam('postId');
        $this->handleDelete($id);
        $this->setFlash('success', 'Udało się usunąć');
        $this->redirect('/dashboard/' . $this->getModuleName());
    }
}