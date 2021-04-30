<head>
    <title>Forgot Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/slotify_app/assets/css/adminlte.min.css">
    <script src="/slotify_app/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/slotify_app/assets/plugins/bootstrap/bootstrap.min.js"></script>
    <link rel="icon" href="/slotify_app/assets/images/logomain.jpg">
</head>

<?php 
    include("/slotify_app/includes/config.php");
    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception;
    // Base files 
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    $info = "";
    // create object of PHPMailer class with boolean parameter which sets/unsets exception.
    if(isset($_POST['send-mail'])) {
        $token = bin2hex(random_bytes(50));
        $email_value = $_POST['email'];
        $sql = "UPDATE users SET reset_token='$token' WHERE email='$email_value'";
        $results = mysqli_query($con, $sql);
        
        $mail = new PHPMailer(true);                              
        $mail->IsSMTP(); // set mailer to use SMTP
        $mail->Host = "smtp.gmail.com"; // specify main and backup server
        $mail->Port = 465; // set the port to use
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->SMTPSecure = 'ssl';
        $mail->Username = "viethoang.vunguyen@gmail.com"; // your SMTP username or your gmail username
        $mail->Password = "viethoang@2612"; // your SMTP password or your gmail password
        $from = "viethoang.vunguyen@gmail.com"; // Reply to this email
        $to=$_POST['email']; // Recipients email ID
        $name="NAH05"; // Recipient's name
        $mail->From = $from;
        $mail->FromName = "NAH05"; // Name to indicate where the email came from when the recepient received
        $mail->AddAddress($to,$name);
        $mail->AddReplyTo($from,"NAH05");
        $mail->WordWrap = 50; // set word wrap
        $mail->IsHTML(true); // send as HTML
        $mail->Subject = "Reset Password";
        $mail->Body = "<b>Click vào link để xác nhận đổi mật khẩu. - <a href='http://nah05.zing:8080/new-pass.php?token=" . $token . "'>Bấm vào đây</a></b>"; //HTML Body
        $mail->AltBody = "Reset Password"; //Text Body
        //$mail->SMTPDebug = 2;
        if(!$mail->Send()) {
            $info = $mail->ErrorInfo;
        }
        else {
            $info = 'Gửi mail thành công, bạn truy cập mail để vào link thay đổi mật khẩu mới nhé ^^';
        }
    }
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">Forgot Password</h3>
                <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="" name="email" id="email" type="email" class="form-control" placeholder="Email">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success px-5" name="send-mail">Send mail</button>
                    </div>
                    <div class="form-group">
                        <p>Do you already have an account ? <a href="register.php">Login</a>.</p>
                    </div>
                </form>
                <span class="text-center"><?php echo $info ?></span> 
            </div>
        </div>
    </div>
</body>
</html>
