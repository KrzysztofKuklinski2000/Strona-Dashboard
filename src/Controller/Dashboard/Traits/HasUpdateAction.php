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
trait HasUpdateAction
{
    abstract protected function handleUpdate(array $data): void;

    abstract protected function getDataToUpdate(): array;

    /**
     * @throws InvalidCsrfTokenException
     */
    #[NoReturn]
    public function updateAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $data = $this->getDataToUpdate();

        if (!$this->validator->getErrors()) {
            $this->handleUpdate($data);
            $this->setFlash("success", "Udało się edytować");
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->setFlash("warning", $this->validator->getErrors());
        $redirectUrl = '/dashboard/' . $this->getModuleName() . '/edit';

        if (isset($data['id']) && $data['id'] !== '') {
            $redirectUrl .= '/' . $data['id'];
        }

        $this->redirect($redirectUrl);
    }
}