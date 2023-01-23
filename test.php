<?php

echo('<h1>hello blurd<h1>');
print_r ($_POST);

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];

    $connection = mysqli_connect('localhost', 'root','','kelowna_localscene');
    if (!$connection){
        echo('database connection failed');
    }

    $sql = "INSERT INTO events(name,date,venue) VALUES ('$name', '$date', '$venue')";

    if ($connection->query($sql) === TRUE) {
        echo "New record created successfully";
     } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
  



}

?>