<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="LOGIN HEADER">
		<meta name=viewport content="width=device-width, initial-scale=1">
	<title></title>

	<link rel="stylesheet" href="style.css">

	</head>
	<body>

	<header>
		<div class="navbar">
			<nav>

				<div class="barleft">
					<ul class="navlinks">
						<li><a href="#"><img src="img/logo.png" alt="logo" style="width:35px;height:25px;align:left"></a></li>
						<li><a href="index.php" class="navlinks">Home</a></li>
						<li><a href="classes.php" class="navlinks">Classes</a></li>
						<li><a href="appointment.php" class="navlinks">Appointments</a></li>
						<li><a href="account.php" class="navlinks">Account</a></li>
					</ul>
				</div>

				<div class="barright">
					<?php
					if (isset($_SESSION['userUid'])) {
						echo '<form action="includes/logout.inc.php" method="post" display="inline">
							<button type="submit" name="logout-submit">Logout</button>
						</form>';
					}
					else {
						echo '<a href="userdefine.php" class="navlinksright">Signup</a>
							<form action="includes/login.inc.php" method="post">
							<input type="text" name="mailuid" placeholder="Username/E-mail...">
							<input type="password" name="pwd" placeholder="Password...">
							<button type="submit" name="login-submit">Login</button>
						</form>';
					}
					 ?>


				</div>
			</nav>
		</div>
	</header>
