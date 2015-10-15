<?php
include $_SERVER['DOCUMENT_ROOT']."/includes/php_header.php"; 
$user_details=$u->user_profile;
$wallet = $user_details['balance'];
if($wallet ==''){
$wallet =0;
}
?>

<header>
  <div class="container">
    <div class="row header-top">
    <div class="clearfix">
      <div class="col-lg-3 col-sm-12 logo"> <a href="index.php" title="uk2me"> <img src="" title="uk2me" alt="Uk2me" /> </a> </div>
      <div class="col-lg-9 col-sm-12">
      	<div class="top_links top_links_account clearfix">
	<?php if($_SESSION['user_id'] !=''){ ?>
         <a href="/logout.php" > Logout </a>         
<!--         <a href="/user_complaint.php" > Post Complaints </a>         
         <a href="/user_feedback.php" > Feedback </a>         
         <a href="/reset_password.php" > Reset Password  </a>         
         <a href="my_profile.php"> My Profile</a>
         <a href="my_orders.php"> My Orders</a>-->
<!--	<a href="/admin/manage_categories.php"> Admin Panel</a> -->
<!--         <a href="terms_conditions.php"> Terms and Conditions</a>
         <a href="#url"> My Wallet (<?php echo $wallet;?>)</a> -->
	<?php } else { ?>
		 <a href="register.php"  class="btn-login register"> Register </a>
         <a href="#url" data-featherlight="#fl1"  class="btn-login"> Login </a>
	<?php } ?>
        </div>
        <div class="navbar-wrapper">
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
          
            <div class="navbar-header">
            <div class="container">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
           </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
<!--                <li><a href="about_us.php">About us</a></li>
                <li><a href="our_products.php">Our Products</a></li>
                <li><a href="how_to_order.php">How to Order</a></li>
                <li><a href="event_catering.php">Events Catering</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>   -->
               </ul>
            </div>
          </div>
        </nav>
       </div>
      </div>
     </div>
    </div>
  </div>
  
</header>
<div class="lightbox" id="fl1">
             <div class="login_form">
             <h2>Login</h2>
                        <div class="clearfix">

                <form action="index.php" method="post">
                        <ul>
                                 <li class="col-lg-12 col-sm-12">
                                <label>Email:<span>*</span></label>
                                 <input type="email" name="email" value=""/>

                            </li>
                            <li class="col-lg-12 col-sm-12">
                                <label>Password :<span>*</span></label>
                                <input type="password" name="password" value=""/>
                            </li>


                        </ul>
                         <div class="clearfix actionlinks">
                         <input type="submit" name="submit" value="Login"  class="btn_submit" />
                    </div>
		</form>
                    </div>

                    </div>

                </div>

<div class="padding_top">
</div>

