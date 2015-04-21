<?php
  session_start();
  if(isset($_SESSION['staff_id'])) {
    header('Location: '.'staff.php');
  } else if(isset($_SESSION['student_id'])) {
    header('Location: '.'student.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sign In</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

  </head>

  <body>
    <div class="container">
      <form class="form-signin" action = "staff.php" method = "post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Staff Id</label>
        <input type="text" name = "staff_id" id="staff_id" class="form-control" placeholder="User Id" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name = "password" id="password" class="form-control" placeholder="Password" required>
        <div class="checkbox"> Sign in as: 
          <label>
            <input type="checkbox" name = "whose" value="student">Student
          </label>
          <label>
            <input type="checkbox" name = "whose" value="staff">Staff
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
  </body>
</html>
