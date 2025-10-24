
<?php include('server.php') ?>
<?php
   if(! empty($_SESSION['username'])){ // checks if the user is logged in  
   }
   else{
      header("location: index.php"); // redirects if user is not logged in
   }
   ?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>

<body>

<h4>Welcome to Free-Gigs,the Free Concert Website</h4>

<div class="wrapper">
<header>
      <p><strong><?php echo $_SESSION['username']; ?></strong></p>
      
</header>


<section>
  <div>
    <nav>
    <ul>
      <h4>Admin Area</h4>
 <p><strong>Welcome <?php echo $_SESSION['username']; ?></strong></p>

      <p> <a href="bands.php" style="color: blue;">Manage Bands</a> 
        </p><p> <a href="venues.php" style="color: blue;">Manage Venues</a> </p>
        <p> <a href="concerts.php" style="color: blue;">Manage Concerts</a> </p>
        <p> <a href="logout.php" style="color: red;">logout</a> </p>
      </ul>
  </nav>
  <div id="content-wrap">
        <div id="info-wrap">
        <div class="info"> <h5>Current bands</h5>      
           <?php $results = mysqli_query($db, "SELECT * FROM band"); ?>
           <table>
  <thead>
    <tr>
      <th>Band Id</th>
      <th>Band Name</th>
    
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) { ?>
    <tr>
      <td><?php echo $row['band_id']; ?></td>
      <td><?php echo $row['band_name']; ?></td>
    </tr>
  <?php } ?>
</table>
          </div> 


<div class="info"> <h5>Available Venues</h5>      
           <?php $results = mysqli_query($db, "SELECT * FROM venue"); ?>
           <table>
  <thead>
    <tr>
     <th>Venue Id</th>
     <th>Venue Name</th>
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) { ?>
    <tr>
       <td><?php echo $row['venue_id']; ?></td>
       <td><?php echo $row['venue_name']; ?></td>
    </tr>
  <?php } ?>
</table>
          </div>
        </div>

        <!--concert addition-->
          <div class="info"> <h5>Concerts</h5> 
             
           <?php $results = mysqli_query($db, "SELECT c.concert_date,b.band_name,v.venue_name FROM concert as c JOIN venue v ON c.venue_id = v.venue_id JOIN band as b WHERE c.band_id = b.band_id"); 
            ?>
           <table>
  <thead>
    <tr>
      <th>Date</th>
      <th>Band</th>
      <th>Venue</th>
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) {


  if (strtotime($row['concert_date']) > time()) { ?>
    <tr>
      <td><?php echo $row['concert_date']; ?></td>
      <td><?php echo $row['band_name']; ?></td>
      <td><?php echo $row['venue_name']; ?></td>
    </tr>
  <?php 

} 
}?>
</table>

          </div>
          </div>  
        </div>
</section>
<footer>
 <p>Free-Gigs <?php echo date("Y");?></p>
</footer>
</body>
</html>
