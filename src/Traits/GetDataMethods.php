<?php 
declare(strict_types=1);
namespace App\Traits;

trait GetDataMethods {

  protected function getDataToChangePostPosition(): array {
    return [
      'id' => $this->request->validate(param: 'id', required: true, type: 'int'),
      'dir' => $this->request->validate(param:'dir', required: true, type:'string')
    ];
  }

  protected function getPostDataToEdit(): array
  {
    return [
      'id' => $this->request->validate(param: 'postId', required: true, type: 'int'),
      'title' => $this->request->validate(param: 'postTitle', required:true, type: 'string', maxLength: 60, minLength:10),
      'description' => $this->request->validate(param: 'postDescription', required: true,  type: 'string', maxLength:1000, minLength:20),
      'updated' => date('Y-m-d')
    ];
  }

  protected function getPostDataToCreate(): array
  {
    return [
      'title' => $this->request->validate(param: 'postTitle', required:true, type: 'string', maxLength: 60, minLength:10),
      'description' => $this->request->validate(param: 'postDescription', required: true,  type: 'string', maxLength:1000, minLength:20),
      'created' => date('Y-m-d'),
      'updated' => date('Y-m-d'),
      'status' => 1,
    ];
  }

  protected function getDataToCampEdit(): array
  {
    return [
      'city' => $this->request->validate(param: 'town', required: true, type:'string', maxLength:50),
      'guesthouse' => $this->request->validate(param:'guesthouse', required: true, type: 'string', maxLength:70),
      'city_start' => $this->request->validate(param:'townStart', required: true, type: 'string', maxLength:50),
      'date_start' => $this->request->validate(param: 'dateStart', required: true),
      'date_end' => $this->request->validate(param: 'dateEnd', required:true),
      'time_start' => $this->request->validate(param: 'timeStart', required:true),
      'time_end' => $this->request->validate(param: 'timeEnd', required:true),
      'place' => $this->request->validate(param: 'place', required:true, type: 'string', maxLength:100),
      'accommodation' => $this->request->validate(param: 'accommodation', required:true, type: 'string', maxLength:500),
      'meals' => $this->request->validate(param: 'meals', required:true, type: 'string', maxLength:500),
      'trips' => $this->request->validate(param: 'trips', required:true, type:'string', maxLength:500),
      'staff' => $this->request->validate(param: 'staff', required:true, type: 'string', maxLength:500),
      'transport' => $this->request->validate(param: 'transport', required:true, type: 'string', maxLength:500),
      'training' => $this->request->validate(param: 'training', required:true, type: 'string', maxLength:500),
      'insurance' => $this->request->validate(param: 'insurance', required:true, type: 'string', maxLength:500),
      'cost' => $this->request->validate(param: 'cost', required:true, type: 'int'),
      'advancePayment' => $this->request->validate(param: 'advancePayment', required:true, type:'int'),
      'advanceDate' => $this->request->validate(param: 'advanceDate', required:true, type:'string'),
    ];
  }

  protected function getDataToFeesEdit(): array
  {
    return [
      'reduced_contribution_1_month' => $this->request->validate(param: 'n1', required:true, type:'int'),
      'reduced_contribution_2_month' => $this->request->validate(param: 'n2', required:true, type:'int'),
      'family_contribution_month' => $this->request->validate(param: 'n3', required:true, type:'int'),
      'reduced_contribution_1_year' => $this->request->validate(param: 'n6', required:true, type:'int'),
      'reduced_contribution_2_year' => $this->request->validate(param: 'n7', required:true, type:'int'),
      'family_contribution_year' => $this->request->validate(param: 'n8', required:true, type:'int'),
      'extra_information' => $this->request->validate(param: 'n10', required:true, type:'string'),
      'fees_information' => $this->request->validate(param: 'n11', required:true, type:'string'),
    ];
  }

  protected function getDataToContactEdit(): array
  {
    return [
      'email' => $this->request->validate(param:'email', required: true, type:'string', maxLength:100),
      'phone' => $this->request->validate('phone', required: true, type:'int', maxLength:9),
      'address' => $this->request->validate(param: 'address', required: true, type:'string'),
    ];
  }

  protected function getDataToAddTimetable(): array
  {
    return [
      'day' => $this->request->validate(param: 'day', required: true, type:'string', maxLength:20),
      'city' => $this->request->validate(param: 'city', required: true, type:'string', maxLength:40),
      'advancement_group' => $this->request->validate(param: 'group', required: true, type:'string', maxLength:40),
      'place' => $this->request->validate(param: 'place', required: true, type:'string', maxLength:100),
      'start' => $this->request->validate(param: 'startTime', required: true, type:'string'),
      'end' => $this->request->validate(param: 'endTime', required: true, type:'string'),
    ];
  }

  protected function getDataToEditTimetable(): array
  {
    return [
      "id" => $this->request->validate(param: 'id', required: true, type:'int'),
      'day' => $this->request->validate(param: 'day', required: true, type:'string', maxLength:20),
      'city' => $this->request->validate(param: 'city', required: true, type:'string', maxLength:40),
      'advancement_group' => $this->request->validate(param: 'group', required: true, type:'string', maxLength:40),
      'place' => $this->request->validate(param: 'place', required: true, type:'string', maxLength:100),
      'start' => $this->request->validate(param: 'startTime', required: true, type:'string'),
      'end' => $this->request->validate(param: 'endTime', required: true, type:'string'),
    ];
  }

  protected function getDataToAddImage():array {
    return [
      'category' => $this->request->validate(param: 'category', required: true, type:'string', maxLength:8),
      'description' => $this->request->validate(param: 'description', required:  true, type: 'string', maxLength: 50, minLength: 10),
      'image_name' => $this->request->validateFile('image_name'),
      'created_at' => date('Y-m-d'),
      'updated_at' => date('Y-m-d'),
    ];
  }

  protected function getDataToEditImage():array {
    return [
      "id" => $this->request->validate(param: 'id', required: true, type:'int'),
      'category' => $this->request->validate(param: 'category', required: true, type:'string', maxLength:8),
      'description' => $this->request->validate(param: 'description', required:  true, type: 'string', maxLength: 50, minLength: 10),
      'updated_at' => date('Y-m-d'),
    ];
  }
}