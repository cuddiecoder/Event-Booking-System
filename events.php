<?php include('server.php') ?>
<?php
   if(isset($_SESSION['mobile'])){ // checks if the user is logged in  
   }
   else{
      header("location: index.php"); // redirects if user is not logged in
   }
   ?>
<?php 
  if (isset($_GET['book'])) {
    $concert_id = $_GET['book'];
    $count = mysqli_query($db, "SELECT * FROM concert WHERE concert_id=$concert_id");

    if (isset($count->num_rows) && $count->num_rows > 0 ) {
      $n = mysqli_fetch_array($count);
      $concert_date = $n['concert_date'];
      $concert_band = $n['band_id'];
      $concert_venue = $n['venue_id'];
      
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>

<body>

    <h4>Welcome to Free-Gigs,the Free Concert Website</h4>

    <div class="wrapper">
        <header>
            <p><strong><?php echo $_SESSION['firstname']; ?></strong></p>
        </header>

        <section>
            <nav>
                <ul>
                    <h4><a href="events.php">Booking Area </a></h4>



                    <!-- notification message -->

                    <p><strong>Welcome <?php echo $_SESSION['firstname']; ?></strong></p>

                    <p> <a href="logout.php" style="color: red;">logout</a> </p>
                </ul>
            </nav>

            <div id="content-wrap">
                <div id="info-wrap">
                    <div class="info">
                        <h3>Upcoming Concerts</h3>
                        <form action="events.php?book=<?php echo $row['concert_id']; ?>" method="post">
                            <?php include('errors.php'); ?>
                            <!-- <input type="hidden" name="concert_id" value="<?php echo $concert_id; ?>"> -->
                            <?php $results = mysqli_query($db, "SELECT c.concert_id,c.concert_date,v.venue_name,v.venue_capacity,v.venue_id,b.band_id,b.band_name FROM concert as c JOIN venue v ON c.venue_id = v.venue_id JOIN band as b WHERE c.band_id = b.band_id"); ?>

                            <table class="table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Band</th>
                                        <th>Venue</th>
                                        <th>Capacity</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>

                                <?php 
  
                                  while ($row = mysqli_fetch_array($results)) { 

                                    if (strtotime($row['concert_date']) > time()) {
                               ?>
                                <tr>
                                    <input type="hidden" name="concert_id" value="<?php echo $row['concert_id']; ?>">
                                    <td><?php echo $row['concert_date']; ?></td>
                                    <input type="hidden" name="concert_date" value='<?php echo $row['concert_date'] ?>'>
                                    <td><?php echo $row['band_name']; ?></td>
                                    <input type="hidden" name="concert_band" value='<?php echo $row['concert_band'] ?>'>
                                    <td><?php echo $row['venue_name']; ?></td>
                                    <input type="hidden" name="concert_venue"
                                        value='<?php echo $row['concert_venue'] ?>'>

                                    <td>
                                        <?php
                                     $count = mysqli_query($db,"SELECT count('booking_id') FROM booking WHERE concert_id=".$row['concert_id']."");
                                    while($row1 = mysqli_fetch_array($count)){
                                        echo "$row1[0]";
                                    }
                                    ?> /
                                        <?php echo $row['venue_capacity']?>
                                    </td>
                                    <td>
                                        <?php
                                    $count = mysqli_query($db,"SELECT count('booking_id') FROM booking WHERE concert_id=".$row['concert_id']."");
                                    while($row1 = mysqli_fetch_array($count)){
                                    if($row1[0] == $row['venue_capacity']){
                                        echo "Fully booked";
                                    }
                                    else{
                                        echo "<a href='events.php?book=".$row['concert_id']."' class='btn'
                                            name='book' type='submit'>book</a>"; 

                                    }
                                }
                                    ?>
                                    </td>

                                </tr>

                                <?php  
}
} 
  ?>
                            </table>
                        </form>
                    </div>
                </div>
                <!--booking a concert-->
                <div class="info">
                    <h3> My Bookings</h3>
                    <?php 
                    $user_id=$_SESSION['user_id'];
                    $results = mysqli_query($db, "SELECT bk.booking_id,c.concert_date,b.band_name,v.venue_name FROM booking as bk JOIN users as u ON bk.user_id=u.user_id JOIN concert as c JOIN venue v ON c.venue_id = v.venue_id JOIN band as b ON c.band_id = b.band_id ON bk.concert_id = c.concert_id WHERE u.user_id=$user_id"); ?>
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
                                <a href="events.php?cancel=<?php echo $row['booking_id']; ?>"
                                    onclick="return confirm('Are you sure you want to cancel?')"
                                    class="edit_btn">cancel</a>
                            </td>
                        </tr>
                        <?php 
}
}
   ?>
                    </table>

                </div>
            </div>
        </section>

        <footer>
            <p>Free-Gigs <?php echo date("Y");?></p>
        </footer>
    </div>

</body>

</html>