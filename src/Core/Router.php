<?php

namespace App\Core;

use App\Core\Request;
use App\Exception\NotFoundException;
use Exception;
use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

class Router
{
    private Dispatcher $dispatcher;

    /**
     * @throws Exception
     */
    public function __construct(string $routesPath, ?Dispatcher $dispatcher = null)
    {
        if ($dispatcher) {
            $this->dispatcher = $dispatcher;
        } else {
            if (!$routesPath || !file_exists($routesPath)) {
                throw new Exception("Brak pliku routingu pod ścieżką: " . $routesPath);
            }
            $routesDefinition = require $routesPath;
            $this->dispatcher = simpleDispatcher($routesDefinition);
        }
    }

    public function dispatch(Request $request): array
    {
        $httpMethod = $request->getMethod();
        $uri = $request->getServerParam('REQUEST_URI', '/');

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new NotFoundException("Strona nie istnieje");

            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new Exception("Metoda HTTP niedozwolona");

            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                $request->setRouteParams($vars);

                return $handler;
        }

        throw new Exception("Błąd routingu");
    }
}