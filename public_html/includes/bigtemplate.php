<?php 
include $_SERVER['DOCUMENT_ROOT']."/includes/php_header.php";
$profile = $u->getUserDetails($_SESSION['user_id']);
?> 
<div id="wrapper">



        <!-- Navigation -->

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

            <!-- Brand and toggle get grouped for better mobile display -->

            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">

                    <span class="sr-only">Toggle navigation</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                </button>

                <a class="navbar-brand" href="#">Uk2MeOnline</a>

            </div>

            <!-- Top Menu Items -->

            <ul class="nav navbar-right top-nav">



                <li class="dropdown">
                    <a href="/logout.php" class="dropdown-toggle"><i class="fa"></i>Logout</a>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $profile['first_name']. " ". $profile['last_name']; ?></a>

                </li>

            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

            <div class="collapse navbar-collapse navbar-ex1-collapse">

                <ul class="nav navbar-nav side-nav">

                    <li>

                        <a href="manage_users.php"><i class="fa fa-fw fa-user"></i> Users </a>

                    </li>


                    <li>

                        <a href="manage_categories.php"><i class="fa fa-fw fa-edit"></i> Categories</a>

                    </li>
		
	             <li>

                        <a href="manage_subcategories.php"><i class="fa fa-fw fa-edit"></i> sub Categories</a>

                    </li>

                     <li>

                        <a href="manage_shops.php"><i class="fa fa-fw fa-edit"></i>Shops</a>

                    </li>
		
		 <li>
                <a href="manage_content.php"><i class="fa fa-fw fa-edit"></i>Content</a>
                </li>


		<li>
		<a href="manage_coupon_codes.php"><i class="fa fa-fw fa-edit"></i>Coupons</a>
		</li>

		<li>
                <a href="manage_logos.php"><i class="fa fa-fw fa-edit"></i>Logos</a>
                </li>


		<li>
		<a href="manage_banners.php"><i class="fa fa-fw fa-edit"></i>Banners</a>
		</li>

		 <li>
                <a href="manage_promobanners.php"><i class="fa fa-fw fa-edit"></i>Promotional Banners</a>
                </li>

		




                    <!--<li>

                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-edit"></i> Boxes <i class="fa fa-fw fa-caret-down"></i></a>

                        <ul id="demo" class="collapse">

                            <li>

                                <a href="manage_lunch_box.php">Lunch Box</a>

                            </li>

                            <li>
                                <a href="manage_meal_packs.php">Meal Box</a>
                            </li>
                            <li>
                                <a href="manage_munch_box.php">Munch Box</a>
                            </li>

                        </ul>

                    </li>

-->
                </ul>

            </div>

            <!-- /.navbar-collapse -->

        </nav>



        <div id="page-wrapper">



            <div class="container-fluid">



                <!-- Page Heading -->

                <div class="row">

                    <div class="col-lg-12">


                    </div>

                </div>
