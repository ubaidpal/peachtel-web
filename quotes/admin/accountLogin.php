<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php if(!session_id()){ session_start(); } ?>

	<head>
	<link type="text/css" href="css/style.css" media="screen" rel="Stylesheet" />
	<!-- <script type="text/javascript" src="scripts/functions.js"></script> -->

		<title>PeachTEL</title>
	</head>
	<body>
		<div id="loginContainer">
		<?php if(isset($_SESSION['uid'])){ ?>
			<div class="loginBox">
				<p class="center">You are already logged in!</p>
				<div id="loginInfo" class="center"><?php echo $_SESSION['WHMCSemail']; ?></div>
				<p class="center"><a href="#" id="logoutSubmit">Logout</a></p>
			</div>
		<?php }else{ ?>
			<div class="loginBox">
				Login with your existing account<br><br>
				<div id="loginInfo"> </div>
				Email Address:<br>
				<input type="text" name="loginName" id="loginName" /><br>
				Password:<br>
				<input type="password" name="loginPassword" id="loginPassword" /><br>
				<a href="#" id="loginSubmit" onClick=loginSubmit("<?php echo $_REQUEST['step']; ?>")>Login</a>
			</div>
			<div class="createBox">
				Create an Account<br><br>
				<div id="createInfo"> </div>
				First Name:<br>
				<input type="text" name="createFirstName" id="createFirstName" /><br>
				Last Name:<br>
				<input type="text" name="createLastName" id="createLastName" /><br>
				Company:<br>
				<input type="text" name="createCompany" id="createCompany" /><br>
				Email Address:<br>
				<input type="text" name="createEmail" id="createEmail" /><br>
				Password:<br>
				<input type="password" name="createPassword" id="createPassword" /><br>
				Phone Number:<br>
				<input type="text" name="createPhone" id="createPhone" /><br>
				<a href="#" id="createSubmit" onClick=createSubmit("<?php echo $_REQUEST['step']; ?>")>Create Account</a>
			</div>
		<?php } ?>
		</div>
	</body>
</html>
