<?php
  include ('connection.php');
  ini_set('error_reporting', E_ALL);
  error_reporting(E_ALL);
  session_start();
  if(!isset($_POST['whose'])) {
    if(!isset($_SESSION['staff_id']))
      header('Location: '.'index.php');
  }
  if(isset($_POST['staff_id'])) {
    if($_POST['whose'] == 'staff') {
      $id = $_POST['staff_id'];
      $pass = $_POST['password'];
      $sql = "SELECT staff_name FROM staff WHERE staff_id = '$id' AND pass = MD5('$pass')";
      $result = $connection -> query($sql);
      if($result -> num_rows == 1) {
        while($data = $result -> fetch_assoc()) {
          $name = $data['staff_name'];
        }
        $f = 1;
        $_SESSION['staff_id'] = $id;
        $_SESSION['staff_name'] = $name;
      } else {
        header('Location: '.'index.php');
      }
    } else {
      $id = $_POST['staff_id'];
      $pass = $_POST['password'];
      echo $id;
      echo $pass;
      $sql = "SELECT student_name FROM student WHERE student_id = '$id' AND pass = MD5('$pass')";
      $result = $connection -> query($sql);
      if($result -> num_rows == 1) {
        while($data = $result -> fetch_assoc()) {
          $name = $data['student_name'];
        }
        $f = 1;
        $_SESSION['student_id'] = $id;
        $_SESSION['student_name'] = $name;
        header('Location: '.'student.php');
      } else {
        header('Location: '.'index.php');
      }
    }
  } else if(!isset($_SESSION['staff_id'])) {
    header('Location: '.'index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Attendance Management</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="../../dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">

  </head>
  <script type="text/javascript">
  function sub() {
    if($('#course_code').val() == '') {
      $('#error_update').show();
    } else {
      $('#change').submit(function(event) {
        $('#success_update').show();
        $('#error_update').hide();
        alert("Form Submitted");
        return true;
      });
      $('#change').submit();
    }
  }

  </script>
  <body role="document">

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Attendance Management</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="view.php">View</a></li>
            <li><a href = "logout.php">Logout</a></li>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Welcome <?php echo $_SESSION['staff_name']; ?></h1>
      </div>


      <div class="page-header">
        <h2>Select the task you want to perform</h2>
      </div>

      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Update" data-whatever="C1">Update attendance</button><br><br>
      <button type="button" class="btn btn-primary" onclick = "document.location = 'view.php';">Check attendance</button><br><br>


      <div class="modal fade" id="Update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="exampleModalLabel">Update Attendance</h4>
            </div>
            <div class="modal-body">
              <div class="alert alert-success" id = "success_update" role="alert" style = 'display:none;'>
                <strong>Everything OK.Please wait while updating ....</strong>.
              </div>
              <div class="alert alert-danger" id = "error_update" role="alert" style = 'display:none;'>
                <strong>Please recheck whether you have entered everything</strong>.
              </div>
              <form id = "change" action = "update.php", method = "post">
                <div class="form-group">
                  <label for="recipient-name" class="control-label">Course Code: </label>
                  <input type="text" class="form-control" name = "course_code" id="course_code" required>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="control-label">Date: </label>
                  <input type="date" class="form-control" name = "date_added" id="date_added" required>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="control-label">No of classes: </label>
                  <input type="text" class="form-control" name = "no_of_classes" id="no_of_classes" required>
                </div>
                <div class="form-group">
                  <label for="message-text" class="control-label">Absentees(Seperated by Commas): </label>
                  <textarea class="form-control" name = "absentees" id="absentees" required></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="sub(); return true;">Update</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="Check" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="exampleModalLabel">Check Attendance</h4>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="recipient-name" class="control-label">Course Code: </label>
                  <input type="text" class="form-control" name = "course_code" id="course_code">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Check</button>
            </div>
          </div>
        </div>
      </div>
     

      <div class="page-header">
        <h2>Current data</h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Course Code</th>
                <th>Last Updated</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $id = $_SESSION['staff_id'];
                $sql = "SELECT * FROM connector WHERE staff_id = '$id'";
                $result = $connection -> query($sql);
                $i = 1;
                while($row = $result -> fetch_assoc()) {
                  $course = $row['course_id'];
                  $last = $row['last_updated'];
                  echo "<tr>";
                  echo "<td>$i</td>";
                  echo "<td>$course</td>";
                  echo "<td>$last</td>";
                  echo "</tr>";
                  $i++;
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    <script src="../../dist/js/jquery.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
