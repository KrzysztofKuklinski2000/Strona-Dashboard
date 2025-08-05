<?php 
declare(strict_types=1);
namespace App\Controller;

use App\Request;

class ActionResolver {
  private const VIEW_ALIASES = [
    'galeria' => 'gallery',
    'przysiega_do_jo' => 'dojoOath',
    'wymagania' => 'requirements',
    'grafik' => 'timetable',
    'regulamin' => 'statute',
    'oyama' => 'oyama',
    'obozy' => 'camp',
    'oplaty' => 'fees',
    'zapisy' => 'registration',
    'kontakt' => 'contact',
    'aktualnosci' => 'news',
    'start' => 'start',
  ];

  private const VIEW_DASHBOARD_ALIASES = [
    'oplaty' => 'fees',
    'kontakt' => 'contact',
    'obozy' => 'camp',
    'start' => 'start',
    'aktualnosci' => 'news',
    'grafik' => 'timetable',
    'important_posts' => 'important_posts',
  ];

  private const DEFAULT_ACTION = 'start';
  private const DEFAULT_ACTION_FOR_DASHBOARD = 'start';

  public function resolveViewAction(Request $request): string {
    $viewParam = $request->getParam('view', self::DEFAULT_ACTION);
    $action = self::VIEW_ALIASES[$viewParam] ?? self::DEFAULT_ACTION;

    return $action."Action";
  }

  public function resolveDashboardAction(Request $request): string {
    $viewParam = $request->getParam('subpage', self::DEFAULT_ACTION_FOR_DASHBOARD);
    $action = self::VIEW_DASHBOARD_ALIASES[$viewParam] ?? self::DEFAULT_ACTION_FOR_DASHBOARD;

    return $action."DashboardAction";
  }

  public function resolveAuthAction(Request $request): string {
    $action = $request->getParam('auth', self::DEFAULT_ACTION);

    return $action."Action";
  }

  public function resolve(Request $request): string {
    $dashboard = $request->getParam('dashboard');
    $auth = $request->getParam('auth'); 

    return match(true){
      $dashboard === 'start' => $this->resolveDashboardAction($request),
      $auth !== null => $this->resolveAuthAction($request),
      default => $this->resolveViewAction($request),
    };

  }
}