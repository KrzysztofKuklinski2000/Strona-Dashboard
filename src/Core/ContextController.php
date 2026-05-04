<?php

namespace App\Core;

use App\Middleware\CsrfMiddleware;
use App\View;

readonly class ContextController
{
    public function __construct(
        public Request        $request,
        public View           $view,
        public CsrfMiddleware $csrfMiddleware,
        public Validator      $validator,
        public Config         $config,
    )
    {
    }
}