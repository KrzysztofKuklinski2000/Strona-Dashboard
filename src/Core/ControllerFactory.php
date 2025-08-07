<?php 
declare(strict_types=1);

namespace App\Core;

use App\Controller\AbstractController;
use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\SiteController;
use App\Model\ContentModel;
use App\Model\DashboardModel;
use App\Model\UserModel;
use App\Request;
use Exception;


class ControllerFactory {

  private array $config;

  public function __construct(array $config) {
    if (empty($config['db'])) {
      throw new Exception('Configuration Error');
    }

    $this->config = $config;
  }

  public function createController(Request $request): AbstractController  {
    $dbconfig = $this->config['db'];
    return match(true) {
      $request->getParam('auth') !== null => new AuthController($request, new UserModel($dbconfig)),
      $request->getParam('dashboard') === 'start' => new DashboardController($request, new DashboardModel($dbconfig)),
      default => new SiteController($request, new ContentModel($dbconfig)),
    };
  }

}