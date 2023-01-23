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
    <div class="container">
        <header class='header'>
            <h3>Local Scene - Event Calender</h3>
            <button class='new-button' onclick="showEvent('newEventWrapper')" id='newEventButton'>NEW</button>
        </header>
        <div id='newEventWrapper' class='no-show'>
            <div class='event-container'>
                <form class='reddy' action='submit.php' method='POST'>
                    <div class="new-event-form">
                        <label for=' name'>Band or Artist Name</label>
                        <input id='name' name='name' type='text' class='name-input' />
                        <label for='date'> Date</label>
                        <input type='date' id='date' name='date' class='date-input' />
                        <label for='venue'>Venue</label>
                        <input id='venue' name='venue' class='venue-input' />
                        <label for='details'> More Info </label>
                        <textarea id='details' name='details' class='date-input' rows='3'></textarea>
                        <label for='link'> Copy and Paste an event link </label>
                        <input id='link' name='link' class='link-input'/>
                        <label for='isBot'>I am a robot</label>
                        <input type='checkbox' id='isBot' name="isBot"/>
                        <label for='isnotBot'>I am a sentient being</label>
                        <input type='checkbox' id='isnotBot' name='isnotBot'/>
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