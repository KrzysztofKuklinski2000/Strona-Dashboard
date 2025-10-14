<?php 
declare(strict_types=1);

use App\Factories\ControllerFactories\AuthControllerFactory;
use App\Factories\ControllerFactories\SiteControllerFactory;
use App\Factories\ControllerFactories\Dashboard\CampControllerFactory;
use App\Factories\ControllerFactories\Dashboard\FeesControllerFactory;
use App\Factories\ControllerFactories\Dashboard\NewsControllerFactory;
use App\Factories\ControllerFactories\Dashboard\StartControllerFactory;
use App\Factories\ControllerFactories\Dashboard\ContactControllerFactory;
use App\Factories\ControllerFactories\Dashboard\GalleryControllerFactory;
use App\Factories\ControllerFactories\Dashboard\TimetableControllerFactory;
use App\Factories\ControllerFactories\Dashboard\ImportantPostsControllerFactory;


return [
  'dashboard' => [
    'news' => NewsControllerFactory::class,
    'important_posts' => ImportantPostsControllerFactory::class,
    'gallery' => GalleryControllerFactory::class,
    'timetable' => TimetableControllerFactory::class,
    'fees' => FeesControllerFactory::class,
    'camp' => CampControllerFactory::class,
    'contact' => ContactControllerFactory::class,
    '_default' => StartControllerFactory::class,
  ],
  'site' => SiteControllerFactory::class,
  'auth' => AuthControllerFactory::class,
];