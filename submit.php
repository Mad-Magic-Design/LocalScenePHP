<?php

include('config.php');
$name = $email = $gender = $comment = $website = "";
$nameErr = $emailErr = $genderErr = $websiteErr = "";

if(isset($_POST['submit'])){
    if (!isset($_POST['isnotBot']) or isset($_POST['isBot'])){
        echo "Humans only please, back up and try again";
    }}

if(isset($_POST['submit'])){
    if (isset($_POST['isnotBot']) and !isset($_POST['isBot'])){

        if (empty($_POST["name"])) {
            $nameErr = "Name is Required";
        }
        else{
            $name = test_input($_POST['name']);
        }
        $date = test_input($_POST['date']);
        $venue = test_input($_POST['venue']);
        $details =test_input( $_POST['details']);
        $link = test_input($_POST['link']);

        $connection = mysqli_connect('localhost', $user, $pass, $db);
        if (!$connection){
            echo('database connection failed');
        }

        $sql = "INSERT INTO events(name,date,venue,details,link) VALUES ('$name', '$date', '$venue', '$details', '$link')";

        if ($connection->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    
        $connection->close();

        header('location: index.php');
    }


}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>