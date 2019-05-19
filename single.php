<?php
$request_method = $_SERVER['REQUEST_METHOD'];
$response = array();


switch($request_method) {

    case "GET":
        response(read());
    break;

    case "POST":
        response(create());
    break;

    case "DELETE":
        response(delete());
    break;

    case "PUT":
        response(update());
    break;
}

function read() {

    if(@$_GET['id']) {
        @$id = $_GET['id'];
        $where = "WHERE `id`=" .$id;
    } else {
        $id = 0;
        $where = "";
    }

    $dbconnect = mysqli_connect("localhost","root","","employee_details");
    $query = mysqli_query($dbconnect, "SELECT * FROM `employees`".$where);

    while($data = mysqli_fetch_assoc($query)) {
        $response[] = array("id" => $data['id'], "first_name" => $data['first_name'],"last_name" => $data['last_name'] , "age" => $data['age'] , "contact_number" => $data['contact_number']);

    }
    
    //echo json_encode($data);
    return $response;
    
} 

function create() {

    if(@$_POST) {
        

        $dbconnect = mysqli_connect("localhost","root","","employee_details");
        $query = mysqli_query($dbconnect, "INSERT INTO `employees` (`first_name`,`last_name`,`age`,`contact_number`) VALUES('".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['age']."','".$_POST['contact_number']."')");
        if ($query == true) {
            $response = array("message"=>"success added ");
        } else {
            $response = array("message"=>"failed");
        }    

    }   
    
    return $response;
    
}

function delete() {

    if(@$_GET['id']) {
        

        $dbconnect = mysqli_connect("localhost","root","","employee_details");
        $query = mysqli_query($dbconnect, "DELETE FROM `employees` WHERE `id` = '".$_GET['id']."' ");
        if ($query == true) {
            $response = array("message"=>"success deleted");
        } else {
            $response = array("message"=>"failed");
        }    

    }   
    
    return $response;
    
}

function update() {

    parse_str(file_get_contents('php://input'), $_PUT);

    if(@$_PUT) {
        

        $dbconnect = mysqli_connect("localhost","root","","employee_details");
        $query = mysqli_query($dbconnect, "UPDATE `employees` SET 

                                `first_name`  = '".$_PUT['first_name']."',
                                `last_name`  = '".$_PUT['last_name']."',
                                `age`  = '".$_PUT['age']."',
                                `contact_number`  = '".$_PUT['contact_number']."'        
                        
                                WHERE `id` = '".$_GET['id']."'
                                ");
        if ($query == true) {
            $response = array("message"=>"success updated");
        } else {
            $response = array("message"=>"failed");
        }    

    }   
    
    return $response;
    
}



//output
function response($response) {
 
    echo json_encode(array("status"=> "200","data"=> $response));

} 
    
?>