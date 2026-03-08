<?php

namespace App\Controller;

use App\Core\Request;
use App\Exception\ServiceException;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\SubscribersService;
use App\View;
use EasyCSRF\EasyCSRF;

class PublicSubscribersController extends AbstractController {
    public function __construct(
        Request $request,
        EasyCSRF $easyCSRF,
        View $view,
        private SubscribersService $service,
        private CsrfMiddleware $csrfMiddleware
    ) {
        parent::__construct($request, $easyCSRF, $view);
    }

    public function subscribeAction(): void {
        $this->csrfMiddleware->verify();

        $email = $this->request->validate('email', true, 'email');

        $consent = $this->request->getFormParam('terms_consent');

        if($this->request->getErrors()) {
            $this->setFlash('error', 'Niepoprawny adres email.');
            $this->redirect('/');
            return;
        }

        if (!$consent) {
            $this->setFlash('error', 'Musisz zaakceptować zgodę na przetwarzanie danych.');
            $this->redirect('/');
            return;
        }

        try {
            $this->service->createSubscriber([
                'email' => $email,
                'is_active' => 0
            ]);

            $this->setFlash('success', 'Dziękujemy za zapisanie się!');
            
        }catch(ServiceException $e) { 
            $this->setFlash('error', 'Wystąpił błąd podczas zapisu.');
        }

        $this->redirect('/');
    }

}