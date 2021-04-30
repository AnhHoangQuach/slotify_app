<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset PHP</title>
	<link rel="stylesheet" href="/slotify_app/assets/css/adminlte.min.css">
    <script src="/slotify_app/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/slotify_app/assets/plugins/bootstrap/bootstrap.min.js"></script>
    <link rel="icon" href="/slotify_app/assets/images/logomain.jpg">
</head>
<?php
include("/slotify_app/includes/config.php");
$info = "";
if (isset($_POST['new_password'])) {
	$new_pass = mysqli_real_escape_string($con, $_POST['new_pass']);
	$new_pass_c = mysqli_real_escape_string($con, $_POST['new_pass_c']);
	if($new_pass != $new_pass_c) {
		$info = "Mật khẩu không khớp";
		return;
	} 
	// Grab to token that came from the email link
        $token = $_GET['token'];
	  // select email address of user from the password_reset table 
	  $sql = "SELECT email FROM users WHERE reset_token='$token'";
      $results = mysqli_query($con, $sql);
	  $email = mysqli_fetch_array($results)['email'];
	  if ($email) {
		$new_pass = md5($new_pass);
		$sql = "UPDATE users SET password='$new_pass' WHERE email='$email'";
        $results = mysqli_query($con, $sql);
		header('Location: register.php');
	  }
  }
  ?>
<body>
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">New Password</h3>
                <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-group">
                        <label for="email">New Password</label>
                        <input name="new_pass" type="password" class="form-control">
                    </div>
					<div class="form-group">
                        <label for="email">Confirm New Password</label>
                        <input name="new_pass_c" type="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success px-5" name="new_password">Submit</button>
                    </div>
                </form>
                <span class="text-center"><?php echo $info ?></span> 
            </div>
        </div>
    </div>
</body>
</html>