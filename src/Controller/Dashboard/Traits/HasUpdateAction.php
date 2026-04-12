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
trait HasUpdateAction
{
    abstract protected function handleUpdate(array $data): void;

    abstract protected function getDataToUpdate(): array;

    /**
     * @throws InvalidCsrfTokenException
     */
    public function updateAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $data = $this->getDataToUpdate();

        if (!$this->request->getErrors()) {
            $this->handleUpdate($data);
            $this->setFlash("success", "Udało się edytować", 'dashboard');
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->setFlash("warning", $this->request->getErrors(), 'dashboard');
        $redirectUrl = '/dashboard/' . $this->getModuleName() . '/edit';

        if (isset($data['id']) && $data['id'] !== '') {
            $redirectUrl .= '/' . $data['id'];
        }

        $this->redirect($redirectUrl);
    }
}