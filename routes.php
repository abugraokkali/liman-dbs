<?php

return [
    "index" => "HomeController@index",

    "get_lectures" => "DatabaseController@getLectures",
    "get_lectures_of_student" => "DatabaseController@getLecturesOfStudent",
    "get_lectures_of_lecturer" => "DatabaseController@getLecturesOfLecturer",
    "get_students_of_lecture" => "DatabaseController@getStudentsOfLecture",
    "get_students" => "DatabaseController@getStudents",
    "get_lecturers" => "DatabaseController@getLecturers",
    "create_lecture" => "DatabaseController@createLecture",
    "select_lecture" => "DatabaseController@selectLecture"

];
