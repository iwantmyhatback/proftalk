<?php

// If logged in
if (!$_SESSION['userUid']){ header("Location: /account-guest.php?error=notloggedin"); exit(); }

	$stmt = mysqli_stmt_init($conn);
	$acct = $_SESSION['userUid'];

	if (!mysqli_stmt_prepare($stmt, "SELECT * FROM professor WHERE uName=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
	mysqli_stmt_bind_param($stmt, "s", $acct);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	$rescheck = mysqli_num_rows($result);
	if ($rescheck == 1) {
		if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }
		$asocres = mysqli_fetch_assoc($result);

		$pulluName = $_SESSION['userUid'];
		$pullfname = $asocres['fName'];
		$pulllname = $asocres['lName'];
		$pulluname = $asocres['uName'];
		$pullempl = $asocres['empl'];
		$pullemail = $asocres['email'];
		$pullphone = $asocres['phone'];

		mysqli_free_result($result);
		$asocres = array();
	} else {
		exit();
	}

	if (isset($_POST['createclass']) || isset($_POST['editclass'])) {
		var_dump($_POST);

		$pulluname = $_SESSION['userUid'];
		$email = $_POST['emailNC'];
		$subject = $_POST['subjectNC'];
		$section = $_POST['sectionNC'];
		$phone = $_POST['phoneNC'];
		$date = $_POST['dateNC'];
		$st_hr = $_POST['st-hrNC'];
		$st_min = $_POST['st-minNC'];
		$st_ampm = $_POST['st-ampmNC'];
		$et_hr = $_POST['et-hrNC'];
		$et_min = $_POST['et-minNC'];
		$et_ampm = $_POST['et-ampmNC'];
		$maxseats = $_POST['maxseatsNC'];
		$password = $_POST['passwordNC'];

		if(
			empty($email) ||
			empty($subject) ||
			empty($section) ||
			empty($phone) ||
			empty($date) ||
			empty($st_hr) ||
			empty($st_min) ||
			empty($st_ampm) ||
			empty($et_hr) ||
			empty($et_min) ||
			empty($et_ampm) ||
			empty($maxseats) ||
			empty($password)
		) {

			printf("</br>");
			printf("</br>");
			printf("</br>");
			printf("</br>");

			printf("<b>&nbsp&nbsp [ERROR] Following Categories:</b>");
			printf("</br> 	&nbsp; 	&nbsp; 	&nbsp;Username: %s", $_SESSION['userUid'] );
			printf("</br> 	&nbsp; 	&nbsp; 	&nbsp;Email: %s",$email );
			printf("</br> 	&nbsp; 	&nbsp; 	&nbsp;Subject: %s",$subject );
			printf("</br> 	&nbsp; 	&nbsp; 	&nbsp;Section: %s",$section );
			printf("</br> 	&nbsp; 	&nbsp; 	&nbsp;Phone: %s",$phone );
			printf("</br> 	&nbsp; 	&nbsp; 	&nbsp;Date: %s",$date );
			printf("</br> 	&nbsp; 	&nbsp; 	&nbsp;Start Time: %s:%s %s",$st_hr, $st_min, $st_ampm );
			printf("</br> 	&nbsp; 	&nbsp; 	&nbsp;End Time: %s:%s %s",$et_hr, $et_min, $et_ampm );
			printf("</br> 	&nbsp; 	&nbsp; 	&nbsp;MaxSeats: %s",$maxseats );
			printf("</br> 	&nbsp; 	&nbsp; 	&nbsp;Password: %s",$password );
			printf("</br><b>&nbsp &nbspNeed, missing information!!!</b>");
			printf("</br></br>&nbsp&nbsp&nbsp&nbsp&nbsp<a href='/proftalk/php/editclasses.php'>Return To Class Schedule</a>");
			exit();
		}
			else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $pulluname)) {
				printf("</br>");
				printf("</br>");
				printf("</br>");
				printf("</br>");

				printf("<b>&nbsp &nbsp [ERROR] Email is invalid! Using Special Characters!</b>");
				printf("</br></br>&nbsp&nbsp&nbsp&nbsp&nbsp<a href='/proftalk/php/editclasses.php'>Return To Class Schedule</a>");
				exit();
			}
			else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				printf("</br>");
				printf("</br>");
				printf("</br>");
				printf("</br>");

				printf("<b>&nbsp &nbsp [ERROR] Email is Invalid!<b>");
				printf("</br></br>&nbsp&nbsp&nbsp&nbsp&nbsp<a href='/proftalk/php/editclasses.php'>Return To Class Schedule</a>");
				exit();
			}
			else if(!preg_match("/^[a-zA-Z0-9]*$/", $pulluname)) {
				printf("</br>");
				printf("</br>");
				printf("</br>");
				printf("</br>");

				printf("<b>&nbsp &nbsp [ERROR] Email is invalid! Using Special Characters!</b>");
				printf("</br></br>&nbsp&nbsp&nbsp&nbsp&nbsp<a href='/proftalk/php/editclasses.php'>Return To Class Schedule</a>");
				exit();
		} else {
				$stmt = mysqli_stmt_init($conn);
				$acct = $_SESSION['userUid'];

				if(!mysqli_stmt_prepare($stmt, "SELECT subject FROM class WHERE subject=?;")) {
					header("Location: ../editclasses.php?error=sqlerror"); exit();
				}
				else {
					mysqli_stmt_bind_param($stmt, "s", $subject);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);
					$resultCheck = mysqli_stmt_num_rows($stmt);
					if ($resultCheck>0 && !isset($_POST['editclass']))
					{
						printf("</br></br></br></br></br></br></br></br> &nbsp &nbsp &nbsp Your Class: %s</br> &nbsp &nbsp &nbsp Section: %s </br>&nbsp &nbsp  SubjectID Is Already Taken", $subject, $section );
						printf("</br></br>&nbsp&nbsp&nbsp&nbsp&nbsp<a href='/proftalk/php/editclasses.php'>Return To Class Schedule</a>");
						exit();
					} else {
						$stmt = mysqli_stmt_init($conn);

						if(!mysqli_stmt_prepare($stmt,
							(!isset($_POST['editclass']) ? "
							INSERT INTO class (
							  classID, classNum, prof_ID,
							  email, subject, section,
							  phone, start_time, end_time,
							  max_seats, used_seats, password
							) VALUES (
							  NULL, 0, ?,
							  ?, ?, ?,
							  ?, ?, ?,
							  ?, 0, ?
							);" : "
							UPDATE class
								SET email=?, subject=?, section=?,
								phone=?, start_time=?, end_time=?,
								max_seats=?, password=?
							WHERE subject = ? AND prof_ID = ?;
							" )
						)) {
							printf("%s", $acct);
							header("Location: ../editclasses.php?error=sqlerror");
							exit();
						} else {
							$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

							{ // Starting Time Stamp, Input Start-Time, To military Time, Store as Unix number
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

								$max_seats_int = (int)($maxseats);


								if(!isset($_POST['editclass']))
									$stmt->bind_param("sssssiiis", $acct, $email, $subject, $section, $phone, $avid_StartTimeStamp, $avid_EndTimeStamp, $max_seats_int, $password );
								else
									$stmt->bind_param("ssssiiisss", $email, $subject, $section, $phone, $avid_StartTimeStamp, $avid_EndTimeStamp, $max_seats_int, $password, $_POST['editclass'], $acct );
								printf("EXEC");


								if(!mysqli_stmt_execute($stmt)) {
									echo "ERROR: ". mysqli_error($stmt);
								} else {
									echo "SUCCESS";
								}
							}
						}
				}
			}
		}
	}


	if (isset($_POST['removeclass'])) {
		$stmt = mysqli_stmt_init($conn);
		$acct = $_POST['removeclass'];

		if (!mysqli_stmt_prepare($stmt, "DELETE FROM class WHERE subject=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
		mysqli_stmt_bind_param($stmt, "s", $acct);
		mysqli_stmt_execute($stmt);
	}

	if (isset($_POST['editclass'])) {
	}
?>
