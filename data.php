<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    session_start();
    include 'password.php'
?>
<?php
    /* Most of the syntax was acquired from php.net and class lectures.*/
    
    //Connect to database
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "hansejod-db", $password, "hansejod-db");
    if(session_status() == PHP_SESSION_ACTIVE){
        $owner = $_SESSION["username"];
    
        //Grab all rows in order by id
        if (!($stmt = $mysqli->prepare("SELECT * FROM groups ORDER BY id"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";
        }
    
        if (!($stmt->execute())) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt.error;
        }
    
        else {
            $stmt->execute();
        }
    
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
    
        //Create an array of all results
        $allResults = array();
        while ($row) {
            if($row['owner'] == $owner){
                array_push($allResults, $row);
            }
            $row = $res->fetch_assoc();
        }
    
        $stmt->close();
        
        //encode the results as json objects
        echo json_encode($allResults);
    }
?>