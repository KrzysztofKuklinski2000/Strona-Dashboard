<?php

namespace App\Notification\Observer;

interface TimetableObserverInterface {
  public function update(): void;
}