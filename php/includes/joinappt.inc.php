<?php
	/// If logged in
	if (!$_SESSION['userUid']){ header("Location: /account-guest.php?error=notloggedin"); exit(); }
	$stmt = mysqli_stmt_init($conn);
	$acct = $_SESSION['userUid'];

	if (!mysqli_stmt_prepare($stmt, "SELECT * FROM student WHERE uName=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
	mysqli_stmt_bind_param($stmt, "s", $acct);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	$rescheck = mysqli_num_rows($result);
	if ($rescheck == 1) {
		if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }
	} else {
		exit();
	}

	if(isset($_POST['joinappt'])) {
		$stmt = mysqli_stmt_init($conn);
		$acct = $_SESSION['userUid'];
		if (!mysqli_stmt_prepare($stmt, "SELECT * FROM appointment WHERE appointmentID=? AND (studentID is NULL or studentID = '')")) { header("Location: ../index.php?error=sqlerror"); exit(); }
		mysqli_stmt_bind_param($stmt, "s", $_POST['joinappt']);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$rescheck = mysqli_num_rows($result);
		if ($rescheck == 1) { if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, "UPDATE appointment SET studentID=? WHERE appointmentID=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
			mysqli_stmt_bind_param($stmt, "ss", $acct, $_POST['joinappt']);
			mysqli_stmt_execute($stmt);

			echo "<script>window.location.href = '/proftalk/php/joinappt.php';</script>";
		} else {
			printf("</br>&nbsp&nbsp&nbsp&nbsp<a href='/proftalk/php/joinclasses.php'>Return To Class Signup</a></br>");
			exit();
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
			//$acct = $_SESSION['userUid'];
			if (!mysqli_stmt_prepare($stmt, "UPDATE appointment SET studentID=NULL WHERE appointmentID=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
			mysqli_stmt_bind_param($stmt, "s", $_POST['leaveappt']);
			mysqli_stmt_execute($stmt);

			echo "<script>window.location.href = '/proftalk/php/joinappt.php';</script>";
		} else {
			printf("</br>&nbsp&nbsp&nbsp&nbsp<a href='/proftalk/php/joinclasses.php'>Return To Class Signup</a></br>");
			exit();
		}
	}
?>