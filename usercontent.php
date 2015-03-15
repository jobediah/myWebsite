<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    session_start();
    include 'password.php';
    
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "hansejod-db", $password, "hansejod-db");
    
    if(isset($_POST['deleteId'])){
        //Remove selected event from database
        $id = $_POST['deleteId'];
            
        if (!($stmt = $mysqli->prepare("DELETE FROM groups WHERE id = $id"))){
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";
        }
            
        if (!($stmt->execute())) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt.error;
        }
        else {
            $stmt->execute();
        }
    }
    
    if(session_status() == PHP_SESSION_ACTIVE){
        if(!isset($_SESSION["username"])){
            echo "<p>You must login or create an account to add an event</p>";
            return;
        }
        
        if($_POST['date'] == NULL || $_POST['time']==NULL || $_POST['location']==NULL || $_POST['description']==NULL){
            echo "<p>Please fill out all forms correctly.</p>";
            return;
        }
        
        if((int)(substr($_POST['date'],0,4)) < 2015){
            echo "<p>Please a date in the year 2015.</p>";
            return;
        }
        
        if(!((int)$_POST['zipcode'])){
            echo "<p>Please enter a number for the zipcode.</p>";
            return;
        }
    
        $owner = $_SESSION["username"];
        $email = $_SESSION["email"];
        $picture = $_SESSION["picture"];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $zipcode = $_POST['zipcode'];
        $description = $_POST['description'];
        
        //Insert event details into database
        if (!($stmt = $mysqli->prepare("INSERT INTO groups(owner, email, picture, date, time, location, zipcode, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
    
        if(!$stmt->bind_param("ssssssis", $owner, $email, $picture, $date, $time, $location, $zipcode, $description)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
				
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    
        $stmt->close();
    }
    
    else{
        echo "Please enter values for all fields";
    }
?>
