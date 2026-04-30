<?php

namespace App\Factories\ControllerFactories;


use App\Core\ContextController;
use App\Controller\AbstractController;

interface ControllerFactoryInterface {
    public function createController(ContextController $contextController): AbstractController;
}