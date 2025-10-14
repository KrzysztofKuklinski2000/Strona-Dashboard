<?php

namespace App\Factories\ControllerFactories;


use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Controller\AbstractController;

interface ControllerFactoryInterface {
    public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController;
}