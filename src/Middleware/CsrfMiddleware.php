<?php 
declare(strict_types= 1);
namespace App\Middleware;

use App\Core\Request;
use EasyCSRF\EasyCSRF;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;

class CsrfMiddleware {

    public function __construct(public EasyCSRF $easyCSRF, public Request $request) {}

    public function verify():void {
        if($this->request->isPost()) {
            try {
                $this->easyCSRF->check('csrf_token', $this->request->getFormParam('csrf_token'));
            } catch (InvalidCsrfTokenException $e) {
                header('Location: /?dashboard=start&error=csrf');
                exit;
            }
        }
    }

    public function generateToken():string {
        return $this->easyCSRF->generate('csrf_token');
    }
}