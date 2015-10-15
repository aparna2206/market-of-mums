<?php 
include $_SERVER['DOCUMENT_ROOT']."/includes/php_header.php";
$currency = $u->getCurrency();
//var_dump($currency);


?>
<header>

        	<div class="container">  

            	<div class="row header-top">

                	<div class="col-lg-3 col-sm-6 logo"> 

                    	<a href="index.php" title="Charming Temptationa">

                        	<img src="images/logo.jpg" title="UK2ME Logistics" alt="UK2ME Logistics" />

                        </a>

                    </div>

                    <div class="col-lg-9 col-sm-12 header_right">

                    	

                        <div class="header_top_links clearfix">

                        	<div class="shopping_cart">

                            SHOPPING CART <span>(0)</span>

                            </div>

<!--fb like-->

<script language="javascript" type="text/javascript">    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    } (document, 'script', 'facebook-jssdk'));</script>



<!--fb-->

                    	<div class="social_links">

                        	<a href="https://twitter.com/uk2me" class="twitter">twitter</a>

                            <a href="https://www.facebook.com/UK2MELOGISTICS" class="facebook">Facebook</a>

                            <a href="#url" class="google">google</a>

                            <a href="https://www.youtube.com/channel/UCwF7z0IHW8jL956zhwv9LtA" class="youtub">youtube</a>

                            <a href="#url" class="social_icon">icon</a>

                            

                        </div>

                        

                        	

                             <div class="check_rate">

                        	<span>Check Rate</span>

                            <a class="Uk_icon" href="#url" title="UK Â£1= <?php echo $currency['uk']; ?> Naira , USA $1 = <?php echo $currency['usa']; ?> Naira">UK</a>

                            <a class="US_icon" href="#url" title="UK Â£1= <?php echo $currency['uk']; ?> Naira , USA $1 = <?php echo $currency['usa']; ?> Naira">US</a>

                        </div>

<div class="fb-like fb_iframe_widget" data-send="false" data-show-faces="false" data-action="like" data-layout="button_count" data-colorscheme="light" data-height="The pixel height of the plugin" data-width="The pixel width of the plugin" data-href="https://www.facebook.com/UK2MELOGISTICS" fb-xfbml-state="rendered" fb-iframe-plugin-query="action=like&app_id=&color_scheme=light&container_width=246&href=https://www.facebook.com/FUK2MELOGISTICS&layout=button_count&locale=en_US&sdk=joey&send=false&show_faces=false">
<br>

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

                <li><a href="aboutus.php">ABOUT US</a></li>

                <li><a href="shop.php?cat_id=4">STORE LIST</a></li>

                <li><a href="index.php">MY ACCOUNT</a></li>
		<?php if($_SESSION['user_id']==''){?>
                <li><a href="register.php">REGISTER NOW</a></li>
		<?php } ?>

                <li><a href="select_currency.php">ORDER NOW</a></li>

                <li><a href="faqs.php">FAQS</a></li>

                <li><a href="index.php">BLOG</a></li>
		<?php if($_SESSION['user_id']!='') {?>
 				<li ><a href="/logout.php" ><span>Logout</span></a></li>
			<?php } else { ?>
 				<li class="btn_sign_in"><a href="#url" data-featherlight="#fl1"><span></span></a></li>
			<?php } ?>
               </ul>

            </div>

          </div>

        </nav>

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
                                 <input type="email" name="email" value="" style=" padding: 8px;" required />

                            </li>
                            <li class="col-lg-12 col-sm-12">
                                <label>Password :<span>*</span></label>
                                <input type="password" name="password" value="" style=" padding: 8px;" required />
                            </li>
				<li> </br>
			    </li>			
	
                        </ul>
			
		
                         <div class="clearfix actionlinks">
                         <input type="submit" name="submit" value="Login"  class="btn"  />
                    </div>
                </form>
                    </div>

                    </div>

                </div>
 
