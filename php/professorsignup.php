<?php
	require "header.php";
?>

	<div class="main">
	   <h1>Professor Signup</h1>
     <form action="includes/professorsignup.inc.php" method="post">
       <input type="text" name="uid" placeholder="Username"><br>
       <input type="text" name="mail" placeholder="Email"><br>
			 <input type="text" name="fname" placeholder="First Name"><br>
			 <input type="text" name="lname" placeholder="Last Name"><br>
			 <input type="text" name="empl" placeholder="EMPLID"><br>
			 <input type="text" name="phone" placeholder="Phone"><br>
       <input type="password" name="pwd" placeholder="Password"><br>
       <input type="password" name="pwd-repeat" placeholder="Repeat Password"><br>
       <button type="submit" name="signup-submit">Signup</button>
     </form>
	</div>

<?php
	require "footer.php";
?>
