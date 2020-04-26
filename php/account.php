<?php	require "header.php";	?>
<?php

require "includes/dbh.inc.php";
require "includes/account.inc.php";


?>


<div class = "stdmain">
</br>
	<p style="font-size: 16px">Account Summary:</br>
	<!-- START Returning User Information -->
		<b>User Information</b><br>

		<?php printf("<b>Name:</b> %s %s \n", $pullfname, $pulllname); ?><br>
		<?php printf("<b>User Name:</b> %s \n", $pulluname); ?><br>
		<?php printf("<b>EMPL ID:</b> %d \n", $pullempl); ?><br>
	</p>
<!-- END Returning User Information -->
<style>
.YourClassTable tr:hover { background-color:#BBB; color: #FFF; }
</style>
<!-- START Returning Appointment Information -->
<div>
	<p>
		<form method="POST">

		<?php

			if(count($pullroom)== 0) {
				printf("<b>No Classes Enrolled</b>");
			} else {
				printf("<b>Your Classes:</b></br></br>");
				printf("
					<table class='YourClassTable' style='margin: auto auto; width: 90%%; font-family: sans-serif; font-size: 12px;'>
					<tr style='background-color:#DDD; color: #333'>
					<th>Subject:</th>
					<th>Section:</th>
					<th>Day:</th>
					<th>Start:</th>
					<th>End:</th>
					<th></th>
					</tr>");
				for ($i=0;$i<count($pullroom);$i++){
					printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $pullsub[$i], $pullclass[$i], gmdate("l",$pulltime[$i]), gmdate("h:i:s A",$pulltime[$i]), gmdate("h:i:s A",$pulldate[$i]));
					printf("<td><button type='submit' name='dropclass' value='%s'>Drop</button></td></tr>", $pullsub[$i]);
				}
				printf("</table>");
			}
		?>

		</br>

		<?php
			if($isStudent) echo "<a href='/proftalk/php/classes.php'>Join Classes</a>";
			if($isProfessor) echo "<a href='/proftalk/php/classes.php'>Create Classes</a>";
		?>

		</br>

		<?php
			if($isStudent || $isProfessor) {
				$stmt = mysqli_stmt_init($conn);
				$acct = $_SESSION['userUid'];

				if($isStudent)
					if (!mysqli_stmt_prepare($stmt, "SELECT * FROM appointment WHERE studentID=?")) { header("Location: ../index.php?error=sqlerror"); exit(); }
				if($isProfessor)
					if (!mysqli_stmt_prepare($stmt, "SELECT * FROM appointment WHERE prof_ID=?")) { header("Location: ../index.php?error=sqlerror"); exit(); }



				mysqli_stmt_bind_param($stmt, "s", $acct);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);

				if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }

				$rescheck = mysqli_num_rows($result);
				if ($rescheck == 0) {
						printf("<div style='width:90%%; margin: auto auto; text-align: center; font-size: 24px'><b>No Appointments Made</b></br></div>");
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
							<th>Student:</th>
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
							printf("		<td>%s</td>", $rowZ['studentID']);
							printf("		<td style='width:200px'><button type='submit' name='leaveappt' value='%s'>Leave</button></td>", $rowZ['appointmentID'] );
							printf("	 </tr>");
						}
					}

					printf("</br>");
					printf("</table>");
				}
			}
		?>
		</br>
		<?php
			if($isStudent) echo "<a href='/proftalk/php/appointment.php'>Schedule an Appointment</a>";
			if($isProfessor) echo "<a href='/proftalk/php/appointment.php'>Create Appointment</a>";
		?>

		</form>
	</p>
</div>

<!-- END Returning Class Information -->

</div>
</div>

<?php	require "footer.php"; ?>
<!---
X check SESSIONID User
X if ID is in student table
		X return STUDENT: fName, lName, empl
		X return CLASSES: classNum, section, ahref="make appointment", ahref ="find class"
		X return SCHEDULED APPT: professor.fName, professor.lName, class.classNum, appointment.time, !!!room!!!! (lose room or create room?), CONT-
		X ahref="change"(appt)
X else if ID is in professor table
		X return PROFESSOR: fName, lName, empl
		X return OWNED CLASSES: classNum, section, ahref="make appointment", ahref ="edit classes"
		X return SCHEDULED APPT: student.fName, student.lName, class.classNum, appointment.time, !!!room!!!! (lose room or create room?), CONT-
		X ahref="change"(appt)
X else
 	X return home page?

-->
