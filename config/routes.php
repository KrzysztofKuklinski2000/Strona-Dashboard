<?php

use App\Controller\AuthController;
use App\Controller\Dashboard\CampController;
use App\Controller\Dashboard\ContactController;
use App\Controller\Dashboard\FeesController;
use App\Controller\Dashboard\GalleryController;
use App\Controller\Dashboard\ImportantPostsController;
use App\Controller\Dashboard\NewsController;
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

  $r->get('/dashboard/fees', [FeesController::class, 'editAction']);
  $r->get('/dashboard/fees/edit', [FeesController::class, 'editAction']);
  $r->post('/dashboard/fees/update', [FeesController::class, 'updateAction']);

  $r->get('/dashboard/gallery', [GalleryController::class, 'indexAction']);
  $r->post('/dashboard/gallery/move', [GalleryController::class, 'moveAction']);
  $r->get('/dashboard/gallery/create', [GalleryController::class, 'createAction']);
  $r->post('/dashboard/gallery/store', [GalleryController::class, 'storeAction']);
  $r->get('/dashboard/gallery/edit/{id:\d+}', [GalleryController::class, 'editAction']);
  $r->post('/dashboard/gallery/update/{id:\d+}', [GalleryController::class, 'updateAction']);
  $r->get('/dashboard/gallery/show/{id:\d+}', [GalleryController::class, 'showAction']);
  $r->post('/dashboard/gallery/published/{id:\d+}', [GalleryController::class, 'publishedAction']);
  $r->get('/dashboard/gallery/confirmDelete/{id:\d+}', [GalleryController::class, 'confirmDeleteAction']);
  $r->post('/dashboard/gallery/delete/{id:\d+}', [GalleryController::class, 'deleteAction']);

  $r->get('/dashboard/important_posts', [ImportantPostsController::class, 'indexAction']);
  $r->post('/dashboard/important_posts/move', [ImportantPostsController::class, 'moveAction']);
  $r->get('/dashboard/important_posts/create', [ImportantPostsController::class, 'createAction']);
  $r->post('/dashboard/important_posts/store', [ImportantPostsController::class, 'storeAction']);
  $r->get('/dashboard/important_posts/edit/{id:\d+}', [ImportantPostsController::class, 'editAction']);
  $r->post('/dashboard/important_posts/update/{id:\d+}', [ImportantPostsController::class, 'updateAction']);
  $r->get('/dashboard/important_posts/show/{id:\d+}', [ImportantPostsController::class, 'showAction']);
  $r->post('/dashboard/important_posts/published/{id:\d+}', [ImportantPostsController::class, 'publishedAction']);
  $r->get('/dashboard/important_posts/confirmDelete/{id:\d+}', [ImportantPostsController::class,'confirmDeleteAction']);
  $r->post('/dashboard/important_posts/delete/{id:\d+}', [ImportantPostsController::class, 'deleteAction']);

  $r->get('/dashboard/news', [NewsController::class, 'indexAction']);
  $r->post('/dashboard/news/move', [NewsController::class, 'moveAction']);
  $r->get('/dashboard/news/create', [NewsController::class, 'createAction']);
  $r->post('/dashboard/news/store', [NewsController::class, 'storeAction']);
  $r->get('/dashboard/news/edit/{id:\d+}', [NewsController::class, 'editAction']);
  $r->post('/dashboard/news/update/{id:\d+}', [NewsController::class, 'updateAction']);
  $r->get('/dashboard/news/show/{id:\d+}', [NewsController::class, 'showAction']);
  $r->post('/dashboard/news/published/{id:\d+}', [NewsController::class, 'publishedAction']);
  $r->get('/dashboard/news/confirmDelete/{id:\d+}', [NewsController::class, 'confirmDeleteAction']);
  $r->post('/dashboard/news/delete/{id:\d+}', [NewsController::class, 'deleteAction']);

};