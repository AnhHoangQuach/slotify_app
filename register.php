<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<html>
<head>
	<title>Welcome to Slotify!</title>

	<link rel="stylesheet" type="text/css" href="/assets/css/register.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
	<link rel="icon" href="../assets/images/icons/logoicon.jpg">
	<script src="/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="/assets/js/login.js"></script>
	<script src="/assets/js/register.js"></script>
</head>
<body>
	<?php

	if(isset($_POST['registerButton'])) {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").hide();
					$("#registerForm").show();
				});
			</script>';
	}
	else {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").show();
					$("#registerForm").hide();
				});
			</script>';
	}

	?>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('/assets/images/bg-01.jpg');">
			<div class="wrap-login100 p-l-30 p-r-30 p-t-20 p-b-20">
				<form id="loginForm" class="login100-form validate-form" action="./register.php" method="POST">
					<div class="login_header">
						<a href="">
							<img src="../assets/images/logomain.jpg" class="logo-login" alt="">
						</a>
						<span class="login100-form-title">
							Login
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10">
						<?php echo $account->getError(Constants::$loginFailed); ?>
						<span class="label-input100">Username</span>
						<input class="input100" type="text" id="loginUsername"
						value="<?php getInputValue('loginUsername') ?>" name="loginUsername" placeholder="Type your username">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<span class="label-input100">Password</span>
						<input id="loginPassword" class="input100" type="password" name="loginPassword" placeholder="Type your password">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="text-right p-t-10 p-b-20">
						<a href="../forgot.php">
							Forgot password?
						</a>
					</div>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" name="loginButton">
								Login
							</button>
						</div>
					</div>

					<div class="hasAccountText p-t-15">
						<span id="hideLogin">Don't have an account yet? Signup here.</span>
					</div>
				</form>

				<form id="registerForm" class="login100-form validate-form" action="register.php" method="POST">
					<div class="login_header">
						<a href="" class="logo-login"></a>
						<span class="login100-form-title">
							Register
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-6">
						<?php echo $account->getError(Constants::$usernameCharacters); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="username" 
						value="<?php getInputValue('username') ?>" placeholder="Type your username">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
					
					<div class="wrap-input100 validate-input m-b-6">
						<?php echo $account->getError(Constants::$fullnameCharacters); ?>
						<span class="label-input100">Fullname</span>
						<input id="fullname" class="input100" type="text" name="fullname" 
						value="<?php getInputValue('fullname') ?>" placeholder="Type your fullname">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="wrap-input100 validate-input m-b-6">
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<span class="label-input100">Email</span>
						<input class="input100" type="email" name="email"
						value="<?php getInputValue('email') ?>" placeholder="Type your email">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-6">
						<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacters); ?>
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="password" placeholder="Type your password">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<div class="wrap-input100 validate-input">
						<span class="label-input100">Confirm Password</span>
						<input class="input100" type="password" name="password2" placeholder="Confirm your password">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="container-login100-form-btn p-t-20">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="registerButton">
								Register
							</button>
						</div>
					</div>

					<div class="txt1 text-center p-t-8 p-b-8">
						<span>
							Or Sign Up Using
						</span>
					</div>

					<div class="flex-c-m">
						<a href="https://www.facebook.com/profile.php?id=100007422227963" class="login100-social-item bg1" target="_blank">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="#" class="login100-social-item bg2">
							<i class="fa fa-twitter"></i>
						</a>

						<a href="mailto:hoanganh36.work@gmail.com" target="_blank" class="login100-social-item bg3">
							<i class="fa fa-google"></i>
						</a>
					</div>

					<div class="hasAccountText">
						<span id="hideRegister">Already have an account? Log in here.</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="/vendor/bootstrap/js/popper.js"></script>
	<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>