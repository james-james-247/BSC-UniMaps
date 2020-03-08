function myMap(){
  var mapProp = {
    center: new google.maps.LatLng(52.911724, -1.185618), //NTU Clifton Campus
    zoom: 17, //Gets all of clifton campus in mostly
  };
  var map = new google.maps.Map(document.getElementById("map"), mapProp); //This is where we render the map in our div called map
}


document.getElementById("ca").addEventListener("click", function(){ //Simple functions to control the login/create account areas
  document.getElementById("loginSection").style.display = "none"; //Hides the login div
  document.getElementById("createSection").style.display = "block"; //Shows the create account div 
});
document.getElementById("returnLogin").addEventListener("click", function(){ //Same as above function just oposite
  document.getElementById("loginSection").style.display = "block";
  document.getElementById("createSection").style.display = "none";
});
document.getElementById("faq").addEventListener("click", function(){
  if(document.getElementById("faq").value == "FAQ"){
    document.getElementById("helpSection").style.display = "block";
    document.getElementById("faq").value = "Hide FAQ";
  }
  else if(document.getElementById("faq").value == "Hide FAQ"){
    document.getElementById("helpSection").style.display = "none";
    document.getElementById("faq").value = "FAQ";
  }
});

//These are the simple functions that go along with the users choice wether to accept or deny location use
document.getElementById("no").addEventListener("click", function(){
  window.location.href = "https://www.google.com";
});
document.getElementById("yes").addEventListener("click", function(){
  window.location.href = "actions.php?location=true";
});