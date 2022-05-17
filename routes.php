<?php

return [
    "index" => "HomeController@index",

    "get_lectures" => "DatabaseController@getLectures",
    "get_lectures_of_student" => "DatabaseController@getLecturesOfStudent",
    "get_lectures_of_lecturer" => "DatabaseController@getLecturesOfLecturer",
    "get_students_of_lecture_approved" => "DatabaseController@getStudentsOfLectureApproved",
    "get_students_of_lecture_waiting" => "DatabaseController@getStudentsOfLectureWaiting",
    "get_students" => "DatabaseController@getStudents",
    "get_lecturers" => "DatabaseController@getLecturers",
    "create_lecture" => "DatabaseController@createLecture",
    "select_lecture" => "DatabaseController@selectLecture",
    "send_notif" => "DatabaseController@sendNotif",
    "send_notif_with_username" => "DatabaseController@sendNotifWithUsername",
    "approve_student" => "DatabaseController@approveStudent",
    "decline_student" => "DatabaseController@declineStudent",
    "send_announcement" => "DatabaseController@sendAnnouncement"
    
];
