<?php

namespace App\Controller\Dashboard\Traits;

trait HasPublishedAction
{
    abstract protected function handlePublish(array $data): void;
    public function publishedAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $data = $this->getDataToPublished();
        $this->handlePublish($data);

        $this->setFlash('info', 'Udało się zmienić status', 'dashboard');
        $this->redirect('/dashboard/' . $this->getModuleName());
    }
}