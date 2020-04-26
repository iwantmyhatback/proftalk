<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "header.php";
require "includes/dbh.inc.php";
require "includes/editclasses.inc.php"; ?>

<style>

.ClassTable {
	 }

.ProfSignDesign {
	max-width: 256px;
	margin: auto auto;
	font-family: sans-serif;
	font-size: 16px;
	padding: 20px;
}

.YourClassTable tr:hover { background-color:#BBB; color: #FFF; }
</style>
<div class = "stdmain">
	</br>
	</br>
	</br>
	<div class="schedule" style="float: center; margin: auto auto; font-family: serif;">
	   <h1 style="font-family: sans-serif; font-size: 24px;font-size: 32px">Your Classes</h1>

		<form method="POST">
		<?php
			{
				$stmt = mysqli_stmt_init($conn);
				$acct = $_SESSION['userUid'];

				if (!mysqli_stmt_prepare($stmt, "SELECT * FROM class WHERE prof_ID=?;")) { header("Location: ../index.php?error=sqlerror"); exit(); }
				mysqli_stmt_bind_param($stmt, "s", $acct);
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
					printf("		<th>Password</th>");
					printf("		<th></th>");
					printf("	 </tr>");
					printf("	 <tr>");

					while($row = mysqli_fetch_assoc($result)) {
						printf("	 <tr>");
						printf("		<td>%s</td>", $row['subject']);
						printf("		<td>%s</td>", $row['section']);
						printf("		<td>%s</td>", gmdate("D", $row['start_time']));
						printf("		<td>%s</td>", gmdate("g:i a", $row['start_time']));
						printf("		<td>%s</td>", gmdate("g:i a", $row['end_time']));
						printf("		<td>%s</td>", $row['max_seats']);
						printf("		<td>%s</td>", $row['used_seats']);
						printf("		<td>%s</td>", $row['password']);
						printf("		<td style='width:200px'><button type='submit' name='removeclass' value='%s'>Remove</button><button type='submit' name='editclass' value='%s'>Edit</button></td>", $row['subject'], $row['subject']);
						printf("	 </tr>");
					}

					printf("</br>");
					printf("</table>");
				}
			}
		?>

		</br>
		</br>
		</br>

		<div class="ProfSignDesign">
			<b style="font-family: sans-serif; font-size: 32px">Create Class & Edit Class</b>
			</br>
			</br>
			<table style="width: 100%">
					<tr><td style="text-align: left;">Email</td><td>

					<?php printf("<input type='text' name='emailNC' value='%s'>", $pullemail ); ?>
					<br></td></tr>
					<tr><td style="text-align: left;">Subject</td><td>
							<input type="text" name="subjectNC" placeholder="CIS 5675-QTRA""/>
						<br></td></tr>
						<tr><td style="text-align: left;">Section</td><td>
							<input type="text" name="sectionNC" placeholder="B-Vert 10-196""/>
						<br></td></tr>
						<tr><td style="text-align: left;">Phone</td><td><?php printf("
							<input type='text' name='phoneNC' value='%s'>
						", $pullphone ); ?></td></tr>
						<tr><td style="text-align: left;">Date</td><td>
							<input type="date" name="dateNC"/>
						<br></td></tr>
						<tr><td style="text-align: left;">Start-Time</td>
						<td>
							<select name="st-hrNC">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12" selected>12</option>
							</select>

							<select name="st-minNC">
								<option value="0">0</option>
								<option value="15">15</option>
								<option value="30" selected>30</option>
								<option value="45">45</option>
								</select>

								<select name="st-ampmNC">
								<option value="AM">AM</option>
								<option value="PM" selected>PM</option>
							</select>
							</tr>
						<tr><td style="text-align: left;">End-Time</td>
						<td>
							<select name="et-hrNC">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5"selected>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12" >12</option>
							</select>

							<select name="et-minNC">
								<option value="0">0</option>
								<option value="15">15</option>
								<option value="30" selected>30</option>
								<option value="45">45</option>
								</select>

								<select name="et-ampmNC">
								<option value="AM">AM</option>
								<option value="PM" selected>PM</option>
							</select>
							</tr>

						<tr><td style="text-align: left;">Max Seats</td><td><input type="number" name="maxseatsNC" value="12"><br></td></tr>
						<tr><td style="text-align: left;">Password</td><td><input type="text" name="passwordNC" value="pineapple123"><br></td></tr>

					</table>
					</br>
						<button type="submit" name="createclass">Create Class!</button>
				&nbsp;
		   </br>
	 </div>
	</div>

	<div class = "accountgrid">

	</div>
	</div>

		</form>


<?php	require "footer.php"; ?>
