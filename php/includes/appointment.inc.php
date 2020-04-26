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
		echo "<script>window.location.href = '/proftalk/php/createappt.php';</script>";
		exit();
	} else {
		$stmt = mysqli_stmt_init($conn);
		$acct = $_SESSION['userUid'];

		if (!mysqli_stmt_prepare($stmt, "SELECT * FROM student WHERE uName=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
		mysqli_stmt_bind_param($stmt, "s", $acct);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$rescheck = mysqli_num_rows($result);
		if ($rescheck == 1) {
			if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }
			echo "<script>window.location.href = '/proftalk/php/joinappt.php';</script>";
			exit();
		} else {

			exit();
		}

		exit();
	}
?>