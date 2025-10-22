<?php 
declare(strict_types=1);
namespace App\Core;

use App\Core\Request;

class ActionResolver {
  private const DEFAULT_ACTION = 'index';

  public function __construct(private ?array $slugMap = null) {}

  public function resolve(Request $request): string {
    $action = $request->getQueryParam('action') ?? self::DEFAULT_ACTION;
    
    $action = preg_replace('/[^a-zA-Z]/', '', $action);

    if($this->slugMap !== null && isset($this->slugMap[$action])) {
      $action = $this->slugMap[$action];
    }else if($this->slugMap !== null && !isset($this->slugMap[$action])){
      $action = self::DEFAULT_ACTION;
    }else {
      $action = ($action === '') ? self::DEFAULT_ACTION : $action;
    }

    return $action.'Action';
  }
}