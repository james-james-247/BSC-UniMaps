<?php
    // Start the session
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>UniMaps</title>
        <link rel="shortcut icon" type="image/png" href="Photos/favicon.png"/> <!--our favicon-->

        <link rel="stylesheet" href="External/style.css" type="text/css" media="screen and (min-width: 801px)"> 
        <link rel="stylesheet" href="External/mobile.css" type="text/css" media="screen and (max-width: 800px)">
        <!--Link to our stye sheet-->

    </head>
    <body>

    <div id="wrapper">
        <div id="innerWrapper">
            <div id="header">
                <header>
                    <img src="Photos/icon.png">
                    <h1>UniMaps<br></h1>
                </header>
            </div>
            <div id="content">
                <div id="popUp" hidden>
                    <h1>This Service Requires Your Location!<br>Do You Accept?<br><input type="button" class="button" value="No" id="no">
                    <input type="button" class="button" value="Yes" id="yes"></h1>
                </div>
                <div id="loginForm">
                    <form action="actions.php" method="POST">
                        <div id="loginSection">
                            <h1 id="loginHeader">Log in</h1>
                            <p>Username</p>
                            <input type="text" placeholder="Enter Here" name="userName" id="userName" class="textBoxes" required>
                            <p>Password</p>
                            <input type="password" placeholder="Enter Here" name="password" id="password" class="passwordBoxes" required>
                            <input type="submit" value="Login" class="submitButtons"><p id="or" style="margin-top: 35px; margin-left: 14px; float: left; text-align: center;">-- OR -- </p>
                            <input type="button" value="Create Account" id="ca" class="buttonButtons">
                        </div>
                    </form>
                    <form action="actions.php" method="POST">
                        <div id="createSection" hidden>
                            <h1 id="createHeader">Create Account</h1>
                            <p>Your name</p>
                            <input type="text" placeholder="Enter Here" name="name" class="textBoxes" required>
                            <p>Username</p>
                            <input type="text" placeholder="Enter Here" name="username" class="textBoxes" required>
                            <p>Password</p>
                            <input type="password" placeholder="Enter Here" name="password" class="passwordBoxes" required>
                            <p>What is your primary campus?</p>
                            <?php  
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "userinfomation";
                                
                                // Create connection
                                $conn = mysqli_connect($servername, $username, $password, $dbname);
                                $sql = "SELECT campusName FROM campus";
                                $result = mysqli_query($conn, $sql);
                                //Here were creating the select tag and placing all the values from the database into it#
                                //This will prevent users from mistyping an input
                                echo "<select name='campus' class='textBoxes' required>";
                                while($row = $result->fetch_array()){
                                    echo "<option value=". $row["campusName"] .">". $row["campusName"] ."</option>";
                                }
                                echo "</select>";
                                mysqli_close($conn);
                            ?>
                            <input type="submit" value="Create Account" class="submitButtons"><p style="margin-top: 35px; margin-left: 14px; float: left; text-align: center;" id="or">-- OR --</p>
                            <input type="button" value="Return" id="returnLogin" class="buttonButtons">

                        </div>
                    </form>
                    <div id="LoggedIn" hidden>
                        <img src="Photos/profileLogo.jpg" id="profileLogo" style="width: 150px; height: 180px; margin: 0 auto; border-radius: 10px;">
                        <h1>You Successfully Logged In</h1>
                        <form action="actions.php" method="POST">
                            <input type="text" value="logOut" name="logOut" hidden>
                            <input type="submit" value="Log Out" id="logOutButton">
                        </form>
                    </div>
                    <div id="createdLoggedIn" hidden>
                        <img src="Photos/profileLogo.jpg" id="profileLogo" style="width: 150px; height: 180px; margin: 0 auto; border-radius: 10px;">
                        <h1>Created & Logged In Successfully!</h1>
                    </div>
                </div>

                <div id="userArea">
                        <h1>Search</h1>
                        <p>What building are you heading to? (Select from list below, it may also be represented as 3 letters, such as: ABK)</p>
                            <?php  
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "userinfomation";
                                
                                // Create connection
                                $conn = mysqli_connect($servername, $username, $password, $dbname);
                                $sql = "SELECT buildingName FROM building";
                                $result = mysqli_query($conn, $sql);
                                
                                //Here were creating the select tag and placing all the values from the database into it#
                                //This will prevent users from mistyping an input
                                echo "<form action='actions.php' method='post'><select name='buildingInput' required>";
                                while($row = $result->fetch_array()){
                                    echo "<option value=". $row["buildingName"] .">". $row["buildingName"] ."</option>";
                                }
                                echo "</select><input type='submit' value='Search' id='location'></form>";
                                mysqli_close($conn);
                            ?>
                </div>
            </div>
            <div id="map" style="height: 700px; width: 90%;"> <!--You have to predefine in HTML the size of the google maps div-->
            </div>

            <input type="button" id="faq" value="FAQ"><br>
            <div id="helpSection" hidden>
                    <h4>Where are you based?</h4>
                    <p>England, Nottingham</p>
                    <h4>Whats the possibilty of spreading to a new campus?</h4>
                    <p>Highly likely, we have plans to expand</p>  
                    <h4>Does this work on my iphone?</h4>
                    <p>Yes! if it can connect to the internet</p>      
            </div>
        </div>
    </div>
        <div id="footer">
            <footer>
                <p>UniMaps 2019<br>Thank you for using our services<br>We hope you find your way around soon</p>
            </footer>
        </div>

    <script src="External/script.js" type="text/javascript"></script> <!--This has to go first as the link below refers to this script immdeiatly-->
    <script src="https://maps.googleapis.com/maps/api/js?key=INSERTGOOGLEAPIKEYHERE&callback=myMap"></script> <!--This is the link
    too googles services that allows me to use maps, using my api key-->
    <?php
        //This is to see if the user will allow location use!
        if(isset($_SESSION["allow"]) && $_SESSION["allow"] == "allowed"){
            echo "<script>document.getElementById('popUp').style.display = 'none';</script>";
            echo "<script>document.body.style.overflow = 'auto';</script>";
        }
        else{
            echo "<script>document.getElementById('popUp').style.display = 'block';</script>";
        }
        //This if else if statement checks to see if the suer is logged in yet
        if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true || isset($_SESSION["created"]) && $_SESSION["created"] == true){
            echo "<script> document.getElementById('loginSection').hidden = true; document.getElementById('createSection').hidden = true; document.getElementById('LoggedIn').hidden = false; document.getElementById('createdLoggedIn').hidden = true;</script>";
        }
        else if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == false){
            echo "<script> document.getElementById('loginHeader').innerHTML = 'Incorrect User/Password';</script>";
        }
        else if(!isset($_SESSION["loggedIn"])){
            echo "<script> document.getElementById('loginSection').style.display = 'block'; document.getElementById('createSection').style.display = 'none'; document.getElementById('LoggedIn').style.display = 'none'; document.getElementById('createdLoggedIn').style.display = 'none';</script>";
        }

        if(isset($_SESSION["created"]) && $_SESSION["created"] == false){
            echo "<script> document.getElementById('loginSection').hidden = true; document.getElementById('createSection').hidden = true; document.getElementById('LoggedIn').hidden = true; document.getElementById('createdLoggedIn').hidden = true; document.getElementById('createHeader').innerHTML = 'Username Currently In Use';</script>";
        }

        if(isset($_SESSION["longitude"]) && isset($_SESSION["latitude"])){ 
            //There are comments below they now just blend in 
            $longitude = $_SESSION["longitude"]; $latitude = $_SESSION["latitude"];
            echo '<script>
                if(navigator.geolocation){
                    navigator.geolocation.getCurrentPosition(userLocation); //This using googles API gets our location
                }
                    
                function userLocation(currentlocation){
                    latNlong = {lat: currentlocation.coords.latitude, lng: currentlocation.coords.longitude}; //The next stage requires it written out like this
                    usersCurrentDestination = {lat: Number('.$latitude.'), lng: Number('.$longitude.')};
                    console.log(usersCurrentDestination);
                    myMap(latNlong, usersCurrentDestination);
                }

                function myMap(userLocation, userDestination){
                    var mapProp = {
                        center: new google.maps.LatLng(userLocation), //Using the users location to center the map
                        zoom: 17, //Zooms in so you can see a little bit around and where the user is
                    };
                    var map = new google.maps.Map(document.getElementById("map"), mapProp); //Places the created map in the div called map
                    var marker = new google.maps.Marker({position: userLocation}); //This creates the marker using the users location                        
                    marker.setMap(map);
                        
                    var directionsService = new google.maps.DirectionsService();
                    var directionsRequest = {
                        origin: userLocation, //This is where we start
                        destination: userDestination, //This is the location the users wants to go to
                        travelMode: google.maps.DirectionsTravelMode.WALKING, //Specifying the mode of transport the user will take
                        unitSystem: google.maps.UnitSystem.METRIC
                    }
                    console.log(directionsRequest);
                    
                    directionsService.route(directionsRequest, function(response, status){ /*The last class was how we specified where we are going this calss creates
                        the directions on the map and renders them */
                        if (status == google.maps.DirectionsStatus.OK){ //Checking to make sure the connection and requests are working
                            new google.maps.DirectionsRenderer({
                            map: new google.maps.Map(document.getElementById("map"), mapProp), //This now applies the directions to a new map and adds it to the div
                            directions: response 
                            });
                        }
                        else{
                            alert("Sorry That Is Not A Valid Destination"); //The code has errored
                        }
                    });
                }
            </script>';
        }
    ?>
    </body>
</html>
