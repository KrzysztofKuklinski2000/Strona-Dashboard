<?php

namespace App\Controller;

use App\Core\Request;
use App\Exception\ServiceException;
use App\Middleware\CsrfMiddleware;
use App\Notification\Notifier;
use App\Service\Dashboard\SubscribersService;
use App\View;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use Random\RandomException;

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

    /**
     * @throws InvalidCsrfTokenException
     * @throws RandomException
     */
    public function subscribeAction(): void {
        $this->csrfMiddleware->verify('public');

        $email = $this->request->validate('email', true, 'email');

        $consent = $this->request->getFormParam('terms_consent');

        if($this->request->getErrors()) {
            $this->setFlash('warning', 'Niepoprawny adres email.', 'public');
            $this->redirect('/');
            return;
        }

        if (!$consent) {
            $this->setFlash('warning', 'Musisz zaakceptować zgodę na przetwarzanie danych.', 'public');
            $this->redirect('/');
            return;
        }

        try {
            $token = $this->service->createSubscriber([
                'email' => $email,
                'is_active' => 0
            ]);

            $this->notifier->sendConfirmationEmail($email, $token);

            $this->setFlash('success', 'Dziękujemy za zapisanie się!', 'public');
            
        }catch(ServiceException $e) { 
            $this->setFlash('warning', $e->getMessage(), 'public');
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
            $this->setFlash('success', 'Subskrypcja została potwierdzona! Oss!', 'public');
        } catch (\Exception $e) {
            $this->setFlash('warning', 'Link aktywacyjny jest nieprawidłowy.', 'public');
        }

        $this->redirect('/');
    }

    public function unsubscribeAction(): void {
        $token = $this->request->getQueryParam('token');

        if (!$token) {
            $this->setFlash('warning', 'Brak klucza wypisania.', 'public');
            $this->redirect('/');
            return;
        }

        try {
            $this->service->unsubscribe($token);
            $this->setFlash('success', 'Twoje dane zostały usunięte. Nie będziesz już otrzymywać powiadomień.', 'public');
        } catch (ServiceException $e) {
            $this->setFlash('warning', 'Nie udało się przetworzyć prośby o wypisanie.', 'public');
        }

        $this->redirect('/');
    }
}