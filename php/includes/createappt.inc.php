<?php

	if (!$_SESSION['userUid']){
		header("Location: /account-guest.php?error=notloggedin");
		exit();
	} else {

		$stmt = mysqli_stmt_init($conn);
		$acct = $_SESSION['userUid'];

		/* check statement prepare failure */
		if (!mysqli_stmt_prepare($stmt, "SELECT * FROM student WHERE uName=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
		else {
			mysqli_stmt_bind_param($stmt, "s", $acct);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
		}

		$rescheck = mysqli_num_rows($result);

		if ($rescheck == 1) {
			if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }

			$asocres = mysqli_fetch_assoc($result);
			$pullfname = $asocres['fName'];
			$pulllname = $asocres['lName'];
			$pulluname = $asocres['uName'];
			$pullempl = $asocres['empl'];

				$asocres = array();

				$asocres = array();
				$pullprof = array();
				$pullclass = array();
				$pullstart = array();
				$pullend = array();
				$pullroom = array();

				mysqli_free_result($result);
				$stmt = mysqli_stmt_init($conn);
				$acct = $_SESSION['userUid'];

				if (!mysqli_stmt_prepare($stmt, "SELECT * FROM enrolled WHERE studentID=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
				else{
					mysqli_stmt_bind_param($stmt, "s", $acct);
					mysqli_stmt_execute($stmt);
					$resultz = mysqli_stmt_get_result($stmt);

					while ($enrolledRow = mysqli_fetch_assoc($resultz))
					{
						//$stmt = mysqli_stmt_init($conn);
						if (!mysqli_stmt_prepare($stmt, "SELECT * FROM class WHERE subject=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
						else {
							mysqli_stmt_bind_param($stmt, "s", $enrolledRow['classID']);
							mysqli_stmt_execute($stmt);
							$resulte = mysqli_stmt_get_result($stmt);


							while ($row = mysqli_fetch_assoc($resulte))
							{
								array_push($pullprof, $row['prof_ID']);
								array_push($pullclass, $row['classID']);
								array_push($pullstart, $row['start_time']);
								array_push($pullend, $row['end_time']);
								array_push($pullroom, $row['section']);
							}
							mysqli_free_result($resulte);
						}
					}

					mysqli_free_result($resultz);


				}
				if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}

		} else {

			//Start Professor

			mysqli_free_result($result);
			$stmt = mysqli_stmt_init($conn);
			$sql = "SELECT * FROM professor WHERE uName=?;";
			$acct = $_SESSION['userUid'];

			if (!mysqli_stmt_prepare($stmt, $sql))
				{
					header("Location: ../index.php?error=sqlerror");
					exit();
				}
			else{
			/* bind variable to statement placeholder */
			mysqli_stmt_bind_param($stmt, "s", $acct);
			/* execute sql statement in database */
			mysqli_stmt_execute($stmt);
			/* set $result as returned information */
			$result = mysqli_stmt_get_result($stmt);
			}
			/* check connection */
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
		/* fetch result and returna s associative array */
			$asocres = mysqli_fetch_assoc($result);
		/* creating variables for parts of array to be used in page */
			$pullfname = $asocres['fName'];
			$pulllname = $asocres['lName'];
			$pulluname = $asocres['uName'];
			$pullempl = $asocres['empl'];
			/*$pullemail = $asocres['email'];*/
			mysqli_free_result($result);


		//End Professor
				$stmt = mysqli_stmt_init($conn);

				if (!mysqli_stmt_prepare($stmt, "SELECT * FROM appointment WHERE prof_ID=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
				else{
					mysqli_stmt_bind_param($stmt, "s", $pulluname);
					mysqli_stmt_execute($stmt);
					$resultzz = mysqli_stmt_get_result($stmt);

					$pullprof = array();
					$pullstudent = array();
					$pullclass = array();
					$pullstart = array();
					$pullend = array();
					$pullroom = array();
					$pullapptID = array();

					while ($row = mysqli_fetch_assoc($resultzz))
					{
						array_push($pullprof, $row['prof_ID']);
						array_push($pullclass, $row['classID']);
						array_push($pullstart, $row['start_time']);
						array_push($pullend, $row['end_time']);
						array_push($pullroom, $row['room']);
						array_push($pullstudent, $row['studentID']);
						array_push($pullapptID, $row['appointmentID']);
					}

					mysqli_free_result($resultzz);
				}
				if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}



				if (!mysqli_stmt_prepare($stmt, "SELECT * FROM class WHERE prof_ID=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
				else{
					mysqli_stmt_bind_param($stmt, "s", $pulluname);
					mysqli_stmt_execute($stmt);
					$resultzz = mysqli_stmt_get_result($stmt);

					$getsubjects = array();

					while ($row = mysqli_fetch_assoc($resultzz))
					{
						array_push($getsubjects, $row['subject']);
					}

					mysqli_free_result($resultzz);
				}
				if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}
		}
	}

	if(isset($_POST['dropappt'])) {
		$stmt = mysqli_stmt_init($conn);
		$acct = $_POST['dropappt'];

		if (!mysqli_stmt_prepare($stmt, "DELETE FROM appointment WHERE appointmentID=?")) { exit(); }
		mysqli_stmt_bind_param($stmt, "s", $acct );
		mysqli_stmt_execute($stmt);

		echo "<script>window.location.href = '/proftalk/php/createappt.php';</script>";
	}

	if(isset($_POST['clearappt'])) {
		$stmt = mysqli_stmt_init($conn);
		$acct = $_POST['clearappt'];

		if (!mysqli_stmt_prepare($stmt, "UPDATE appointment SET studentID='' WHERE appointmentID=?")) { exit(); }
		mysqli_stmt_bind_param($stmt, "s", $acct );
		mysqli_stmt_execute($stmt);

		echo "<script>window.location.href = '/proftalk/php/createappt.php';</script>";
	}

	if (isset($_POST['createappt']) || isset($_POST['editappt'])) {
		$classSelect = $_POST['classSelectNC'];
		$date = $_POST['dateNC'];
		$st_hr = $_POST['st-hrNC'];
		$st_min = $_POST['st-minNC'];
		$st_ampm = $_POST['st-ampmNC'];
		$et_hr = $_POST['et-hrNC'];
		$et_min = $_POST['et-minNC'];
		$et_ampm = $_POST['et-ampmNC'];
		$roomNum = $_POST['roomNumNC'];

		if(
			empty($classSelect) ||
			empty($date) ||
			empty($st_hr) ||
			empty($st_ampm) ||
			empty($et_hr) ||
			empty($et_ampm) ||
			empty($roomNum)) {
			printf("</br>");
			printf("</br>");
			printf("</br>");
			printf("</br>");
			printf("</br><b>&nbsp &nbspNeed, missing information!!! (EX: Room Number, Date)</b>");
		} else {
			$stmt = mysqli_stmt_init($conn);
			$sql = "";

			if(isset($_POST['createappt'])) {
				$sql = "INSERT INTO appointment ( appointmentID, studentID, prof_ID, classID, start_time, end_time, room )
				VALUES ( NULL, '', ?, ?, ?, ?, ? )";
			} else { // editappt
				printf("UPDATE!!!");
				$sql = "UPDATE appointment SET classID=?, start_time=?, end_time=?, room=? WHERE appointmentID=?";
			}

			if  (!mysqli_stmt_prepare($stmt, $sql)) { header("Location: ../index.php?error=sqlerror"); exit(); }
			else{
				// Time Stamp to Unix
				$avid_StartTimeStamp = $date . " ";
				if($st_ampm == "PM") {
					$militaryHR = (int)$st_hr;
					if($st_hr != "12")
						$avid_StartTimeStamp .= (string)(($militaryHR + 12));
					else
						$avid_StartTimeStamp .= "12";
				} else {
					if($st_hr != "12")
						$avid_StartTimeStamp .= $st_hr;
					else
						$avid_StartTimeStamp .= "00";
				}
				$avid_StartTimeStamp .= ":";
				$avid_StartTimeStamp .= ( $st_min == "0" ? "00" : $st_min );
				$avid_StartTimeStamp .= ":00";
				$avid_StartTimeStamp = strtotime($avid_StartTimeStamp);
				// Time Stamp to Unix
				$avid_EndTimeStamp = $date . " ";
				if($et_ampm == "PM") {
					$militaryHR = (int)$et_hr;
					if($et_hr != "12")
						$avid_EndTimeStamp .= (string)(($militaryHR + 12));
					else
						$avid_EndTimeStamp .= "12";
				} else {
					if($et_hr != "12")
						$avid_EndTimeStamp .= $et_hr;
					else
						$avid_EndTimeStamp .= "00";
				}
				$avid_EndTimeStamp .= ":";
				$avid_EndTimeStamp .= ( $et_min == "0" ? "00" : $et_min );
				$avid_EndTimeStamp .= ":00";
				$avid_EndTimeStamp = strtotime($avid_EndTimeStamp);

				if(isset($_POST['createappt'])) {
					mysqli_stmt_bind_param($stmt, "ssiis", $pulluname, $classSelect, $avid_StartTimeStamp, $avid_EndTimeStamp, $roomNum );
				} else {
					// editappt
					mysqli_stmt_bind_param($stmt, "siiss", $classSelect, $avid_StartTimeStamp, $avid_EndTimeStamp, $roomNum, $_POST['editappt'] );
				}

				mysqli_stmt_execute($stmt);

				echo "<script>window.location.href = '/proftalk/php/createappt.php';</script>";
			}
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}

		}
	}
?>
