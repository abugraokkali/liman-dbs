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

    public function getStudentsOfLectureApproved()
    {
      $response = $this->db->request('GET', '/api/studentlectures/getstudents/'. request('id').'/1');
      $res = json_decode($response->getBody()->getContents());
      foreach($res->{'data'} as $data)
        unset($data->{'lecturecode'});
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }

    public function getStudentsOfLectureWaiting()
    {
      $response = $this->db->request('GET', '/api/studentlectures/getstudents/'. request('id').'/0');
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
        "lecturecode" => "required",
      ]);
      global $limanData;
      $body = [
        'json' => [
          "studentid" => $limanData['user']['email'],
          "lecturecode" => request('lecturecode'),
          "status" => "0"
        ]
      ]; 
      $response = $this->db->request('POST', '/api/studentlectures', $body);
      $res = json_decode($response->getBody()->getContents());
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }  

    public function sendNotif()
    {
      $body = [
        'json' => [
          "userid" => request('userid'),
          "title" => request('title'),
          "type" => request('type'),
          "message" => request('message'),
          "level" => "0",
          "read" => "false"
        ]
      ]; 
      $response = $this->db->request('POST', '/api/notification', $body);
      $res = json_decode($response->getBody()->getContents());
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }  

    public function sendAnnouncement()
    {
      $body = [
        'json' => [
          "lecturecode" => request('lecturecode'),
          "title" => request('title'),
          "type" => request('type'),
          "message" => request('message')
        ]
      ]; 
      $response = $this->db->request('POST', '/api/notification/announcement', $body);
      $res = json_decode($response->getBody()->getContents());
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }

    public function sendNotifWithUsername()
    {
      global $limanData;
      $body = [
        'json' => [
          "userid" => request('userid'),
          "title" => request('title'),
          "type" => "liman_update",
          "message" => $limanData['user']['name'] . request('message'),
          "level" => "0",
          "read" => "false"
        ]
      ]; 
      $response = $this->db->request('POST', '/api/notification', $body);
      $res = json_decode($response->getBody()->getContents());
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }

    public function approveStudent()
    {
      $body = [
        'json' => [
          "studentid" => request('studentid'),
          "lecturecode" => request('lecturecode'),
        ]
      ]; 
      $response = $this->db->request('POST', '/api/studentlectures/approve', $body);
      $res = json_decode($response->getBody()->getContents());
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }

    public function declineStudent()
    {
      $body = [
        'json' => [
          "studentid" => request('studentid'),
          "lecturecode" => request('lecturecode'),
        ]
      ]; 
      $response = $this->db->request('POST', '/api/studentlectures/decline', $body);
      $res = json_decode($response->getBody()->getContents());
      if($res->status)
        return respond($res->data); 
      return respond($res->message,201);
    }
}