<?php

namespace App\Controller\Dashboard\Traits;


use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;

/**
 * @property Request $request
 * @property CsrfMiddleware $csrfMiddleware
 * @method void redirect(string $to)
 * @method void setFlash(string $type, $message, string $prefix = 'dashboard')
 * @method string getModuleName()
 * @method array getDataToPublished()
 */
trait HasPublishedAction
{
    abstract protected function handlePublish(array $data): void;

    /**
     * @throws InvalidCsrfTokenException
     */
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