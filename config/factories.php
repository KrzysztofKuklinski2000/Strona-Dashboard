<?php 
declare(strict_types=1);

use App\Controller\AuthController;
use App\Controller\Dashboard\CampController;
use App\Controller\Dashboard\ContactController;
use App\Controller\Dashboard\FeesController;
use App\Controller\Dashboard\GalleryController;
use App\Controller\Dashboard\ImportantPostsController;
use App\Controller\Dashboard\NewsController;
use App\Controller\Dashboard\StartController;
use App\Controller\Dashboard\TimetableController;
use App\Controller\SiteController;
use App\Factories\ControllerFactories\AuthControllerFactory;
use App\Factories\ControllerFactories\Dashboard\CampControllerFactory;
use App\Factories\ControllerFactories\Dashboard\ContactControllerFactory;
use App\Factories\ControllerFactories\Dashboard\FeesControllerFactory;
use App\Factories\ControllerFactories\Dashboard\GalleryControllerFactory;
use App\Factories\ControllerFactories\Dashboard\ImportantPostsControllerFactory;
use App\Factories\ControllerFactories\Dashboard\NewsControllerFactory;
use App\Factories\ControllerFactories\Dashboard\StartControllerFactory;
use App\Factories\ControllerFactories\Dashboard\TimetableControllerFactory;
use App\Factories\ControllerFactories\SiteControllerFactory;


return [
  NewsController::class           => NewsControllerFactory::class,
  ImportantPostsController::class => ImportantPostsControllerFactory::class,
  GalleryController::class        => GalleryControllerFactory::class,
  TimetableController::class      => TimetableControllerFactory::class,
  FeesController::class           => FeesControllerFactory::class,
  CampController::class           => CampControllerFactory::class,
  ContactController::class        => ContactControllerFactory::class,
  StartController::class          => StartControllerFactory::class, // Dawny '_default'


  SiteController::class           => SiteControllerFactory::class,
  AuthController::class           => AuthControllerFactory::class,
];