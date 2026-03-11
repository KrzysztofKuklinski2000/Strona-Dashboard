<?php

namespace App\Controller;

use App\Core\Request;
use App\Exception\ServiceException;
use App\Middleware\CsrfMiddleware;
use App\Notification\Notifier;
use App\Service\Dashboard\SubscribersService;
use App\View;

class PublicSubscribersController extends AbstractController {
    public function __construct(
        Request $request,
        View $view,
        private SubscribersService $service,
        private CsrfMiddleware $csrfMiddleware,
        private Notifier $notifier
    ) {
        parent::__construct($request, $view);
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
            $token = $this->service->createSubscriber([
                'email' => $email,
                'is_active' => 0
            ]);

            $this->notifier->sendConfirmationEmail($email, $token);

            $this->setFlash('success', 'Dziękujemy za zapisanie się!');
            
        }catch(ServiceException $e) { 
            $this->setFlash('error', 'Wystąpił błąd podczas zapisu.');
        }

        $this->redirect('/');
    }


    public function confirmAction(): void {
        $token = $this->request->getQueryParam('token');
        
        if (!$token) {
            $this->redirect('/?error=invalid_token');
            return;
        }

        try {
            
            $this->service->activateSubscriber($token);
            $this->setFlash('success', 'Subskrypcja została potwierdzona! Oss!');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Link aktywacyjny jest nieprawidłowy.');
        }

        $this->redirect('/');
    }
}