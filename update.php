<?php
	include('connection.php');
	session_start();
	if(!isset($_SESSION['staff_id'])) {
		echo "Go get lost";
	} else {
		if(isset($_POST['course_code']) && isset($_POST['date_added']) && isset($_POST['no_of_classes']) && isset($_POST['absentees'])) {
			$staff_id = $_SESSION['staff_id'];
			$course_c = $_POST['course_code'];
			$date_updated = $_POST['date_added'];
			$sql = "UPDATE connector SET last_updated = '$date_updated' WHERE course_id = '$course_c'";
			$connection -> query($sql); 
			$list = explode(",", $_POST['absentees']);
			$course_code = $_POST['course_code'];
			$n = sizeof($list);
			echo $n;
			for($i = 1; $i <= 107; $i++) {
				$f = 0;
				for($j = 0; $j < $n; $j++) {
					if($list[$j] == $i) {
						$f = 1;
						break;
					} else {
						continue;
					}
				}
				$number = $_POST['no_of_classes'];
				if(!$f) {
					$sql = "UPDATE attendance_data SET classes_attended = classes_attended + $number, classes_taken = classes_taken + $number WHERE course_id = '$course_code' AND student_id = '$i'";
					$result = $connection -> query($sql);
					$sql = "SELECT * FROM attendance_data WHERE course_id = '$course_code' AND student_id = '$i'";
					$result = $connection -> query($sql);
					while ($row = $result -> fetch_assoc()) {
						$total = $row['classes_total'];
						$attended = $row['classes_attended'];
						$taken = $row['classes_taken'];
					}
					$percentage = ($attended * 1.0) / $taken;
					$percentage *= 100;
					$bunkable = (0.25 * ($total)) - ($taken - $attended);
					$sql = "UPDATE attendance_data SET current_percentage = '$percentage', classes_bunkable = '$bunkable' WHERE course_id = '$course_code' AND student_id = '$i'";
					$result = $connection -> query($sql);
				} else {
					$sql = "UPDATE attendance_data SET classes_taken = classes_taken + $number WHERE course_id = '$course_code' AND student_id = '$i'";
					$result = $connection -> query($sql);
					$sql = "SELECT classes_total, classes_attended FROM attendance_data WHERE course_id = '$course_code' AND student_id = '$i'";
					$result = $connection -> query($sql);
					while ($row = $result -> fetch_assoc()) {
						$total = $row['classes_total'];
						$attended = $row['classes_attended'];
						$taken = $row['classes_taken'];
					}
					$percentage = ($attended * 1.0) / $taken;
					$percentage *= 100;
					$bunkable = (0.75 * ($total)) - ($taken - $attended);
					$sql = "UPDATE attendance_data SET current_percentage = '$percentage', classes_bunkable = '$bunkable' WHERE course_id = '$course_code' AND student_id = '$i'";
					$result = $connection -> query($sql);
				}
				header('Location: '.'staff.php');
			}
		}
	}

?>