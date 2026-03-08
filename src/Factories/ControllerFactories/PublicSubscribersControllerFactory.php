<?php
namespace App\Factories\ControllerFactories;

use App\Controller\PublicSubscribersController;
use App\Factories\ServiceFactories\Dashboard\SubscribersServiceFactory;
use App\Middleware\CsrfMiddleware;
use App\Core\Request;
use App\Factories\ServiceFactories\Notification\NotifierFactory;
use App\View;
use EasyCSRF\EasyCSRF;
use PDO;

class PublicSubscribersControllerFactory {
    private SubscribersServiceFactory $serviceFactory;

    public function __construct(private PDO $pdo) {
        $this->serviceFactory = new SubscribersServiceFactory($this->pdo);
    }

    public function createController(Request $request, EasyCSRF $easyCSRF): PublicSubscribersController {
        $service = $this->serviceFactory->createService();
        $csrfMiddleware = new CsrfMiddleware($easyCSRF, $request);
        $view = new View();
        $notifierFactory = new NotifierFactory($this->pdo);
        $notifier = $notifierFactory->createService();

        return new PublicSubscribersController(
            $request,
            $easyCSRF,
            $view,
            $service,
            $csrfMiddleware,
            $notifier
        );
    }
}