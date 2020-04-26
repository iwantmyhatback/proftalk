<?php
require "header.php";
require "includes/dbh.inc.php";
require "includes/joinclasses.inc.php"; ?>
</br></br></br>
<style>

.YourClassTable tr:hover { background-color:#BBB; color: #FFF; }

</style>
<form method="POST">
</br></br>
<div style="margin: auto auto; width: 90%;">
Enter Password: <input type="text" name="passwordEntry" placeholder="Password"></input>
</div>
<?php
	$stmt = mysqli_stmt_init($conn);
	$acct = $_SESSION['userUid'];

	if (!mysqli_stmt_prepare($stmt, "SELECT * FROM class;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
	//mysqli_stmt_bind_param($stmt, "s", $acct);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }

	$rescheck = mysqli_num_rows($result);
	if ($rescheck == 0) {
		printf("No Classes");
	} else {
		printf("<table class='YourClassTable' style='margin: auto auto; width: 90%%; font-family: sans-serif; font-size: 12px;'>");
		printf("	 <tr style='background-color:#DDD; color: #333'>");
		printf("		<th>Subject</th>");
		printf("		<th>Section</th>");
		printf("		<th>Day</th>");
		printf("		<th>Start Time</th>");
		printf("		<th>End Time</th>");
		printf("		<th>Slots</th>");
		printf("		<th>Enrolled</th>");
		printf("		<th></th>");
		printf("	 </tr>");
		printf("	 <tr>");
		while($row = mysqli_fetch_assoc($result)) {
			if((int)$row['max_seats'] > 0) {
				printf("	 <tr>");
				printf("		<td>%s</td>", $row['subject']);
				printf("		<td>%s</td>", $row['section']);
				printf("		<td>%s</td>", gmdate("D", $row['start_time']));
				printf("		<td>%s</td>", gmdate("g:i a", $row['start_time']));
				printf("		<td>%s</td>", gmdate("g:i a", $row['end_time']));
				printf("		<td>%s</td>", $row['max_seats']);
				printf("		<td>%s</td>", $row['used_seats']);
				printf("		<td style='width:200px'><button type='submit' name='joinclass' value='%s'>Join</button></td>", $row['subject'] );
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
