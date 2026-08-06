<?php

namespace App\Controller\Dashboard\Traits;


use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\PublishedDto;
use App\Middleware\CsrfMiddleware;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use JetBrains\PhpStorm\NoReturn;

/**
 * @property Request $request
 * @property Validator $validator
 * @property CsrfMiddleware $csrfMiddleware
 * @method void redirect(string $to)
 * @method void setFlash(string $type, $message, string $prefix = 'dashboard')
 * @method string getModuleName()
 */
trait HasPublishedAction
{
    abstract protected function getDataToPublished(): PublishedDto;

    abstract protected function handlePublish(PublishedDto $data): void;

    /**
     * @throws InvalidCsrfTokenException
     */
    #[NoReturn]
    public function publishedAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}");
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $data = $this->getDataToPublished();

        if ($this->validator->getErrors()) {
            $this->sessionManager->setFlash(
                'warning',
                $this->validator->getErrors(),
            );

            $this->redirect(
                "{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}"
            );
            return;
        }

        $this->handlePublish($data);

        $this->sessionManager->setFlash('info', 'Udało się zmienić status');
        $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}");
    }
}
