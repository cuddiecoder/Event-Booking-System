<?php include('server.php') ?>


<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'header.php';?>
<body onload="firstfocus();">

<h4>Welcome to Free-Gigs,the Free Concert Website</h4>

<div class="wrapper">
<header>
  <h3><a href="index.php"> Home</a></h3>
</header>
<section>
  <div class="container">
<br>  <p class="text-center">Fill all the details to Register </p>
<hr>      
          <div class="form_settings">
            <form id="login-form" class="form" name="registration" action="registration.php" method="post">
            	 <?php include('errors.php'); ?>
            <p><span for= "firstname">First Name</span><br>
            	<input class="contact" type="text"  name="firstname" onblur="allLetter()" value="" /></p>
            <p><span for="lastname">Last Name</span><br>
            	<input class="contact" type="text"  name="lastname" onblur="allLetter()" value=""/></p>
            <p><span for="mobile">Mobile Number</span><br>
            	<input class="contact" type="text"  name="mobile" onblur="mobile_validation(5,12)"value=""/></p>
            <p><span for= "dob">Date of Birth</span><br>
            	<input class="date" type="date"  name="dob" value="" /></p>
            <p><span for= "passid">Password</span><br>
            	<input class="contact" type="password"  name="passid" onblur="passid_validation(7,12)" value="" /></p>
            <p><span>Confirm Password</span><br>
            	<input class="contact" type="password" name="password_2" value="" /></p>
            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="reg_user"/></p>
          </form>
          </div>

</section>
 <footer>
  <p>Free-Gigs <?php echo date ("Y");  ?></p>
</footer>
</div>
</body>
</html>