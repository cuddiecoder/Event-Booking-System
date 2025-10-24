
<?php include('server.php') ?>
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
  <nav>
    <ul>
     <h5 class="text-info">You cannot book tickets unless you are logged in</h5>
       <form id="login-form" class="form" action="index.php" method="post">
                           <?php include('errors.php'); ?>
                            <div class="form-group">
                                <label for="username" class="text-info">Mobile:</label><br>
                                <input type="text" name="mobile" id="mobile" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                
                                <input type="submit" name="login_user" class="btn btn-info btn-md" value="Login">
                            </div>
                            <div id="register-link" class="text-left">
                                <a href="registration.php" class="text-info">Click here to Register</a>
                                
                            </div>

                          </form>
      <div>
      	<li><a href="admin.php" class="btn btn-info btn-md" > Admin Login</a></li>
      </div>
    </ul>
  </nav>
  
  <div id="content-wrap">
        <div id="info-wrap">
           <div class="info"> <h3>Upcoming Concerts</h3>
            <form action="" method="post" action= "events.php">
              <?php include('errors.php'); ?>
            <?php $results = mysqli_query($db, "SELECT c.concert_date,v.venue_name,v.venue_id,b.band_id,b.band_name FROM concert as c JOIN venue v ON c.venue_id = v.venue_id JOIN band as b WHERE c.band_id = b.band_id"); ?>
           <table>
  <thead>
    <tr>
      <th>Date</th>
      <th>Band</th>
      <th>Venue</th>
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) { 

  	if (strtotime($row['concert_date']) > time()) {
  
?>
    <tr>
      <td><?php echo $row['concert_date']; ?></td>

      <input type="hidden" name="concert_date" value="<?php echo $row['concert_date'] ?>">
      <td><?php echo $row['band_name']; ?></td>
      <input type="hidden" name="band_name" value="<?php echo $row['band_name'] ?>">
      <td><?php echo $row['venue_name']; ?></td>
      <input type="hidden" name="venue_name" value="<?php echo $row['venue_id'] ?>">

      <td>
    </tr>
  <?php }

  } ?>
</table>
</form>
          </div>
        </div> 
</section>

<footer>
 <p>Free-Gigs <?php echo date("Y");?></p>
</footer>
</div>

</body>
</html>
