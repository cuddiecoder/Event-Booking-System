<?php 
// Include the server-side logic or configuration (e.g., database connection, session handling)
include('server.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<?php 
// Include the header file (typically contains meta tags, stylesheets, or navigation)
include('header.php');
?>

<body>

  <!-- Page Title -->
  <h4>Welcome to Free-Gigs, the Free Concert Website</h4>

  <div class="wrapper">

    <header>
      <!-- Navigation link to homepage -->
      <h3><a href="index.php">Home</a></h3>
    </header>

    <section>
      <h4>Admin Login</h4>

      <div class="form_settings">
        <!-- Login form for admin users -->
        <form id="login-form" class="form" action="admin.php" method="post">

          <?php 
          // Include any error messages (e.g., failed login, validation errors)
          include('errors.php'); 
          ?>

          <!-- Username field -->
          <p>
            <span>Username</span><br>
            <input class="contact" type="text" name="username" value="" />
          </p>

          <!-- Password field -->
          <p>
            <span>Password</span><br>
            <input class="contact" type="password" name="password" id="typepass" value="" />
          </p>

          <!-- Submit button -->
          <p style="padding-top: 15px">
            <span>&nbsp;</span>
            <input class="submit" type="submit" name="login_admin" value="Submit" />
          </p>

        </form>
      </div>       
    </section>

    <footer>
      <!-- Dis
