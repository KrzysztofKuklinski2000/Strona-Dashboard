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
trait HasStoreAction
{
    abstract protected function handleCreate(array $data): void;

    abstract protected function getDataToCreate(): array;

    /**
     * @throws InvalidCsrfTokenException
     */
    #[NoReturn]
    public function storeAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $data = $this->getDataToCreate();

        if (!$this->validator->getErrors()) {
            $this->handleCreate($data);
            $this->setFlash("success", "Udało się utworzyć nowy wpis");
            $this->redirect("/dashboard/" . $this->getModuleName());
            return;
        }

        $this->setFlash("warning", $this->validator->getErrors());
        $this->redirect('/dashboard/' . $this->getModuleName() . '/create');
    }
}