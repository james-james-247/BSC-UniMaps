<?php   
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "userinfomation";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);


    if(isset($_POST["userName"])){
        $username = $_POST["userName"];
        $password = $_POST["password"];
        
        $sql = "SELECT username, userPasswords FROM users WHERE username = '{$username}' AND userPasswords = '{$password}'";
        $result = mysqli_query($conn, $sql);
        
        if ($result->num_rows > 0){
            $_SESSION["loggedIn"] = true;
            header("Location: index.php");
        } 
        else{
            $_SESSION["loggedIn"] = false;
            header("Location: index.php");
        }
    }

    else if(isset($_POST["name"])){
        $name = $_POST["name"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $campus = $_POST["campus"];

        $sql = "SELECT username FROM users WHERE username = '{$username}'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if($num > 0){
            $_SESSION["created"] = false;
            header("Location: index.php");
        }
        else{
            $sql = "INSERT INTO users (name, username, userPasswords, mainCampus) VALUES ('{$name}', '{$username}', '{$password}', (SELECT campusid FROM campus WHERE campusName = '{$campus}' LIMIT 1));";
            $result = mysqli_query($conn, $sql);
            $_SESSION["created"] = true;
            header("Location: index.php");
        }
    }

    else if(isset($_POST["buildingInput"])){
        $building = $_POST["buildingInput"];
        $sql = "SELECT longitude, latitude FROM building WHERE buildingName = '{$building}'";
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc();
        $longitude = $row["longitude"];
        $latitude = $row["latitude"];
        $_SESSION["longitude"] = $longitude;
        $_SESSION["latitude"] = $latitude;
        header("Location: index.php");
    }

    else if(isset($_POST["logOut"])){
        unset($_SESSION["loggedIn"]);
        header("Location: index.php");
    }

    else if(isset($_GET["location"])){
        $_SESSION["allow"] = "allowed";
        header("Location: index.php");
    }
?>