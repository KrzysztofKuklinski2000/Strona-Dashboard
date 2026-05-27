<?php

namespace App\Controller\Dashboard\Traits;

use App\Core\Request;
use App\DTO\Dashboard\UpdatePostDto;
use App\DTO\DataTransferObjectInterface;
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
    abstract protected function handleUpdate(DataTransferObjectInterface $data): void;

    abstract protected function getDataToUpdate(): DataTransferObjectInterface;

    /**
     * @throws InvalidCsrfTokenException
     */
    #[NoReturn]
    public function updateAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}");
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $data = $this->getDataToUpdate();

        if (!$this->validator->getErrors()) {
            $this->handleUpdate($data);
            $this->sessionManager->setFlash("success", "Udało się edytować");
            $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}");
            return;
        }

        $this->sessionManager->setFlash("warning", $this->validator->getErrors());
        $redirectUrl = "{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}/edit";

        if (isset($data->id) && $data->id !== '') {
            $redirectUrl .= '/' . $data->id;
        }

        $this->redirect($redirectUrl);
    }
}