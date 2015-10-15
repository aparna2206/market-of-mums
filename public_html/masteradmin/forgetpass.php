<?php
	include("db.php");
	include("functions.php");
	
	function checkEmail($email)
    {
        $result = TRUE;
          if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
        {
            $result = FALSE;
          }
          return $result;
    }

	$arr = array();
	$arrs = array();
	if ($_POST['Submit']!='' && $_POST['Submit']=="Submit")
	{
		$email = wfi('emailid');
		$email = wdpi($email);
		if($email=="")
		{
			array_push($arr,"Please Enter Email");
		}
		else
		{
			if (!checkEmail($email))
			{
				array_push($arr,"Please Enter Valid Email Address");
			}
			else
			{
			$query="select * from tbl_admin where email='".wdi($email)."'";
			$query_result = mysqli_query($con,$query);
				if (mysqli_num_rows($query_result)==0)
				{
					array_push($arr,"Email Address not exists");
				}
			}
		}

		if(count($arr)==0)
		{
			$query = mysql_query();
			
			$squery="select * from tbl_admin where email='".wdi($email)."'";
			$query_result = mysqli_query($con,$squery);
			if(mysqli_num_rows($query_result)==1)
			{
					$length =10;
		
					$conso=array("b","c","d","f","g","h","j","k","l","m","n","p","r","s","t","v","w","x","y","z");
					$vocal=array("5","8","7","9","6");
					
					$password="";
					srand ((double)microtime()*1000000);
					$max = $length/2;
					for($i=1; $i<=$max; $i++)
					{
						$password.=$conso[rand(0,19)];
						$password.=$vocal[rand(0,4)];
					}
					$newpass = $password;
			}
			$del_sql="update tbl_admin set password='".wdi($newpass)."'";
			rn_sqli_qry($del_sql);	
			
			$body1 = "<font face=verdana size=2>";
			$body1 .= "Your New Password<br><br>";
			$body1 .= "EMAIL-ID: ".$email."<br>";
			$body1 .= "PASSWORD: ".$newpass."<br>";
			$body1 .= "</font>";
			$emsubject = "Your Password.";
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= 'From: admin@twentyeight.com' . "\r\n" .
							'Reply-To: admin@twentyeight.com' . "\r\n" .
							'X-Mailer: PHP/' . phpversion();
			if (mail($email, $emsubject, $body1, $headers)) 
			{
				array_push($arrs,"A new password has been sent to your e-mail address. Please check your mail box.");
			}
			else
			{
				array_push($arr,"Message delivery failed...");
			}
			
			//header("location: passsentmsg.php");
			
		}
	}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Forget Password</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="assets/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="templates/admin4/favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="admin.php">
				<img src="assets/admin/layout4/img/logo-light.jpg" alt="logo" class="logo-default"/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form class="forget-form" action="" method="post">
		<h3>Forgot Password ?</h3>
		<p>
			&nbsp;
		</p>
		<?php
			if (count($arr)>0)
			{
			?>
			<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				
				<?php
				for ($i=0;$i<count($arr);$i++)
				{
					echo $arr[$i]."<br>";
				}
				?>
				
			</div>
			<?php
			}
			?>
			<?php
			if (count($arrs)>0)
			{
			?>
			<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				
				<?php
				for ($i=0;$i<count($arrs);$i++)
				{
					echo $arrs[$i]."<br>";
				}
				?>
				
			</div>
			<?php
			}
			?>
		<div class="form-group">
			<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Enter your e-mail address below" name="emailid" id="emailid"/>
		</div>
		<div class="form-actions">
		<button type="button" id="back-btn" class="btn btn-default" onclick="window.location.href='admin.php'">Back</button>
			<button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
			<input type="hidden" name="Submit"  value="Submit">
			
			
		</div>
		
	</form>
	<!-- END FORGOT PASSWORD FORM -->
	<!-- BEGIN REGISTRATION FORM -->
	
	<!-- END REGISTRATION FORM -->
</div>
<div class="copyright">
	 © Nocell
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Login.init();
Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>