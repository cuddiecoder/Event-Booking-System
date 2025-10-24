<?php include('server.php') ?>

<?php
   if(! empty($_SESSION['username'])){ // checks if the user is logged in  
   }
   else{
      header("location: index.php"); // redirects if user is not logged in
   }
   ?>
<?php 
  if (isset($_GET['resett'])) {
    $venue_id = $_GET['resett'];
    $update = true;
    $count = mysqli_query($db, "SELECT * FROM venue WHERE venue_id=$venue_id");

    if (isset($count->num_rows) && $count->num_rows > 0 ) {
      $n = mysqli_fetch_array($count);
      $venue_name = $n['venue_name'];
      $venue_capacity = $n['venue_capacity'];
      
    }
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
        </p><p> <a href="venues.php" style="color: blue;">Manage Venues</a> </p>
        <p> <a href="concerts.php" style="color: blue;">Manage Concerts</a> </p>
      <p> <a href="logout.php" style="color: red;">logout</a> </p>
  </nav>
  
  <div id="content-wrap">
        <div id="info-wrap">
        <div class="info"> <h5>Available venues</h5> 
  
<?php $results = mysqli_query($db, "SELECT * FROM venue"); ?>
           <table>
  <thead>
    <tr>
      <th>Venue Id</th>
      <th>Venue Name</th>
      <th>Capacity</th>
       <th></th>
      <th colspan="2">Action</th>
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) { ?>
    <tr>
      <td><?php echo $row['venue_id']; ?></td>
      <td><?php echo $row['venue_name']; ?></td>
       <td><?php echo $row['venue_capacity']; ?></td>
      <td>
        <a href="venues.php?resett=<?php echo $row['venue_id']; ?>" onclick="return confirm('Are you sure you want to edit?')" class="resett_btn" >Edit</a>
      </td>
      <td>
        <a href="server.php?del=<?php echo $row['venue_id']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="del_btn">Delete</a>
      </td>
    </tr>
  <?php } ?>
</table>
<h5>Add Venue</h5> 
            <form id="Add-form" class="form-inline" action="venues.php" method="post">
              <?php include('errors.php'); ?>
              <!--newly added field-->
<input type="hidden" name="venue_id" value="<?php echo $venue_id; ?>">
              <label for="venue">Name:</label>
              <input type="venue_name" id="venue_name" name="venue_name" value="<?php echo $venue_name; ?>">
              <label for="venue">Venue Capacity:</label>
              <input type="venue_capacity" id="venue_capacity" name="venue_capacity" value="<?php echo $venue_capacity; ?>">

  <?php if ($update == true): ?>
  <button class="btn" type="submit" name="resett" style="background: #556B2F;" >Update</button>
<?php else: ?>
  <button class="btn" type="submit" name="addvenue">Add Venue</button>
  <?php endif ?>
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
