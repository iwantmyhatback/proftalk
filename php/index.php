<?php
	require "header.php";
?>

	<div class="main">
		<?php
		if (isset($_SESSION['userUid'])) {
			echo '<p>You are logged in...</p>';
		}
		else {
			echo '<p>You are logged out...</p>';
		}
		 ?>
	</div>


	<div class= "indexmain">
		<h><font>ProfTalk</font></h>
		<p><font>ProfTalk is a web application created to help students and professors connect outside of class <br> quickly, easily, and efficiently</font></p>
		<img src="img/1.png" alt="1"><img src="img/2.png" alt="2"><img src="img/3.png" alt="3"><img src="img/done.png" alt="done">


	</div>








<?php
	require "footer.php";
?>
