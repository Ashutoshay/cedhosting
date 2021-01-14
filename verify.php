<?php
require_once "header.php";
$emailsuccess="";
$emailfailure="";
$phonesuccess="";
$phonefailure="";
if (!isset($_SESSION['name'])) {
    header('Location:login.php');
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
if (isset($_POST['emailsubmit'])) {
    $otp = rand(1000, 9999);
    $_SESSION['otp']=$otp;
    $mail = new PHPMailer();
    $email=$_SESSION['email'];
    $name=$_SESSION['name'];
    try {
        $mail->isSMTP(true);
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cedcossarjun1023@gmail.com';
        $mail->Password = 'Cedcoss@1023';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setfrom('cedcossarjun1023@gmail.com', 'CedHosting');
        $mail->addAddress($email);
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Account Verification';
        $mail->Body = 'Hi '.$name.',Here is your otp for account verification: '.$otp;
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();
        $emailsuccess="otp sent successfully";
        // header('location: verification.php?email=' . $email);
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        $emailfailure="some unexpected error occured";
    }
}
if (isset($_POST['mobilesubmit'])) {
    $mobile=$_SESSION['mobile'];
    $name=$_SESSION['name'];
    $otp = rand(1000, 9999);
    $_SESSION['mobileotp']=$otp;
    /**mobile otp */
    $fields = array(
        "sender_id" => "FSTSMS",
        "message" => 'Hi '.$name.',Here is your otp for account verification: '.$otp,
        "language" => "english",
        "route" => "p",
        "numbers" => "$mobile",
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($fields),
        CURLOPT_HTTPHEADER => array(
        "authorization: oJPvrNweydA1Kc4VkQG2pCTE8jb5q7UBZgWYtixDfhnM9sH6aSUkDYyuxdinW9cgoAaz8XFlNJ1vHLpM",
        "accept: */*",
        "cache-control: no-cache",
        "content-type: application/json"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
        $phonefailure=$err;
    } else {
        $phonesuccess=$response;
    }
}
$verifiedemail="";
if (isset($_POST['verifyemailotp'])) {
    $otpemail=$_POST['emailotp'];
    if (isset($_SESSION['otp'])) {
        if ($otpemail=$_SESSION['otp']) {
            require_once 'tbl_user.php';
            $user=new tbl_user();
            $data=$user->verifyEmail($_SESSION['email']);
            $verifiedemail="your email has been verified successfully";
            unset($_SESSION['otp']);
            unset($_SESSION['email']);
        } else {
            $verifiedemail="Please Enter Correct OTP";
        }
    } else {
        $verifiedemail="Please Click on Send OTP First";
    }
}
$verifiedphone="";
if (isset($_POST['verifymobileotp'])) {
    $otpmobile=$_POST['mobileotp'];
    if (isset($_SESSION['mobileotp'])) {
        if ($otpmobile=$_SESSION['mobileotp']) {
            require_once 'tbl_user.php';
            $user=new tbl_user();
            $data=$user->verifyPhone($_SESSION['mobile']);
            $verifiedphone="your phone has been verified successfully";
            unset($_SESSION['mobileotp']);
            unset($_SESSION['mobile']);
        } else {
            $verifiedphone="Please Enter Correct OTP";
        }
    } else {
        $verifiedphone="Please Click on Send OTP First";
    }
}
?>
<link rel="stylesheet" href="css/swipebox.css">
            <script src="js/jquery.swipebox.min.js"></script> 
                <script type="text/javascript">
                    jQuery(function($) {
                        $(".swipebox").swipebox();
                    });
                </script>
<!--script-->
</head>
<body>
<?php include_once "navbar.php";?>
<!---login--->
<div class="content">
    <div class="main-1">
        <div class="container">
            <div class="login-page">
                <div class="account_grid">
                <div class="row">
                    <div class="col-md-5 login-right pull-left">
                    <h3>Verify Email</h3>
                        <form action='verify.php' method="post">
                            <input type="submit" value="Get OTP" id="email-submit" name="emailsubmit">
                        <div class="success-msg"><?php echo(isset($emailsuccess))? $emailsuccess: "" ?></div>
                        <div class="error-msg"><?php echo(isset($emailfailure))? $emailfailure: "" ?></div>
                            <div>
                            </div>
                            <div>
                        </form>
                        <form action='verify.php' method="post">
                            <div>
                            <span>Enter OTP<label>*</label></span>
                                <input type="text" name="emailotp" id="emailotp" required> 
                            </div>
                            <input type="submit" value="Verify OTP" id="verifyemailotp" name="verifyemailotp">
                            <div class="success-msg"><?php echo(isset($verifiedemail))? $verifiedemail: "" ?></div>
                            <div>
                            </div>
                            <div>
                        </form>
                    </div>
                    </div>
                    </div>
                  
                    <div class="col-md-5 login-right pull-right">
                        <h3>Verify Mobile Number</h3>
                        <form method="post" action="verify.php">
                            <input type="submit" value="Get OTP" id="mobile-submit" name="mobilesubmit">
                            <div class="success-msg"><?php echo(isset($phonesuccess))? $phonesuccess: "" ?></div>
                            <div class="error-msg"><?php echo(isset($phonefailure))? $phonefailure: "" ?></div>
                            <div>
                            </div>
                            <div>
                        </form>
                        <form method="post" action="verify.php">
                            <div>
                            <span>Enter OTP<label>*</label></span>
                                <input type="text" name="mobileotp" id="mobileotp" required> 
                            </div>
                            <input type="submit" value="Verify OTP" id="verifymobileotp" name="verifymobileotp">
                            <div class="success-msg"><?php echo(isset($verifiedphone))? $verifiedphone: "" ?></div>
                            <div>
                            </div>
                            <div>
                        </form>
                    </div>	
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- login -->
<script>
    $('#email-submit').click(function(){
        $(this).hide();
    });
    $('#mobile-submit').click(function(){
        $(this).hide();
    });
</script>
<?php
include "footer.php";
?>