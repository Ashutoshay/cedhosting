<?php
// include_once 'admin/tbl_product.php';
// $product=new tbl_product();
?>
<!---header--->
<div class="header">
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <i class="sr-only">Toggle navigation</i>
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                        <i class="icon-bar"></i>
                    </button>				  
                    <div class="navbar-brand">
                        <h1><a href="index.php"><img src="images/2.jpg"  alt="" width="100" height="90"></a></h1>
                    </div>
                </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home <i class="sr-only">(current)</i></a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li>
                            <a  href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >Hosting<i class="caret"></i></a>
                            <ul class="dropdown-menu" >
                            <?php
                            // $data=$product->getSubCategoryNav();
                            // if ($data!=false) {
                            //     for ($i=0;$i<count($data);$i++) {
                            //         echo '<li ><a href="catpage.php?id='.$data[$i]['id'].'">'.$data[$i]['prod_name'].'</a></li>';
                            //     }
                            // }
                            ?>
                            </ul>			
                        </li>
                        <li><a href="pricing.php">Pricing</a></li>
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="cart.php" id="fa-fa-font-size"><i class="fa fa-shopping-cart"><span class="badge badge-info"><?php echo (isset($_SESSION['cartdata']))? count($_SESSION['cartdata']) : "" ?></span></i></a></li>
                        <?php
                        if (isset($_SESSION['user'])) {
                            echo '<li><a href="logout.php">Logout</a></li>';
                        }
                        else {
                           
                            echo '<li><a href="login.php">Login</a></li>';
                        }
                        ?>
                    </ul>	
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
</div>