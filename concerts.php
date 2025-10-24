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
<?php
   if($_SESSION['username']){ // checks if the user is logged in  
   }
   else{
      header("location: index.php"); // redirects if user is not logged in
   }
   ?>
<body>

<h4>Welcome to Free-Gigs,the Free Concert Website</h4>

<div class="wrapper">
<header>
 
      <p><strong><?php echo $_SESSION['username']; ?></strong></p>
      
</header>

<section>
  <nav>
    <ul>
      <h3> <a href="dashboard.php">Admin Area</a></h3>
      <p> <a href="bands.php" style="color: blue;">Manage Bands</a> 
        </p>
        <p> <a href="venues.php" style="color: blue;">Manage Venues</a> </p>
        <p> <a href="concerts.php" style="color: blue;">Manage Concerts</a> </p>
   <p> <a href="logout.php" style="color: red;">logout</a> </p>
  </nav>
  
   <div id="content-wrap">
        <div id="info-wrap">
        <!--concert addition-->
          <div class="info"> <h5>Concerts</h5>      
           <?php $results = mysqli_query($db, "SELECT concert_id,concert_date,band.band_name,venue.venue_name FROM concert,band,venue WHERE concert.band_id = band.band_id AND concert.venue_id = venue.venue_id"); 


           ?>
           <table>
  <thead>
    <tr>
      <th>Date</th>
      <th>Band</th>
      <th>Venue</th>
      <th colspan="2">Action</th>
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) { 

    if (strtotime($row['concert_date']) > time()) {
      ?>
    <tr>
      <td><?php echo $row['concert_date']; ?></td>
      <td><?php echo $row['band_name']; ?></td>
      <td><?php echo $row['venue_name']; ?></td>
      <td>
    <a href="server.php?del=<?php echo $row['concert_id']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="del_btn">Delete</a>
      </td>
    </tr>
  <?php }
  } ?>
</table>
<h5>Add a Concert</h5> 
          <form id="form1" class="form-inline" method="post" action="concerts.php">
              <?php include('errors.php'); ?>
              <p><span>Date</span><input class="datetime-local" type="datetime-local" name="concert_date" value="" /></p>
              <?php

$mysqli =NEW MYSQLI ('localhost', 'root', '', 'registration1');
               $bandset = $mysqli->query ("SELECT band_name FROM band");?>
             <p><span>Band</span><br>
            <select name="concert_band" value=""/>
             <?php while ($rows =$bandset->fetch_assoc()) {
               $band_concert_name = $rows ['band_name'];
               echo "<option value ='$band_concert_name'> $band_concert_name </option>";
             } 

             ?>
               
             </select>
            <?php

$mysqli =NEW MYSQLI ('localhost', 'root', '', 'registration1');
               $venueset = $mysqli->query ("SELECT venue_name FROM venue");?>
             <p><span>Venue</span><br>
              <select name="concert_venue" value="" >
             <?php while ($rows =$venueset->fetch_assoc()) {
               $venue_concert_name = $rows ['venue_name'];
               echo "<option value ='$venue_concert_name'> $venue_concert_name </option>";
             } 

             ?>
               
             </select>

 18+ Only
 <input type="hidden" name="concert_age" value="0">
 <input type="checkbox" name="concert_age" value="yes" />
            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="addconcert" value="Add Concert" /></p>
  </form>
          </div>
        </div>
</div>  
</div>
</section>

<footer>
 <p>Free-Gigs <?php echo date("Y");?></p>
</footer>
</div>

</body>
</html>
