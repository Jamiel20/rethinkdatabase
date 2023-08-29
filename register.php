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
        $username = $data->user;
        $password = $data->pass;

        $sql = "INSERT INTO users (id, username, email, pass) VALUES 
        (NULL, '$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
        echo "Added successfully";
        } else {
        echo "Error";
        }

        $conn->close();
    }

    else if($query == 2){

        $user = $data->us;
        $title = $data->tl;
        $content = $data->ct;

        date_default_timezone_set('Asia/Manila'); // Set the timezone to Philippines
        $currentDateTime = date("Y-m-d H:i:s");

        $sql = "INSERT INTO post (id, username, title, content, datetime) VALUES 
        (NULL, '$user', '$title', '$content', '$currentDateTime')";

        if ($conn->query($sql) === TRUE) {
        echo "Added successfully";
        } else {
        echo "Error";
        }

        $conn->close();
    }

    else if($query == 3){

        $user = $data->us;

        $sql = "SELECT * FROM post WHERE username = '$user' ORDER BY datetime DESC";

        $result = $conn->query($sql);

        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $conn->close();

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    else if($query == 4){

        $id = $data->id;
        $title = $data->tl;
        $content = $data->ct;

        date_default_timezone_set('Asia/Manila'); // Set the timezone to Philippines
        $currentDateTime = date("Y-m-d H:i:s");

        $sql = "UPDATE post SET title='$title', content='$content', datetime='$currentDateTime'  WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
        echo "Updated successfully";
        } else {
        echo "Error ";
        }

        $conn->close();
    }

    else if($query == 5){

        $id = $data->id;

        $sql = "DELETE FROM post WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
        echo "Deleted successfully";
        } else {
        echo "Error ";
        }

        $conn->close();
    }
}
?>
