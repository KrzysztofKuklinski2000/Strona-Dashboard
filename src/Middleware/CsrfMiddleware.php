<?php 
declare(strict_types= 1);
namespace App\Middleware;

use App\Core\Request;
use EasyCSRF\EasyCSRF;

class CsrfMiddleware {

    public function __construct(public EasyCSRF $easyCSRF, public Request $request) {}

    public function verify():void {
        if($this->request->isPost()) {
            $this->easyCSRF->check('csrf_token', $this->request->getFormParam('csrf_token'));
        }
    }

    public function generateToken():string {
        return $this->easyCSRF->generate('csrf_token');
    }
}