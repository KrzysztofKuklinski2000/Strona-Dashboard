<?php

declare(strict_types=1);

namespace App\Controller\Dashboard\Traits;

use App\Core\Request;
use App\DTO\Dashboard\ChangePositionDto;
use App\Middleware\CsrfMiddleware;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;

/**
 * @property Request $request
 * @property CsrfMiddleware $csrfMiddleware
 * @method void redirect(string $to)
 * @method string getModuleName()
 */
trait HasMoveAction
{
    abstract protected function handleMove(ChangePositionDto $changePositionDto): void;

    abstract protected function getDataToChangePostPosition(): ChangePositionDto;

    /**
     * @throws InvalidCsrfTokenException
     */
    public function moveAction(): void
    {
        if ($this->request->isPost()) {
            $this->csrfMiddleware->verify('admin');
            $data = $this->getDataToChangePostPosition();

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

            $this->handleMove($data);
            $this->redirect("{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}");
        }
    }
}
