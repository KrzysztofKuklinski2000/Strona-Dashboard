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
      'updated' => date('Y-m-d')
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
      'city_start' => $this->request->postParam('townStart'),
      'date_start' => $this->request->postParam('dateStart'),
      'date_end' => $this->request->postParam('dateEnd'),
      'time_start' => $this->request->postParam('timeStart'),
      'time_end' => $this->request->postParam('timeEnd'),
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
      'reduced_contribution_1_month' => $this->request->postParam('n1'),
      'reduced_contribution_2_month' => $this->request->postParam('n2'),
      'family_contribution_month' => $this->request->postParam('n3'),
      'contribution' => $this->request->postParam('n4'),
      'entry_fee' => $this->request->postParam('n5'),
      'reduced_contribution_1_year' => $this->request->postParam('n6'),
      'reduced_contribution_2_year' => $this->request->postParam('n7'),
      'family_contribution_year' => $this->request->postParam('n8'),
      'reduced_contribution_holidays' => $this->request->postParam('n9'),
      'extra_information' => $this->request->postParam('n10'),
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
      'advancement_group' => $this->request->postParam('group'),
      'place' => $this->request->postParam('place'),
      'start' => $this->request->postParam('startTime'),
      'end' => $this->request->postParam('endTime')
    ];
  }
}