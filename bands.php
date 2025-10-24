
<?php include('server.php') ?>
<?php
   if(! empty($_SESSION['username'])){ // checks if the user is logged in  
   }
   else{
      header("location: index.php"); // redirects if user is not logged in
   }
   ?>

<?php 
  if (isset($_GET['edit'])) {
    $band_id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM band WHERE band_id=$band_id");

    if (isset($record->num_rows) && $record->num_rows > 0 ) {
      $n = mysqli_fetch_array($record);
      $band_name = $n['band_name'];
      
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
        <div class="info"> <h5>Current bands</h5>      
           <?php $results = mysqli_query($db, "SELECT * FROM band"); ?>
           <table>
  <thead>
    <tr>
       <th>Band Id</th>
       <th>Band Name</th>
      <th colspan="2">Action</th>
    </tr>
  </thead>
  
  <?php while ($row = mysqli_fetch_array($results)) { ?>
    <tr>
      <td><?php echo $row['band_id']; ?></td>
      <td><?php echo $row['band_name']; ?></td>
      <td>
        <a href="bands.php?edit=<?php echo $row['band_id']; ?>" onclick="return confirm('Are you sure you want to edit?')"class="edit_btn" >Edit</a>
      </td>
      <td>
        <a href="server.php?del=<?php echo $row['band_id']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="del_btn">Delete</a>
      </td>
    </tr>
  <?php } ?>
</table>
<h5>Add new band</h5> 
            <form id="Add-form" class="form-inline" action="bands.php" method="post">
              <?php include('errors.php'); ?>
              <!--newly added field-->
<input type="hidden" name="band_id" value="<?php echo $band_id; ?>">
              <label for="band">Name:</label>
              <input type="band" id="band_name" name="band_name" value="<?php echo $band_name; ?>">

  <?php if ($update == true): ?>
  <button class="btn" type="submit" name="edit" style="background: #556B2F;" >Update</button>
<?php else: ?>
  <button class="btn" type="submit" name="addband">Add band</button>
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
