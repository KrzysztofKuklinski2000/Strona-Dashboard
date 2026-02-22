<?php

use App\Controller\AuthController;
use App\Controller\Dashboard\CampController;
use App\Controller\Dashboard\ContactController;
use App\Controller\Dashboard\FeesController;
use App\Controller\SiteController;
use FastRoute\RouteCollector;

return function (RouteCollector $r) {
  $r->get('/', [SiteController::class, 'indexAction']);
  $r->get('/aktualnosci', [SiteController::class, 'newsAction']);
  $r->get('/aktualnosci/{page:\d+}', [SiteController::class, 'newsAction']);
  $r->get('/grafik', [SiteController::class, 'timetableAction']);
  $r->get('/galeria', [SiteController::class, 'galleryAction']);
  $r->get('/galeria/{category}', [SiteController::class, 'galleryAction']);
  $r->get('/obozy', [SiteController::class, 'campAction']);
  $r->get('/skladki', [SiteController::class, 'feesAction']);
  $r->get('/zapisy', [SiteController::class, 'registrationAction']);
  $r->get('/kontakt', [SiteController::class, 'contactAction']);
  $r->get('/status', [SiteController::class, 'statuteAction']);
  $r->get('/oyama', [SiteController::class, 'oyamaAction']);
  $r->get('/dojo-oath', [SiteController::class, 'dojoOathAction']);
  $r->get('/wymagania-egzaminacyjne', [SiteController::class, 'requirementsAction']);

  $r->get('/auth/login', [AuthController::class, 'loginAction']);
  $r->post('/auth/login', [AuthController::class, 'loginAction']);
  $r->get('/auth/logout', [AuthController::class, 'logoutAction']);

  $r->get('/dashboard/camp', [CampController::class, 'editAction']);
  $r->get('/dashboard/camp/edit', [CampController::class, 'editAction']);
  $r->post('/dashboard/camp/update', [CampController::class, 'updateAction']);

  $r->get('/dashboard/contact', [ContactController::class, 'editAction']);
  $r->get('/dashboard/contact/edit', [ContactController::class, 'editAction']);
  $r->post('/dashboard/contact/update', [ContactController::class, 'updateAction']);

  $r->get('/dashboard/fees', [FeesController::class, 'indexAction']);
  $r->get('/dashboard/fees/edit', [FeesController::class, 'editAction']);
  $r->post('/dashboard/fees/edit', [FeesController::class, 'handleUpdate']);

  
};