<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use EasyCSRF\EasyCSRF;
use Exception;

readonly class CsrfMiddleware
{

    public function __construct(
        private EasyCSRF $easyCSRF,
        private Request  $request,
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

        $key = "$this->csrfPrefix$context";
        $tokenFromForm = $this->request->getFormParam($this->csrfTokenName);

        try {
            $this->easyCSRF->check($key, $tokenFromForm);
        } catch (Exception $e) {
            throw new InvalidCsrfTokenException($e->getMessage());
        }
    }

    public function generateToken(string $context = 'public'): string
    {
        $key = "$this->csrfPrefix$context";
        return $this->easyCSRF->generate($key);
    }
}