<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use App\Core\SessionManager;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use EasyCSRF\EasyCSRF;
use Exception;

/**
 * Generates, stores and verifies reusable CSRF tokens.
 */
readonly class CsrfMiddleware
{
    private const SESSION_TOKEN_PREFIX = 'cached_csrf_token_';

    public function __construct(
        private EasyCSRF $easyCSRF,
        private Request  $request,
        private SessionManager $sessionManager,
        private string   $csrfPrefix,
        private string   $csrfTokenName,
    ) {
    }

    /**
     * Verifies the CSRF token sent with a POST request.
     *
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

    /**
     * Returns an existing session token or creates a new one.
     */
    public function generateToken(string $context = 'public'): string
    {
        $sessionKey = $this->getSessionKey($context);
        $existingToken = $this->sessionManager->get($sessionKey);

        if (is_string($existingToken) && $existingToken !== '') {
            return $existingToken;
        }

        return $this->createToken($context);
    }

    /**
     * Replaces the current token with a newly generated one.
     */
    public function regenerateToken(string $context = 'public'): string
    {
        $this->sessionManager->remove($this->getSessionKey($context));

        return $this->createToken($context);
    }

    /**
     * Generates a token and stores its copy in the application session.
     */
    private function createToken(string $context): string
    {
        $token = $this->easyCSRF->generate(
            $this->getEasyCsrfKey($context)
        );

        $this->sessionManager->set(
            $this->getSessionKey($context),
            $token
        );

        return $token;
    }

    /**
     * Builds the token key used by EasyCSRF.
     */
    private function getEasyCSRFKey(string $context): string
    {
        return $this->csrfPrefix . $context;
    }

    /**
     * Builds the key used to cache the token in the application session.
     */
    private function getSessionKey(string $context): string
    {
        return self::SESSION_TOKEN_PREFIX . $context;
    }
}
