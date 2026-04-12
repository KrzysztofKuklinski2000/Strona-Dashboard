<?php

namespace App\Controller\Dashboard\Traits;

trait HasUpdateAction
{
    abstract protected function handleUpdate(array $data): void;

    abstract protected function getDataToUpdate(): array;

    public function updateAction(): void
    {
        if (!$this->request->isPost()) {
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->csrfMiddleware->verify('admin');
        $data = $this->getDataToUpdate();

        if (!$this->request->getErrors()) {
            $this->handleUpdate($data);
            $this->setFlash("success", "Udało się edytować", 'dashboard');
            $this->redirect('/dashboard/' . $this->getModuleName());
            return;
        }

        $this->setFlash("warning", $this->request->getErrors(), 'dashboard');
        $redirectUrl = '/dashboard/' . $this->getModuleName() . '/edit';

        if (isset($data['id']) && $data['id'] !== '') {
            $redirectUrl .= '/' . $data['id'];
        }

        $this->redirect($redirectUrl);
    }
}