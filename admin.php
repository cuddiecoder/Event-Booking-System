<?php include('server.php') ?> 

#This is the comments
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>
<body>

<h4>Welcome to Free-Gigs,the Free Concert Website</h4>

<div class="wrapper">
<header>
  <h3><a href="index.php"> Home</a></h3>
</header>
<section>
	 <h4>Admin Login</h4>       
          <div class="form_settings">
            <form id="login-form" class="form" action="admin.php" method="post">

              <?php include('errors.php'); ?>

            <p><span>Username</span><br>
              <input class="contact" type="text" name="username" value="" /></p>
            <p><span>Password</span><br>
              <input class="contact" type="password" name="password" id="typepass" value="" /></p>
    
            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="login_admin" value="submit" /></p>
          </form>
          </div>       
      </div>
    </div>

</section>
 <footer>
  <p>Free-Gigs <?php echo date ("Y");  ?></p>
</footer>
</div>

</body>
</html>
