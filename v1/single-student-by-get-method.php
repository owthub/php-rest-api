<?php
//ini_set("display_errors", 1);
// include headers
header("Access-Control-Allow-Origin: *");
// data which we are getting inside request
header("Access-Control-Allow-Methods: GET");
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

if($_SERVER['REQUEST_METHOD'] === "GET"){

   $student_id = isset($_GET['id']) ? intval($_GET['id']) : "";

   if(!empty($student_id)){

     $student->id = $student_id;
     $student_data = $student->get_single_student();
     //print_r($student_data);
     if(!empty($student_data)){

       http_response_code(200); //means OK status
       echo json_encode(array(
         "status" => 1,
         "data" => $student_data
       ));
     }else{

       http_response_code(404); // data not found
       echo json_encode(array(
         "status" => 0,
         "message" => "Student not found"
       ));
     }
   }

}else{

    http_response_code(503); // service unavialable
    echo json_encode(array(

      "status" => 0,
      "message" => "Access Denied"
    ));
}
 ?>
