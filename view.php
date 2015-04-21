<?php
  include('connection.php');
  session_start();
  if(!isset($_SESSION['staff_id'])) {
    
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Attendance Management</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="../../dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">

  </head>

  <body role="document">
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
            <li><a href="staff.php">Home</a></li>
            <li class = "active"><a href="view.php">View</a></li>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container theme-showcase" role="main">

      <div class="jumbotron">
        <h1>Welcome <?php echo $_SESSION['staff_name']; ?></h1>
      </div>


      <div class="page-header">
        <h2>Attendance details of Students</h2>
      </div>     
      <?php 
        $id = $_SESSION['staff_id'];
        $sql = "SELECT * FROM connector WHERE staff_id = '$id'";
        $result = $connection -> query($sql);
        while($row = $result -> fetch_assoc()) {
          $course = $row['course_id'];
          echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#$course\" data-whatever=\"C1\">Check for course $course</button><br><br>";
          $temp = "SELECT * FROM attendance_data WHERE course_id = '$course'";
          $res = $connection -> query($temp);
          $safe = "";
          $ok = "";
          $danger = "";
          while($row1 = $res -> fetch_assoc()) {
            if($row1['current_percentage'] >= 85) {
              $id = $row1['student_id'];
              $safe = $safe.$id.', ';
            } else if($row1['current_percentage'] > 75 && $row1['current_percentage'] < 85) {
              $id = $row1['student_id'];
              $ok= $ok.$id.', ';
            } else {
              $id = $row1['student_id'];
              $danger= $danger.$id.', ';
            }
          }
          ?>
          <div class="modal fade" id="<?php echo $course ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="exampleModalLabel">Attendance Status</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="panel panel-success">
                    <div class="panel-heading">
                      <h3 class="panel-title">Students with attendance greater than 85%</h3>
                      <h3><span class="label label-success">Safe Attendance</span>
                    </div>
                    <div class="panel-body">
                      <?php echo $safe; ?>
                    </div>
                  </div>
                  <div class="panel panel-warning">
                    <div class="panel-heading">
                      <h3 class="panel-title">Students with attendance greater than 75%</h3>
                      <h3><span class="label label-warning">Warn Them</span></h3>
                    </div>
                    <div class="panel-body">
                      <?php echo $ok; ?>
                    </div>
                  </div>
                  <div class="panel panel-danger">
                    <div class="panel-heading">
                      <h3 class="panel-title">Students with attendance less than 75%</h3>
                      <h3><span class="label label-danger">Lacking</span></h3>
                    </div>
                    <div class="panel-body">
                      <?php echo $danger; ?>
                    </div>
                  </div>
              </div> 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <?php
        }
      ?>
    </div>
    <script src="../../dist/js/jquery.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
