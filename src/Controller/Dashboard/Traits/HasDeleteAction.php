<?php

namespace App\Controller\Dashboard\Traits;

trait HasDeleteAction
{
    abstract protected function handleDelete(int $id): void;

    public function deleteAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $id = (int)$this->request->getFormParam('postId');
        $this->handleDelete($id);
        $this->setFlash('success', 'Udało się usunąć', 'dashboard');
        $this->redirect('/dashboard/' . $this->getModuleName());
    }
}