<?php 
declare(strict_types=1);
namespace App\Traits;

trait GetDataMethods {


  protected function getPostDataToEdit(): array
  {
    return [
      'id' => $this->request->postParam('postId'),
      'title' => $this->request->postParam('postTitle'),
      'description' => $this->request->postParam('postDescription'),
      'date' => date('Y-m-d')
    ];
  }

  protected function getPostDataToCreate(): array
  {
    return [
      'title' => $this->request->postParam('postTitle'),
      'description' => $this->request->postParam('postDescription'),
      'date' => date('Y-m-d')
    ];
  }

  protected function getDataToCampEdit(): array
  {
    return [
      'city' => $this->request->postParam('town'),
      'guesthouse' => $this->request->postParam('guesthouse'),
      'townStart' => $this->request->postParam('townStart'),
      'dateStart' => $this->request->postParam('dateStart'),
      'dateEnd' => $this->request->postParam('dateEnd'),
      'timeStart' => $this->request->postParam('timeStart'),
      'timeEnd' => $this->request->postParam('timeEnd'),
      'place' => $this->request->postParam('place'),
      'accommodation' => $this->request->postParam('accommodation'),
      'meals' => $this->request->postParam('meals'),
      'trips' => $this->request->postParam('trips'),
      'staff' => $this->request->postParam('staff'),
      'transport' => $this->request->postParam('transport'),
      'training' => $this->request->postParam('training'),
      'insurance' => $this->request->postParam('insurance'),
      'cost' => $this->request->postParam('cost'),
      'advancePayment' => $this->request->postParam('advancePayment'),
      'advanceDate' => $this->request->postParam('advanceDate')
    ];
  }

  protected function getDataToFeesEdit(): array
  {
    return [
      'fees1' => $this->request->postParam('n1'),
      'fees2' => $this->request->postParam('n2'),
      'fees3' => $this->request->postParam('n3'),
      'fees4' => $this->request->postParam('n4'),
      'fees5' => $this->request->postParam('n5'),
      'fees6' => $this->request->postParam('n6'),
      'fees7' => $this->request->postParam('n7'),
      'fees8' => $this->request->postParam('n8'),
      'fees9' => $this->request->postParam('n9'),
    ];
  }

  protected function getDataToContactEdit(): array
  {
    return [
      'email' => $this->request->postParam('email'),
      'phone' => $this->request->postParam('phone'),
      'address' => $this->request->postParam('address')
    ];
  }

  protected function getDataToAddTimetable(): array
  {
    return [
      'day' => $this->request->postParam('day'),
      'city' => $this->request->postParam('city'),
      'group' => $this->request->postParam('group'),
      'place' => $this->request->postParam('place'),
      'startTime' => $this->request->postParam('startTime'),
      'endTime' => $this->request->postParam('endTime')
    ];
  }

  protected function getDataToEditTimetable(): array
  {
    return [
      "id" => $this->request->postParam('id'),
      'day' => $this->request->postParam('day'),
      'city' => $this->request->postParam('city'),
      'group' => $this->request->postParam('group'),
      'place' => $this->request->postParam('place'),
      'startTime' => $this->request->postParam('startTime'),
      'endTime' => $this->request->postParam('endTime')
    ];
  }
}