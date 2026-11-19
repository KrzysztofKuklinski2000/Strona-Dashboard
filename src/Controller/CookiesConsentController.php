<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\ContextController;
use App\DTO\Auth\UserDto;
use App\Service\Analytics\CookieConsentManager;
use App\Service\Analytics\UniqueVisitorTracker;
use App\Service\Analytics\VisitorCookieManager;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use JsonException;

class CookiesConsentController extends AbstractController
{
    public function __construct(
        private CookieConsentManager $cookieConsentManager,
        private VisitorCookieManager $visitorCookieManager,
        private UniqueVisitorTracker $uniqueVisitorTracker,
        ContextController $contextController,
    ) {
        parent::__construct($contextController);
    }

    /**
     * @throws JsonException
     */
    public function saveAction(): void {
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-store, private');

        try {
            $this->csrfMiddleware->verify();
        }catch (InvalidCsrfTokenException) {
            http_response_code(403);

            echo json_encode([
                'success' => false,
                'message' => 'Formularz wygasł. Odśwież stronę i spróbuj ponownie.',
            ], JSON_THROW_ON_ERROR);

            return;
        }

        $decision = $this->request->getFormParam('analytics_consent');

        if(!in_array($decision, ['accepted', 'rejected'], true)) {
            http_response_code(400);

            echo json_encode([
                'success' => false,
                'message' => 'Nieprawidłowy wybór ustawień cookies.',
            ], JSON_THROW_ON_ERROR);

            return;
        }

        $decisionSaved = $this->cookieConsentManager->saveDecision($decision);

        $visitorDeleted = true;
        $visitorId = null;

        if($decisionSaved && $decision === 'rejected') {
            $currentVisitorId = $this->visitorCookieManager->getExisting($this->request);

            $visitorDeleted = $this->uniqueVisitorTracker->deleteHistory($currentVisitorId)
                && $this->visitorCookieManager->delete();
        }

        if ($decisionSaved && $decision === 'accepted') {
            $visitorId = $this->visitorCookieManager->getOrCreate($this->request, true);
        }

        if (!$decisionSaved || !$visitorDeleted || ($decision === 'accepted' && $visitorId === null)) {
            http_response_code(500);

            echo json_encode([
                'success' => false,
                'message' => 'Nie udało się zapisać ustawień cookies. Spróbuj ponownie.',
            ], JSON_THROW_ON_ERROR);

            return;
        }

        $pagePath = $this->request->getFormParam('page_path');

        if ($decision === 'accepted' && is_string($pagePath)) {
            $this->uniqueVisitorTracker->trackAfterConsent(
                $this->request,
                $pagePath,
                isAdministrator: $this->sessionManager->get('user') instanceof UserDto,
                visitorId: $visitorId,
            );
        }

        http_response_code(200);

        echo json_encode([
            'success' => true,
            'decision' => $decision,
        ], JSON_THROW_ON_ERROR);
    }

}
