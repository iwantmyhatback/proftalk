<?php
require "header.php";
require "includes/dbh.inc.php";
require "includes/joinappt.inc.php"; ?>
</br></br></br>
<style>

.YourClassTable tr:hover { background-color:#BBB; color: #FFF; }

</style>
<form method="POST">
</br></br>
<div style="margin: auto auto; width: 90%;">
</div>
<?php
	$stmt = mysqli_stmt_init($conn);
	$acct = $_SESSION['userUid'];

	if (!mysqli_stmt_prepare($stmt, "SELECT * FROM enrolled WHERE studentID=?")) { header("Location: ../index.php?error=sqlerror"); exit(); }
	mysqli_stmt_bind_param($stmt, "s", $acct);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }

	$rescheck = mysqli_num_rows($result);
	if ($rescheck == 0) {
					printf("%s", $rowE['classID']);
					printf("&nbsp &nbsp &nbsp <b>No Classes your assigned to, have any appointment slots...</b>");
					printf("</br></br> &nbsp &nbsp &nbsp <a href='/proftalk/php/account.php'>Account Page</a> </br>");
	} else {
		printf("<div style='width:90%%; margin: auto auto; text-align: center; font-size: 24px'><b>Appointments Available:</b></br></div>");
		printf( "
			<table class='YourClassTable' style='margin: auto auto; width: 90%%; font-family: sans-serif; font-size: 12px;'>
				<tr style='background-color:#DDD; color: #333'>
				<th>Apt. #:</th>
				<th>Class:</th>
				<th>Day, Start:</th>
				<th>Finish:</th>
				<th>Room #:</th>
				<th>Professor:</th>
				<th>Contact Email:</th>
				<th>Contact Phone:</th>
				<th></th>
			</tr>");
		while($rowE = mysqli_fetch_assoc($result)) {
			{
				$stmt = mysqli_stmt_init($conn);

				if (!mysqli_stmt_prepare($stmt, "SELECT * FROM appointment WHERE classID=? AND (studentID is NULL or studentID = '');")) { header("Location: ../index.php?error=sqlerror"); exit(); }
				mysqli_stmt_bind_param($stmt, "s", $rowE['classID']);
				mysqli_stmt_execute($stmt);
				$resultb = mysqli_stmt_get_result($stmt);

				if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }

				$rescheck = mysqli_num_rows($resultb);
				if ($rescheck == 0) {

				} else {
					while($row = mysqli_fetch_assoc($resultb)) {
						{
							{
								$stmt = mysqli_stmt_init($conn);

								if (!mysqli_stmt_prepare($stmt, "SELECT * FROM class WHERE subject=?")) { header("Location: ../index.php?error=sqlerror"); exit(); }
								mysqli_stmt_bind_param($stmt, "s", $row['classID']);
								mysqli_stmt_execute($stmt);
								$resultc = mysqli_stmt_get_result($stmt);

								if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }

								$rescheck = mysqli_num_rows($resultc);
								if ($rescheck == 0) {
									printf("No Classes3: %s", $row['classID']);
								} else {

									while($rowC = mysqli_fetch_assoc($resultc)) {
										{
											printf("	 <tr>");
											printf("		<td>%s</td>", $row['appointmentID']);
											printf("		<td>%s</td>", $row['classID']);
											printf("		<td>%s</td>", gmdate("D g:i a", $row['start_time']));
											printf("		<td>%s</td>", gmdate("g:i a", $row['end_time']));
											printf("		<td>%s</td>", $row['room']);
											printf("		<td>%s</td>", $row['prof_ID']);
											printf("		<td>%s</td>", $rowC['email']);
											printf("		<td>%s</td>", $rowC['phone']);
											printf("		<td style='width:200px'><button type='submit' name='joinappt' value='%s'>Join</button></td>", $row['appointmentID'] );
											printf("	 </tr>");

										}
									}
								}
							}
						}
					}
				}
			}
		}

		printf("</br>");
		printf("</table>");
	}

	$stmt = mysqli_stmt_init($conn);
	$acct = $_SESSION['userUid'];

	if (!mysqli_stmt_prepare($stmt, "SELECT * FROM appointment WHERE studentID=?")) { header("Location: ../index.php?error=sqlerror"); exit(); }
	mysqli_stmt_bind_param($stmt, "s", $acct);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }

	$rescheck = mysqli_num_rows($result);
	if ($rescheck == 0) {
			printf("</br></br><div style='width:90%%; margin: auto auto; text-align: center; font-size: 24px'><b>No Appointments Made</b></br></div>");
	} else {
		printf("</br></br><div style='width:90%%; margin: auto auto; text-align: center; font-size: 24px'><b>Your Appointments:</b></br></div>");
		printf( "
			<table class='YourClassTable' style='margin: auto auto; width: 90%%; font-family: sans-serif; font-size: 12px;'>
				<tr style='background-color:#DDD; color: #333'>
				<th>Apt. #:</th>
				<th>Class:</th>
				<th>Day, Start:</th>
				<th>Finish:</th>
				<th>Room #:</th>
				<th>Professor:</th>
				<th>Contact Email:</th>
				<th>Contact Phone:</th>
				<th></th>
			</tr>");
		while($rowZ = mysqli_fetch_assoc($result)) {

			$stmt = mysqli_stmt_init($conn);
			$acct = $_SESSION['userUid'];

			if (!mysqli_stmt_prepare($stmt, "SELECT * FROM class WHERE subject=?")) { header("Location: ../index.php?error=sqlerror"); exit(); }
			mysqli_stmt_bind_param($stmt, "s", $rowZ['classID']);
			mysqli_stmt_execute($stmt);
			$resultb = mysqli_stmt_get_result($stmt);

			if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }

			while($rowC = mysqli_fetch_assoc($resultb)) {
				printf("	 <tr>");
				printf("		<td>%s</td>", $rowZ['appointmentID']);
				printf("		<td>%s</td>", $rowZ['classID']);
				printf("		<td>%s</td>", gmdate("D g:i a", $rowZ['start_time']));
				printf("		<td>%s</td>", gmdate("g:i a", $rowZ['end_time']));
				printf("		<td>%s</td>", $rowZ['room']);
				printf("		<td>%s</td>", $rowZ['prof_ID']);
				printf("		<td>%s</td>", $rowC['email']);
				printf("		<td>%s</td>", $rowC['phone']);
				printf("		<td style='width:200px'><button type='submit' name='leaveappt' value='%s'>Leave</button></td>", $rowZ['appointmentID'] );
				printf("	 </tr>");
			}
		}

		printf("</br>");
		printf("</table>");
	}
?>
</form>

<?php
	require "footer.php";
?>
