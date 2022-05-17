<?php

namespace App\Controllers;

class DatabaseController extends BaseController 
{
    public function getLectures()
    {
      $response = $this->db->request('GET', '/api/lectures');
      $res = json_decode($response->getBody()->getContents());
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }

    public function getLecturesOfStudent()
    {
      global $limanData;
      $mail = $limanData['user']['email'];
      $response = $this->db->request('GET', '/api/studentlectures/getlectures/'. $mail);
      $res = json_decode($response->getBody()->getContents());
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }

    public function getLecturesOfLecturer()
    {
      global $limanData;
      $mail = $limanData['user']['email'];
      $response = $this->db->request('GET', '/api/lectures/bylecturer/'. $mail);
      $res = json_decode($response->getBody()->getContents());
      

      foreach($res->{'data'} as $data)
        unset($data->{'lecturer'});
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }

    public function getStudentsOfLecture()
    {
      $response = $this->db->request('GET', '/api/studentlectures/getstudents/'. request('id'));
      $res = json_decode($response->getBody()->getContents());
      foreach($res->{'data'} as $data)
        unset($data->{'lecturecode'});
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }

    public function getStudents()
    {
      $response = $this->db->request('GET', '/api/users/get/student');
      $res = json_decode($response->getBody()->getContents());
      foreach($res->{'data'} as $data)
        unset($data->{'id'});
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }

    public function getLecturers()
    {
      $response = $this->db->request('GET', '/api/users/get/lecturer');
      $res = json_decode($response->getBody()->getContents());
      foreach($res->{'data'} as $data)
        unset($data->{'id'});
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }  

    public function createLecture()
    {
      validate([
        "name" => "required",
        "code" => "required",
        "lecturer"  => "required"
      ]);
      $body = [
        'json' => [
          "name" => request('name'),
          "code" => request('code'),
          "lecturer" => request('lecturer')
        ]
      ]; 
      $response = $this->db->request('POST', '/api/lectures', $body);
      $res = json_decode($response->getBody()->getContents());
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }  

    public function selectLecture()
    {
      validate([
        "code" => "required",
      ]);
      return respond('test'); 
      $body = [
        'json' => [
          "code" => request('code'),
        ]
      ]; 
      $response = $this->db->request('POST', '/api/lectures', $body);
      $res = json_decode($response->getBody()->getContents());
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }  
    
}