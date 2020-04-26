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
		// STUDENT SCOPE
		if ($rescheck == 1) {
			$isStudent = true;
			if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }

			$asocres = mysqli_fetch_assoc($result);
			$pullfname = $asocres['fName'];
			$pulllname = $asocres['lName'];
			$pulluname = $asocres['uName'];
			$pullempl = $asocres['empl'];

			$asocres = array();
			$asocres = array();
			$pullprof = array();
			$pullsub = array();
			$pullclass = array();
			$pulltime = array();
			$pulldate = array();
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
					if (!mysqli_stmt_prepare($stmt, "SELECT * FROM class WHERE subject=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
					else {
						mysqli_stmt_bind_param($stmt, "s", $enrolledRow['classID']);
						mysqli_stmt_execute($stmt);
						$resulte = mysqli_stmt_get_result($stmt);


						while ($row = mysqli_fetch_assoc($resulte))
						{
							array_push($pullprof, $row['prof_ID']);
							array_push($pullsub, $row['subject']);
							array_push($pullclass, $row['section']);
							array_push($pulltime, $row['start_time']);
							array_push($pulldate, $row['end_time']);
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
			$isProfessor = true;
			// Professor Write Out

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
			mysqli_free_result($result);
			$asocres = array();

				mysqli_free_result($result);
				$stmt = mysqli_stmt_init($conn);
				$sql = "SELECT * FROM class WHERE prof_ID=?;";
				$acct = $_SESSION['userUid'];

				if (!mysqli_stmt_prepare($stmt, $sql)) { header("Location: ../index.php?error=sqlerror"); exit(); }
				else{
					mysqli_stmt_bind_param($stmt, "s", $acct);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
				}
				if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}


			$asocres = array();
			$pullprof = array();
			$pullsub = array();
			$pullclass = array();
			$pulltime = array();
			$pulldate = array();
			$pullroom = array();

			while ($row = mysqli_fetch_assoc($result))
			{
				array_push($pullprof, $row['prof_ID']);
				array_push($pullsub, $row['subject']);
				array_push($pullclass, $row['section']);
				array_push($pulltime, $row['start_time']);
				array_push($pulldate, $row['end_time']);
				array_push($pullroom, $row['section']);
			}

			mysqli_free_result($result);
		}
	}

	if(isset($_POST['dropclass'])) {
		$stmt = mysqli_stmt_init($conn);
		$acct = $_POST['dropclass'];

		if (!mysqli_stmt_prepare($stmt, "SELECT * FROM class WHERE max_seats > 0 AND subject=?")) { exit(); }
		mysqli_stmt_bind_param($stmt, "s", $acct );
		mysqli_stmt_execute($stmt);
		$result = mysqli_num_rows(mysqli_stmt_get_result($stmt));

		{
			$stmt = mysqli_stmt_init($conn);

			if (!mysqli_stmt_prepare($stmt, "UPDATE class SET max_seats=max_seats+1, used_seats=used_seats-1 WHERE max_seats > 0 AND subject=?")) { exit(); }
			mysqli_stmt_bind_param($stmt, "s", $acct );
			mysqli_stmt_execute($stmt);

				$stmt = mysqli_stmt_init($conn);
				$acct = $_POST['dropclass'];

				if (!mysqli_stmt_prepare($stmt, "DELETE FROM enrolled WHERE classID=? AND studentID=?")) { header("Location: ../index.php?error=sqlerror"); exit(); }
				mysqli_stmt_bind_param($stmt, "ss", $acct, $_SESSION['userUid']);
				mysqli_stmt_execute($stmt);

			echo "<script>window.location.href = '/proftalk/php/account.php';</script>";
		}
	}

	if(isset($_POST['leaveappt'])) {
		$stmt = mysqli_stmt_init($conn);
		$acct = $_SESSION['userUid'];
		if (!mysqli_stmt_prepare($stmt, "SELECT * FROM appointment WHERE appointmentID=?")) { header("Location: ../index.php?error=sqlerror"); exit(); }
		mysqli_stmt_bind_param($stmt, "s", $_POST['leaveappt']);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$rescheck = mysqli_num_rows($result);
		if ($rescheck == 1) { if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, "UPDATE appointment SET studentID=NULL WHERE appointmentID=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
			mysqli_stmt_bind_param($stmt, "s", $_POST['leaveappt']);
			mysqli_stmt_execute($stmt);

			echo "<script>window.location.href = '/proftalk/php/account.php';</script>";
		} else {
			printf("</br>&nbsp&nbsp&nbsp&nbsp<a href='/proftalk/php/joinclasses.php'>Return To Class Signup</a></br>");
			exit();
		}
	}
?>
