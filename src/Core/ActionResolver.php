<?php 
declare(strict_types=1);
namespace App\Core;

use App\Core\Request;

class ActionResolver {
  private const DEFAULT_ACTION = 'index';

  public function resolve(Request $request): string {
    $action = $request->getParam('action') ?? self::DEFAULT_ACTION;
    
    $action = preg_replace('/[^a-zA-Z]/', '', $action);

    return $action.'Action';
  }
}