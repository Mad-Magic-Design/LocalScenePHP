<?php

include('config.php');

if(isset($_POST['submit'])){
    if (!isset($_POST['isnotBot']) or isset($_POST['isBot'])){
        echo "Humans only please, back up and try again";
    }}

if(isset($_POST['submit'])){
    if (isset($_POST['isnotBot']) and !isset($_POST['isBot'])){
        $name = $_POST['name'];
        $date = $_POST['date'];
        $venue = $_POST['venue'];
        $details = $_POST['details'];
        $link = $_POST['link'];

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

?>