<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use App\Core\SessionManager;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use EasyCSRF\EasyCSRF;
use Exception;

readonly class CsrfMiddleware
{
    private const SESSION_TOKEN_PREFIX = 'cached_csrf_token_';

    public function __construct(
        private EasyCSRF $easyCSRF,
        private Request  $request,
        private SessionManager $sessionManager,
        private string   $csrfPrefix,
        private string   $csrfTokenName,
    )
    {
    }

    /**
     * @throws InvalidCsrfTokenException
     */
    public function verify(string $context = 'public'): void
    {
        if (!$this->request->isPost()) {
            return;
        }

        $key = $this->getEasyCSRFKey($context);
        $tokenFromForm = $this->request->getFormParam($this->csrfTokenName);

        try {
            $this->easyCSRF->check(
                key: $key,
                token: $tokenFromForm,
                multiple: true
            );
        } catch (Exception $e) {
            throw new InvalidCsrfTokenException($e->getMessage());
        }
    }

    public function generateToken(string $context = 'public'): string
    {
        $sessionKey = $this->getSessionKey($context);
        $existingToken = $this->sessionManager->get($sessionKey);

        if(is_string($existingToken) && $existingToken !== '') {
            return $existingToken;
        }

        return $this->createToken($context);
    }

    public function regenerateToken(string $context = 'public'): string {
        $this->sessionManager->remove($this->getSessionKey($context));

        return $this->createToken($context);
    }

    private function createToken(string $context): string {
        $token = $this->easyCSRF->generate(
            $this->getEasyCsrfKey($context)
        );

        $this->sessionManager->set(
            $this->getSessionKey($context),
            $token
        );

        return $token;
    }

    private function getEasyCSRFKey(string $context): string {
        return $this->csrfPrefix . $context;
    }

    private function getSessionKey(string $context): string {
        return self::SESSION_TOKEN_PREFIX . $context;
    }
}