<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\ContextController;
use App\Service\Analytics\CookieConsentManager;
use App\Service\Analytics\VisitorCookieManager;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use JsonException;

class CookiesConsentController extends AbstractController
{
    public function __construct(
        private CookieConsentManager $cookieConsentManager,
        private VisitorCookieManager $visitorCookieManager,
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

        $settingsSaved = $this->cookieConsentManager->saveDecision($decision);
        if ($settingsSaved) {
            $settingsSaved = $decision === 'accepted'
                ? $this->visitorCookieManager->getOrCreate($this->request, true) !== null
                : $this->visitorCookieManager->delete();
        }

        if (!$settingsSaved) {
            http_response_code(500);

            echo json_encode([
                'success' => false,
                'message' => 'Nie udało się zapisać ustawień cookies. Spróbuj ponownie.',
            ], JSON_THROW_ON_ERROR);

            return;
        }

        http_response_code(200);

        echo json_encode([
            'success' => true,
            'decision' => $decision,
        ], JSON_THROW_ON_ERROR);
    }

}
