<?php

namespace App\Controller\Dashboard\Traits;


use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;

/**
 * @property Request $request
 * @property CsrfMiddleware $csrfMiddleware
 * @method void redirect(string $to)
 * @method string getModuleName()
 * @method array getDataToChangePostPosition()
 */
trait HasMoveAction
{
    abstract protected function handleMove(array $data): void;

    /**
     * @throws InvalidCsrfTokenException
     */
    public function moveAction(): void
    {
        if ($this->request->isPost()) {
            $this->csrfMiddleware->verify('admin');
            $data = $this->getDataToChangePostPosition();
            $this->handleMove($data);
            $this->redirect("/dashboard/" . $this->getModuleName());
        }
    }
}