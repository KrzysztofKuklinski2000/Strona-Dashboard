<?php

declare(strict_types=1);

namespace App\Controller\Dashboard\Traits;

use App\Core\Request;
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
trait HasStoreAction
{
    abstract protected function handleCreate(DataTransferObjectInterface $data): void;

    abstract protected function getDataToCreate(): DataTransferObjectInterface;

    /**
     * @throws InvalidCsrfTokenException
     */
    #[NoReturn]
    public function storeAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}");
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $data = $this->getDataToCreate();

        if (!$this->validator->getErrors()) {
            $this->handleCreate($data);
            $this->sessionManager->setFlash("success", "Udało się utworzyć nowy wpis");
            $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}");
            return;
        }

        $oldInput = $this->request->getFormData();
        // musimy usunąć token, żeby nie wypełnił nam formularzu starym tokenem
        unset($oldInput['csrf_token']);


        $this->sessionManager->setFlash(
            type:"warning",
            message: $this->validator->getErrors(),
            context: [
                'oldInput' => $oldInput,
            ]
        );

        $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}/create");
    }
}
