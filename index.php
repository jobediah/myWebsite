<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Final Project</title>

    <!-- Custom CSS -->
    <link type="text/css" rel="stylesheet" href="style.css"/>
    <script src = 'http://www.engr.oregonstate.edu/~hansejod/finalproject/meetups.js'></script>
</head>
<body>
<?php
    if(isset($_GET['action']) && $_GET['action']==true){
        echo "<p>You have successfully logged out.</p>";
        $_SESSION = array();
        session_destroy();
    }
?>
    <!-- Navigation -->
    <div class="container">
        <ul>
            <li>
                <a href="about.html">About</a>
            </li>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>
                <a href="createLogin.html">Sign Up</a>
            </li>
            <li>
                <a href="login.html">Login</a>
            </li>
            <li>
                <a href="userevents.php">My Events</a>
            </li>
            <li>
                <a href='index.php?action=true'>Log Out</a>
            </li>
        </ul>
    </div>
        <!-- /.container -->
        <h1>Find a study group or create your own! </h1>
        <h3>Below is a list of all study groups. Click on the address to go to google maps. Or, click on the owner to send them an email.</h3>
        
            <p>Find events within 5 miles of your zipcode:</p>
            zipcode:<br><input type="text" id="filters" class="filters" name="filter">
            <button id="filterButton" onclick="filterResults(this.name)">Go!</button>

        <div class="tablecap">Study Groups</div>
        <div id="meetups"></div>
<p><h4>Please sign up or login if you wish to create your own study group<h4></p>
    </div>
    <!-- /.container -->

</body>

</html>
