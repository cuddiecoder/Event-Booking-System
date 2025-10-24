<?php
session_start();
// initializing variables
$firstname = "";
$mobile = "";
$band_name = "";
$venue_name ="";
$venue_capacity ="";
$concert_band ="";
$concert_venue ="";
$concert_id="";
$concert_age ="";
$booking_id ="";
$dob="";
$now = time();
$update = false;
$errors = array();


// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration1');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
  $mobile = mysqli_real_escape_string($db, $_POST['mobile']);
  $dob = mysqli_real_escape_string($db, $_POST['dob']);
  $password_1 = mysqli_real_escape_string($db, $_POST['passid']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($firstname)) { array_push($errors, "First Name is required"); }
  if (empty($lastname)) { array_push($errors, "Last Name is required"); }
  if (empty($mobile)) { array_push($errors, "Mobile number is required"); }
  if (empty($dob)) { array_push($errors, "Date of birth is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same mobile number
  $user_check_query = "SELECT * FROM users WHERE mobile='$mobile'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['mobile'] === $mobile) {
      array_push($errors, "User already exists");
    }

  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$dob = date('Y-m-d', strtotime($dob));
    $query = "INSERT INTO users (firstname,lastname,mobile,dob,password) 
  			  VALUES('$firstname','$lastname','$mobile','$dob','$password')";
  	mysqli_query($db, $query);
  	$_SESSION["mobile"] = $mobile;
    $_SESSION["firstname"] = $firstname;
  	header('location: events.php');
  }
}

// ... 

// LOGIN USER
if (isset($_POST['login_user'])) {
  $mobile = mysqli_real_escape_string($db, $_POST['mobile']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($mobile)) {
    array_push($errors, "Mobile Number is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password);

   $sql = ("SELECT Firstname, Lastname, DOB,user_id FROM users WHERE mobile='$mobile' AND password='$password'");

if ($result = mysqli_query($db, $sql)) {

    /* fetch associative array */
  while ($row = mysqli_fetch_assoc($result)) {
     $firstname= $row["Firstname"];
     $lastname=$row["Lastname"];
     $dob=$row["DOB"];
     $user_id=$row["user_id"];

     //storing session values
     $_SESSION["firstname"] = $firstname;
     $_SESSION["lastname"] = $lastname;
     $_SESSION["dob"] = $dob;
     $_SESSION["user_id"] = $user_id;
  }
}
    

    $query = "SELECT * FROM users WHERE mobile='$mobile' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
    $_SESSION["mobile"] = $mobile;    
      header('location: events.php');
    }else {
      array_push($errors, "Wrong mobile/password combination");
    }
  }
}





// LOGIN Admin
if (isset($_POST['login_admin'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "User Name is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    
    $query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      header('location: dashboard.php');
    }else {
      array_push($errors, "Wrong Username/password combination");
    }
  }
}

//adding band 
if (isset($_POST['addband'])) {
    $band_name = mysqli_real_escape_string($db, $_POST['band_name']);
    // form validation: ensure that the form is correctly filled
    if (empty($band_name)) { array_push($errors, "Band Name is required"); }
    // first check the database to make sure 
  // a BAND does not already exist with the same name
  $query = "SELECT * FROM band WHERE band_name='$band_name'";
  $result = mysqli_query($db, $query);
  $band = mysqli_fetch_assoc($result);
  
  if ($band) { // if band exists
    if ($band['band_name'] === $band_name) {
      array_push($errors, "band already exists");
    }

  }

   if (count($errors) == 0) {
    mysqli_query($db, "INSERT INTO band (band_name) VALUES ('$band_name')"); 
     array_push($errors, "Band Added!");
  }
}
//.....

// ... UPDATING BAND

if (isset($_POST['edit'])) {
  $band_id = $_POST['band_id'];
  $band_name = $_POST['band_name'];
  
if (empty($band_name)) { array_push($errors, "Band Name is required"); }
    // first check the database to make sure 
  // a BAND does not already exist with the same name
  $query = "SELECT * FROM band WHERE band_name='$band_name'";
  $result = mysqli_query($db, $query);
  $band = mysqli_fetch_assoc($result);
  
  if ($band) { // if band exists
    if ($band['band_name'] === $band_name) {
      array_push($errors, "band already exists");
    }

  }

   if (count($errors) == 0) {
  mysqli_query($db, "UPDATE band SET band_name='$band_name' WHERE band_id=$band_id");
  array_push($errors, "Band Updated!");
  }
}
///.....DELETING BAND
if (isset($_GET['del'])) {
  $band_id = $_GET['del'];
  mysqli_query($db, "DELETE FROM band WHERE band_id=$band_id");
array_push($errors, "Band Deleted!");
  header('location: bands.php');
  }

///....
//adding venue
if (isset($_POST['addvenue'])) {
    $venue_name = mysqli_real_escape_string($db, $_POST['venue_name']);
    $venue_capacity = mysqli_real_escape_string($db, $_POST['venue_capacity']);
    // form validation: ensure that the form is correctly filled
    if (empty($venue_name)) { array_push($errors, "Venue Name is required");}
    if (empty($venue_capacity)) { array_push($errors, "Venue Capacity is required"); }
    // first check the database to make sure 
  // a venue does not already exist with the same name
  $query = "SELECT * FROM venue WHERE venue_name='$venue_name'";
  $result = mysqli_query($db, $query);
  $venue = mysqli_fetch_assoc($result);
  
  if ($venue) { // if venue exists
    if ($venue['venue_name'] === $venue_name) {
      array_push($errors, "venue already exists");
    }

  }

   if (count($errors) == 0) {
    mysqli_query($db, "INSERT INTO venue (venue_name, venue_capacity) VALUES ('$venue_name', '$venue_capacity')"); 
      array_push($errors, "Venue added!");
  }
}
//.....

