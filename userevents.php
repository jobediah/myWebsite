<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    session_start();
    include 'password.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Final Project</title>
    <link type="text/css" rel="stylesheet" href="style.css"/>
    <script src = 'usercontent.js'></script>
</head>

<body>

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
    </div>    <!-- /.container -->
    <h3>To create an event, please login and fill out all forms.</h3>
    <div id="meeting">
        <fieldset class="forms"><legend>Create an event:</legend>
            Date:<br><input type="date" id="date" min="2015-03-15"><br>
            Time:<br><input type="time" id="time"><br>
            Address:<br><input type="text" id="location"><br>
            Zip code:<br><input type="number" id="zipcode"><br>
            Description:<br><input type="text" id="description" size="80"><br>
        <button id="submit" onclick="createMeeting()">Create</button>
        </fieldset>
    </div>
    <div id="myDiv"></div>
    <div id="upload">
        <form action="userevents.php" method="post" enctype="multipart/form-data">
        Select image to upload for your profile picture (extensions must be uppercase JPG, JPEG, GIF, or PNG):
        <input type="file" name="fileToUpload" class="file" id="fileToUpload">
        <input type="submit" id="fileButton" value="Upload Image" name="submit">
        </form>
    </div>

    <div id="myFile">
<?php
/*The following code below was adapted from W3schools.com from their uploading file tutorial */
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "hansejod-db", $password, "hansejod-db");
    $HTTPMethod = $_SERVER['REQUEST_METHOD'];
    if($HTTPMethod === 'POST'){
    if(session_status() == PHP_SESSION_ACTIVE){
        if(!isset($_SESSION["username"])){
            echo "<p>You must login or create an account to upload an image.</p>";
            return;
        }

        $owner = $_SESSION["username"];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $target_file = "uploads/".$owner.".".$imageFileType;
        $uploadOk = 1;
        
        if(($_FILES["fileToUpload"]["tmp_name"])==NULL){
            echo "No File selected";
            return;
        }
        
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image<br>";
                $uploadOk = 1;
            }
            else {
                echo "File is not an image.<br>";
                $uploadOk = 0;
            }
        }
        
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }
        
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }
        
        if($imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG"
           && $imageFileType != "GIF" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }
        
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
            
        }
        else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "<p>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<p>";
               $_SESSION["picture"] = $target_file;
            }
            else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
        
        if (!($stmt = $mysqli->prepare("UPDATE loginDatabase SET picture='$target_file' WHERE username = '$owner'"))){
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";
        }
        
        if (!($stmt->execute())) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt.error;
        }
        else {
            $stmt->execute();
        }
        
    }
    }
    
?>
    </div>
    <div id="calendar"></div>
</body>

</html>
