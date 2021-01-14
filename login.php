<?php
include "header.php";
if (isset($_SESSION['admin'])){
    header('location:admin/');
}
include "tbl_user.php";
$error="";
$user=new tbl_user();
if (isset($_POST['submit'])) {
    $email=$_POST['email'];
    $password=$_POST['password'];
    $email=trim($email);
    $password=trim($password); 
    $error=$password;
    $data=$user->login($email, $password);
    if ($data==false) {
        $error="Email or Password dosen't match";
    } else {
        $_SESSION['email']=$data['email'];
        $_SESSION['name']=$data['name'];
        $_SESSION['mobile']=$data['mobile'];
        header('Location:verify.php');
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
                    <div class="col-md-6 login-left">
                            <h3>new customers</h3>
                            <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
                            <a class="acount-btn" href="signup.php">Create an Account</a>
                    </div>
                    <div class="col-md-6 login-right">
                        <h3>registered</h3>
                        <p>If you have an account with us, please log in.</p>
                        <form action='login.php' method="post">
                            <div>
                            <span>Email Address<label>*</label></span>
                            <input type="text" id="email" name="email" required> 
                            </div>
                            <div>
                            <span>Password<label>*</label></span>
                            <input type="password" name="password" id="password" required> 
                            </div>
                            <a class="forgot" href="#">Forgot Your Password?</a>
                            <input type="submit" value="Login" id="submit" name="submit">
                        </form>
                        <div class="error-msg"><?php echo(isset($error))? $error: "" ?></div>
                    </div>	
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- login -->
<?php
include "footer.php";
?>