<?php
header("Access-Control-Allow-Origin: *"); 
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    $query = $data->query;


    $host = 'localhost'; 
    $username = 'root'; 
    $password = ''; 
    $database = 'blogdb'; 

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if($query == 1){
        $email = $data->em;
        $password = $data->pass;

        $sql = "SELECT username FROM users WHERE email = '$email' AND pass = '$password'"; 

        $result = $conn->query($sql);

        $data = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $conn->close();

        header('Content-Type: application/json');
        echo json_encode($data);
        exit; 
    }

}

?>
