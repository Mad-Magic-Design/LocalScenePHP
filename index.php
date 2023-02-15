<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <title>Local Scene</title>
</head>

<body>

<?php

include('config.php');
$name = $email = $venue = $link = $details = $date = "";
$nameErr = $venueErr = $linkErr = $detailsErr =  $validationErr = $dateErr = "";
$validForm = true;

if(isset($_POST['submit'])){
    if (!isset($_POST['isnotBot']) or isset($_POST['isBot'])){
        $validationErr = "Humans only please, try again";
        $validForm = false;
    }}

if(isset($_POST['submit'])){
    if (isset($_POST['isnotBot']) and !isset($_POST['isBot'])){

        if (empty($_POST["name"])) {
            $nameErr = "Name is Required";
            $validForm = false;
        }
        else{
            $name = test_input($_POST['name']);
        }
        if (empty($_POST["date"])) {
            $dateErr = "Date is required";
            $validForm = false;
          } else {
        $date = test_input($_POST['date']);
          }
        if (empty($_POST["venue"])) {
            $venueErr = "Venue is required";
            $validForm = false;
        } else {
        $venue = test_input($_POST['venue']);
        }
        if (empty($_POST["details"])) {
            $detailsErr = "Details are required";
            $validForm = false;
        } else {
        $details =test_input( $_POST['details']);
        }
        if (empty($_POST["link"])) {
            $linkErr = "link is required";
            $validForm = false;
          } else {
        $link = test_input($_POST['link']);
        if (!filter_var($link, FILTER_VALIDATE_URL)) {
            $linkErr = 'enter a valid url';
            $validForm = false;
        }
        }   

        if ($validForm == true){
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
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>




    <div class="container">
        <header class='header'>
            <h3>Local Scene - Event Calender</h3>
            <button class='new-button' onclick="showEvent('newEventWrapper')" id='newEventButton'>NEW</button>
        </header>
        <div id='newEventWrapper' class='<?=$validForm === true ? 'no-show' : 'event-wrapper'?>'>
            <div class='event-container'>
                <!-- <form class='reddy' action='submit.php' method='POST'> -->
                <form class='new-form' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>
                    <div class="new-event-form">
                        <label for=' name'>Band or Artist Name</label>
                        <span class="error"><?php echo $nameErr;?></span>
                        <input id='name' name='name' type='text' class='name-input' value="<?php echo $name;?>" />
                        <label for='date'> Date</label>
                        <span class="error"><?php echo $dateErr;?></span>
                        <input type='date' id='date' name='date' class='date-input' value="<?php echo $date;?>" />
                        <label for='venue'>Venue</label>
                        <span class="error"><?php echo $venueErr;?></span>
                        <input id='venue' name='venue' class='venue-input' value="<?php echo $venue;?>" />
                        <label for='details'> More Info </label>
                        <span class="error"><?php echo $detailsErr;?></span>
                        <textarea id='details' name='details' class='date-input' rows='3'><?php echo $details;?></textarea>
                        <label for='link'> Copy and Paste an event link </label>
                        <span class="error"><?php echo $linkErr;?></span>
                        <input id='link' name='link' class='link-input' value="<?php echo $link;?>"/>
                        <label for='isBot'>I am a robot</label>
                        <input type='checkbox' id='isBot' name="isBot"/>
                        <label for='isnotBot'>I am a sentient being</label>
                        <input type='checkbox' id='isnotBot' name='isnotBot'/>
                        <span class="error"><?php echo $validationErr;?></span>
                        <input type='submit' name='submit' value='Submit' />
                    </div>
                </form>
            </div>

        </div>
        <div class="calender-wrapper">
            <?php 

    include('config.php');
    $connection = mysqli_connect('localhost', $user,$pass,$db);
    $query = "SELECT * FROM events ORDER BY date ASC" ;
    $result = mysqli_query($connection, $query);
    $i =1;
    while($row = mysqli_fetch_assoc($result)){
    $name = $row["name"];
    $date = substr($row["date"], -5, 5);
    $venue = $row["venue"];
    $details = $row["details"];
    $link = $row["link"];
    echo ("<div class='show-wrapper'>
    <div id='show-container-$i' class='show-container'>
    <h1 class='name-text'>$name</h1>
    <h3 class='venue-text'>@$venue</h3>
    <h4 class='date-text'>$date</h4>
    <p class='hidden-details'>$details</p>
    <a href=$link class='hidden-details' target='_blank' rel='noopener noreferrer'>link</a>
    </div></div> ");
    $i++;
    }
    
   
    
    ?>
        </div>
    </div>

    <script>
    //  document.getElementbyId('newEventButton').onclick = 

    function showEvent(divToShow) {
        var showEvent = document.getElementById(divToShow);
        showEvent.classList.remove('no-show');
        showEvent.classList.add('event-wrapper');
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>