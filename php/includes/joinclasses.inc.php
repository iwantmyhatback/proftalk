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
	
	if(isset($_POST['joinclass'])) {
		$passwordEntry = $_POST['passwordEntry'];
		
		$stmt = mysqli_stmt_init($conn);
		$acct = $_SESSION['userUid'];
		if (!mysqli_stmt_prepare($stmt, "SELECT * FROM class WHERE subject=? AND password=?")) { header("Location: ../index.php?error=sqlerror"); exit(); }
		mysqli_stmt_bind_param($stmt, "ss", $_POST['joinclass'], $passwordEntry);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$rescheck = mysqli_num_rows($result);
		if ($rescheck == 1) { if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }
			mysqli_free_result($result);
			
			$stmt = mysqli_stmt_init($conn);
			$acct = $_SESSION['userUid'];
			if (!mysqli_stmt_prepare($stmt, "SELECT max_seats FROM class WHERE subject=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
			mysqli_stmt_bind_param($stmt, "s", $_POST['joinclass']);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$asocres = mysqli_fetch_assoc($result);
			$max_seats = $asocres['max_seats'];
			
			if($max_seats <= 0) {
				printf("</br></br></br></br></br>&nbsp&nbsp&nbsp&nbspClass: %s is Full...", $_POST['joinclass']);
				printf("</br>&nbsp&nbsp&nbsp&nbsp<a href='/proftalk/php/joinclasses.php'>Return To Class Signup</a></br>", $_POST['joinclass']);
				exit();
			}
			
			$stmt = mysqli_stmt_init($conn);
			$acct = $_SESSION['userUid'];
			if (!mysqli_stmt_prepare($stmt, "INSERT INTO enrolled ( enrolledID, studentID, classID ) VALUES ( NULL, ?, ? );")) { header("Location: ../index.php?error=sqlerror"); exit(); }
			mysqli_stmt_bind_param($stmt, "ss", $acct, $_POST['joinclass']);
			mysqli_stmt_execute($stmt);
			
			
			$stmt = mysqli_stmt_init($conn);
			$acct = $_SESSION['userUid'];
			if (!mysqli_stmt_prepare($stmt, "UPDATE class SET max_seats = max_seats - 1, used_seats = used_seats + 1 WHERE subject=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
			mysqli_stmt_bind_param($stmt, "s", $_POST['joinclass']);
			mysqli_stmt_execute($stmt);
			
		} else {
			printf("</br></br></br></br></br>&nbsp&nbsp&nbsp&nbspPassphrase not accepted!");
			printf("</br>&nbsp&nbsp&nbsp&nbsp<a href='/proftalk/php/joinclasses.php'>Return To Class Signup</a></br>");
			exit();
		}
	}
?>