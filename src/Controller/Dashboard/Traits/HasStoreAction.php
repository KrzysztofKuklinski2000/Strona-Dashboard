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
trait HasStoreAction
{
    abstract protected function handleCreate(array $data): void;

    abstract protected function getDataToCreate(): array;

    /**
     * @throws InvalidCsrfTokenException
     */
    public function storeAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $data = $this->getDataToCreate();

        if (!$this->request->getErrors()) {
            $this->handleCreate($data);
            $this->setFlash("success", "Udało się utworzyć nowy wpis", 'dashboard');
            $this->redirect("/dashboard/" . $this->getModuleName());
            return;
        }

        $this->setFlash("warning", $this->request->getErrors(), 'dashboard');
        $this->redirect('/dashboard/' . $this->getModuleName() . '/create');
    }
}