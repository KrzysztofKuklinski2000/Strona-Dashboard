<?php

namespace App\Controller\Dashboard\Traits;

trait HasMoveAction
{
    abstract protected function handleMove(array $data): void;
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