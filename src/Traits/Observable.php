<?php 

namespace App\Traits;

use App\Notification\Observer\TimetableObserverInterface;


trait Observable {
  private array $observers = [];

  public function attach(TimetableObserverInterface $observer): void
  {
    $this->observers[] = $observer;
  }

  private function notify(): void
  {
    foreach ($this->observers as $observer) {
      $observer->update();
    }
  }
}