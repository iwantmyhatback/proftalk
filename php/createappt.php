<?php	require "header.php";	?>
<?php

require "includes/dbh.inc.php";
require "includes/createappt.inc.php";


?>
<style>
.ProfSignDesign {
	max-width: 256px;
	margin: auto auto;
	font-family: sans-serif;
	font-size: 16px;
	padding: 20px;
}
</style>
</br>
</br>
</br>
<div class = "stdmain">
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
				printf("<b>No Appointments.</b>");
			} else {
				printf("<b>Your Appointments:</b><br></br>");
				printf("
					<table class='YourClassTable' style='margin: auto auto; width: 90%%; font-family: sans-serif; font-size: 12px;'>
					<tr style='background-color:#DDD; color: #333'>
					<th>Apt. #:</th>
					<th>Class:</th>
					<th>Day, Start:</th>
					<th>Finish:</th>
					<th>Room #:</th>
					<th>Student ID:</th>
					<th></th>
					</tr>");
				for ($i=0;$i<count($pullroom);$i++){
					printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",
						$pullapptID[$i],
						$pullclass[$i],
						gmdate("l h:i:s A",$pullstart[$i]),
						gmdate("h:i:s A",$pullend[$i]),
						$pullroom[$i],
						$pullstudent[$i]
					);
					printf("<td>
						<button type='submit' name='dropappt' value='%s'>Drop</button>
						<button type='submit' name='clearappt' value='%s'>Clear</button>
						<button type='submit' name='editappt' value='%s'>Edit</button>
					</td></tr>", $pullapptID[$i], $pullapptID[$i], $pullapptID[$i]);
				}
				printf("</table>");
			}
		?>
		</br>
		</br>
		</br>
			<b>New & Edit</br>Appointments:</b>
		<div style="width: 100%;" class="ProfSignDesign">
			<table style="max-width: 512px; margin: auto auto;">

				<tr>
				<td style="text-align: left;">Class</td>
				<td>
				<select name='classSelectNC'>
				<?php
					for ($i=0;$i<count($getsubjects);$i++){
						printf("<option value='%s'>%s</option>",
						$getsubjects[$i], $getsubjects[$i]
					);
				}
				?>
				</select>
				</td>

				</tr>
				<tr>
					<td style="text-align: left;">
						Date
					</td>
					<td>
						<input type="date" name="dateNC"/>
					</td>
				</tr>
				<tr>
					<td style="text-align: left;">
						Start-Time
					</td>
					<td>
						<select name="st-hrNC">
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

						<select name="st-minNC">
							<option value="0" selected>0</option>
							<option value="15">15</option>
							<option value="30">30</option>
							<option value="45">45</option>
							</select>

							<select name="st-ampmNC">
							<option value="AM">AM</option>
							<option value="PM" selected>PM</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="text-align: left;">
						End-Time
					</td>
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
					</td>
				</tr>
				<tr>
				<td style="text-align: left;">Room Number</td>
					<td><input type="text" name="roomNumNC" placeholder="123"></td>
				</tr>
			</table>
			</br>
			<button type="submit" name="createappt">Create Appointments</button>
		</div>
		</form>
		</br>
	</p>
</div>

<!-- END Returning Class Information -->

</div>
</div>

<?php	require "footer.php"; ?>

