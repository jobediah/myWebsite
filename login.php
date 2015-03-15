<?php
    session_start();
    include 'password.php';
    //Connect to database
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "hansejod-db", $password, "hansejod-db");
    if($mysqli->connect_errno){
        echo "Failed to connect: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    else {
            
        $HTTPMethod = $_SERVER['REQUEST_METHOD'];
    
        if($HTTPMethod === 'POST'){
        //Insert values into database
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password = hash("md5", $password, false);
            $account = $_POST['account'];
            $picture = "uploads/profile_empty_avatar.gif";
        
            if($account === 'true'){
                $email = $_POST['email'];
                $stmt = $mysqli->prepare("SELECT username FROM loginDatabase");
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                while ($row) {
                    if($row['username'] === $username){
                        echo "<p>I'm sorry that username is already in use</p>";
                        return;
                    }
                    $row = $res->fetch_assoc();
                }
                $stmt->close();

                
                if (!($stmt = $mysqli->prepare("INSERT INTO loginDatabase(username, password, email, picture) VALUES (?, ?, ?, ?)"))) {
                    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                
                if(!$stmt->bind_param("ssss", $username, $password, $email, $picture)) {
                    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
                }
                
                if (!$stmt->execute()) {
                    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                }
                
                $stmt->close();
                echo "<p>Sign Up successful</p>";
            }
            
            
                $stmt = $mysqli->prepare("SELECT * FROM loginDatabase");
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $flag = true;
            
                while ($row) {
                    if($row['username'] === $username && $row['password'] === $password){
                        echo "<p>Welcome, ".$username."<br>You are now logged in.<br></p>";
                        $_SESSION["username"] = $row['username'];
                        $_SESSION["email"] = $row['email'];
                        $_SESSION["picture"] = $row['picture'];
                        $flag = false;
                        break;
                    }
                    $row = $res->fetch_assoc();
                }
                
                $stmt->close();
                
                if($flag === true){
                    echo "<p>We don't have that username or password in our database</p>";
                }
            
        }
        
    }
?>