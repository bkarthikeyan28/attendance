<?php
  include ('connection.php');
  ini_set('error_reporting', E_ALL);
  error_reporting(E_ALL);
  session_start();
  if(!isset($_SESSION['student_id'])) {
    header('Location: '.'index.php');
  } else {
    $name = $_SESSION['student_name'];
    $id = $_SESSION['student_id'];
  }
?>
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
            <li><a href = "logout.php">Logout</a></li>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Welcome <?php echo $name; ?></h1>
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
                <th>Classes Attended</th>
                <th>Classes taken</th>
                <th>Classes Bunkable</th>
                <th>Current Percentage</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "SELECT * FROM attendance_data WHERE student_id = '$id'";
                $result = $connection -> query($sql);
                $i = 1;
                while($row = $result -> fetch_assoc()) {
                  $course = $row['course_id'];
                  $sql1 = "SELECT last_updated FROM connector WHERE course_id = '$course'";
                  $result1 = $connection -> query($sql1);
                  $row1 = $result1 -> fetch_assoc();
                  $date = $row1['last_updated'];
                  $attended = $row['classes_attended'];
                  $classes_taken = $row['classes_taken'];
                  $percentage = $row['current_percentage'];
                  $bunkable = $row['classes_bunkable'];
                  if($percentage >= 85) {
                    $f = "<span class=\"label label-success\">$percentage</span>";
                  } else if($percentage >= 75) {
                    $f = "<span class=\"label label-warning\">$percentage</span>";
                  } else {
                    $f = "<span class=\"label label-danger\">$percentage</span>";
                  }
                  echo "<tr>";
                  echo "<td>$i</td>";
                  echo "<td>$course</td>";
                  echo "<td>$date</td>";
                  echo "<td>$attended</td>";
                  echo "<td>$classes_taken</td>";
                  echo "<td>$bunkable</td>";
                  echo "<td>$f</td>";
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