// ... updating venue

if (isset($_POST['resett'])) {
  $venue_id = $_POST['venue_id'];
  $venue_name = $_POST['venue_name'];
    $venue_capacity = $_POST['venue_capacity'];
  
 if (empty($venue_name)) { array_push($errors, "Venue Name is required"); }
  if (empty($venue_capacity)) { array_push($errors, "Venue capacity is required"); }
    // first check the database to make sure 
  // a venue does not already exist with the same name
  $query = "SELECT * FROM venue WHERE venue_name='$venue_name'";
  $result = mysqli_query($db, $query);
  $venue = mysqli_fetch_assoc($result);
  
  if ($venue) { // if venue exists
    if ($venue['venue_capacity'] > $venue_capacity) {
      array_push($errors, "Sorry the capacity cant go lower");
    }

  }

   if (count($errors) == 0) {
  mysqli_query($db, "UPDATE venue SET venue_name='$venue_name', venue_capacity='$venue_capacity' WHERE venue_id=$venue_id");
  array_push($errors, "Venue Updated!");
}
}
///.....deleting venue
if (isset($_GET['del'])) {
  $venue_id = $_GET['del'];
  mysqli_query($db, "DELETE FROM venue WHERE venue_id=$venue_id");
 array_push($errors, "Venue Deleted!");

  
  }


  

  //...adding a concert


if (isset($_POST['addconcert'])) {
    $concert_date = mysqli_real_escape_string($db, $_POST['concert_date']);
    $concert_band = mysqli_real_escape_string($db, $_POST['concert_band']);
    $concert_venue = mysqli_real_escape_string($db, $_POST['concert_venue']);
    $concert_age = mysqli_real_escape_string($db, $_POST['concert_age']) ? 1 : 0;

    // form validation: ensure that the form is correctly filled
    if (empty($concert_date)) { array_push($errors, "Date is required"); }
     if (empty($concert_band)) { array_push($errors, "Band is required"); }
      if (empty($concert_venue)) { array_push($errors, "Venue is required");}
 
//picks band id from bands table to post in concert table
   $sql = "SELECT band_id FROM band WHERE band_name='$concert_band'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result); 
$band_id = $row["band_id"];


  //picks venue id from venue table to post in concert table
$sql = "SELECT venue_id FROM venue WHERE venue_name='$concert_venue'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result); 
$venue_id = $row["venue_id"];

 $concert_date = date("Y-m-d h:i", strtotime($concert_date));
    if (strtotime($concert_date) < time()) {
      array_push($errors, "Date has already passed!");
    }

   if (count($errors) == 0) {


    mysqli_query($db, "INSERT INTO concert (concert_date, band_id, venue_id,over_18) VALUES ('$concert_date', ' $band_id', '$venue_id', '$concert_age')"); 
      array_push($errors, "Concert added!");
  }
} 

// booking a concert 

if (isset($_GET['book'])) {
  $id=$_GET['book'];
  $user_id=$_SESSION['user_id'];

  // first check the database to make sure 
  // a concert does not already exist with the same id for the same user
  $query = "SELECT * FROM booking WHERE concert_id='$id' AND user_id='$user_id'";
  $result = mysqli_query($db, $query);
  $booking = mysqli_fetch_assoc($result);
  
  if ($booking) { // if booking exists
    if ($booking['concert_id'] === $id) {
      array_push($errors, "Already booked this!");
    }

  }
  //check if the user has two upcoming bookings
  $upcomingbookings = "SELECT count('user_id'),c.concert_date FROM booking as b JOIN concert as c ON b.concert_id=c.concert_id WHERE user_id='$id'";
$result=mysqli_query($db,$upcomingbookings);
$rowk=mysqli_fetch_array($result);
if ((strtotime($rowk['concert_date']) > time()) && ($rowk > 2)) {
  array_push($errors, "Maximum bookings reached");
}

  //check if user is less than 18yrs
  $over18="SELECT concert_id,concert_date,over_18 FROM concert WHERE over_18 = '1'";
  $result=mysqli_query($db,$over18);
  $over=mysqli_fetch_array($result);

  $user="SELECT DATE_ADD(DOB, INTERVAL 18 YEAR) DOB,user_id FROM users WHERE  user_id ='$id'";
  $result=mysqli_query($db,$user);
  $age=mysqli_fetch_array($result);

  if((strtotime($over['concert_date']))- (strtotime($age['DOB'])) < 18){
    array_push($errors,"This concert is for over 18 only!!");
  }


  
  
  if(count($errors)== 0){
    //Making a booking
    mysqli_query($db, "INSERT INTO booking (concert_id, user_id) VALUES ('$id','$user_id') ");
         array_push($errors, "Concert Booked!");
  }
}


/////.....cancelling a booking
if (isset($_GET['cancel'])) {
  $booking_id = $_GET['cancel'];
  mysqli_query($db, "DELETE FROM booking WHERE booking_id=$booking_id");
array_push($errors, "Your Booking has been cancelled!");
  header('location: events.php');
  }


?>