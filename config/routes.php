<?php

use App\Controller\Dashboard\CampController;
use App\Controller\Dashboard\FeesController;
use App\Controller\SiteController;
use FastRoute\RouteCollector;

return function (RouteCollector $r) {
  $r->get('/', [SiteController::class, 'indexAction']);
  $r->get('/skladki', [SiteController::class, 'feesAction']);


  $r->get('/dashboard/camp', [CampController::class, 'indexAction']);
  $r->get('/dashboard/camp/edit', [CampController::class, 'editAction']);
  $r->post('/dashboard/camp/edit', [CampController::class, 'handleUpdate']);

  $r->get('/dashboard/fees', [FeesController::class, 'indexAction']);
  $r->get('/dashboard/fees/edit', [FeesController::class, 'editAction']);
  $r->post('/dashboard/fees/edit', [FeesController::class, 'handleUpdate']);

  
};