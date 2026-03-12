<?php 
declare(strict_types= 1);
namespace App\Middleware;

use App\Core\Request;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use EasyCSRF\EasyCSRF;

class CsrfMiddleware {

    public function __construct(public EasyCSRF $easyCSRF, public Request $request) {}

    public function verify(string $context = 'public'): void {
        if (!$this->request->isPost()) {
            return; 
        }   

        $key = 'csrf_token_'.$context;
        $tokenFromForm = $this->request->getFormParam('csrf_token');
        
        try {
            $this->easyCSRF->check($key, $tokenFromForm);
        } catch (\Exception $e) {
            throw new InvalidCsrfTokenException($e->getMessage());
        }
    }

    public function generateToken(string $context = 'public'): string 
    {
        $key = 'csrf_token_' . $context;


        return $this->easyCSRF->generate($key);
    }
}