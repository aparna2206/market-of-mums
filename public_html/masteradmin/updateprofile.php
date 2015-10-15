
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Update Profile</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<?php include('top.php');?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-sidebar-closed-hide-logo">
<?php include("header.php");?>
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<?php include("sidebar.php");?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>Update Profile</h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- END PAGE HEAD -->

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
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXTRAS PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<?php echo stripslashes($t_detail_row['template_name']);?>
							</div>					
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form action="#" class="form-horizontal form-bordered" method="post" id="emailtemplateform">	
								<div class="form-body">									
									<div class="form-group">
										<label class="control-label col-md-2">Email Address <span class="require"> * </span></label>
										<div class="col-md-10">
											<input type="text" id="email_address" name="email_address" class="form-control" placeholder="Type Email Address." value="<?php echo $email_address;?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">New Password<span class="require"> * </span></label>
										<div class="col-md-10">
											<input type="password" id="newpass" name="newpass" class="form-control" placeholder="Type New Password." value="">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Re-Type Password <span class="require"> * </span></label>
										<div class="col-md-10">
											<input type="password" id="retypepass" name="retypepass" class="form-control" placeholder="Re-Type Password." value="">
										</div>
									</div>
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-2 col-md-10">
											<button type="submit" class="btn green"><i class="fa fa-check"></i> Save & Update</button>
											<input type="hidden" name="Submit"  value="Save & Update">
										</div>
									</div>
								</div>
							</form>
							<!-- END FORM-->
						</div>
					
						
					</div>
					<!-- END EXTRAS PORTLET-->
					
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php include("footer.php");?>
<script>
$(function () {
	   $('table').footable({ bookmarkable: { enabled: true }}).bind({
		'footable_filtering': function (e) {
			var selected = $('.filter-status').find(':selected').text();
			if (selected && selected.length > 0) {
				e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
				e.clear = !e.filter;
			}
		},
		'footable_filtered': function() {
			var count = $('table.demo tbody tr:not(.footable-filtered)').length;
			$('.row-count').html(count + ' rows found');
		}
	});

	$('.clear-filter').click(function (e) {
		e.preventDefault();
		$('.filter-status').val('');
		$('table.demo').trigger('footable_clear_filter');
		$('.row-count').html('');
	});

	$('.filter-status').change(function (e) {
		e.preventDefault();
		$('table.demo').data('footable-filter').filter( $('#filter').val() );
	});
});
jQuery(document).ready(function() {       
	// initiate layout and plugins
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Demo.init(); // init demo features
	ComponentsPickers.init();
	TableAdvanced.init(); // Advanced table
	ComponentsEditors.init(); // HTML5 editor
	jQuery("#emailtemplateform").validate({
		rules: {
			email_subject: "required",
			email_body: "required",
		},
		messages: {
			email_subject: "Required",
			email_body: "Required",
		}
	});
});   
</script>
<!-- END JAVASCRIPTS -->

</body>
<!-- END BODY -->
</html>