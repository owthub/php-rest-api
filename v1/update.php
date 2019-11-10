<?php
// include headers
header("Access-Control-Allow-Origin: *");
// it allow all origins like localhost, any domain or any subdomain
header("Content-type: application/json; charset=UTF-8");
// data which we are getting inside request
header("Access-Control-Allow-Methods: POST");
// method type

// include database.php
include_once("../config/database.php");
// include student.php
include_once("../classes/student.php");

// create object for database
$db = new Database();

$connection = $db->connect();

// create object for student
$student = new Student($connection);

if($_SERVER['REQUEST_METHOD'] === "POST"){

   $data = json_decode(file_get_contents("php://input"));

   if(!empty($data->name) && !empty($data->email) && !empty($data->mobile) && !empty($data->id)){

      $student->name = $data->name;
      $student->email = $data->email;
      $student->mobile = $data->mobile;
      $student->id = $data->id;

      if($student->update_student()){

        http_response_code(200);// OK
        echo json_encode(array(
          "status" => 1,
          "message" => "Student data successfully updated"
        ));
      }else{

        http_response_code(500);// server error
        echo json_encode(array(
          "status" => 0,
          "message" => "Failed to update data"
        ));
      }
   }
   else{
     http_response_code(404);// data not found
     echo json_encode(array(
       "status" => 0,
       "message" => "All data needed"
     ));
   }
}else{

  http_response_code(503); // service unavialable
  echo json_encode(array(
    "status" => 0,
    "message" => "Access denied"
  ));
}
