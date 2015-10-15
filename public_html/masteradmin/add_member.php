<?php 
include $_SERVER['DOCUMENT_ROOT']."/includes/php_header.php";

$msg='';
//echo $_SESSION['user_id'];
$user_types = $u->getUserTypes();

if($_POST['Submit'] == "Publish")
{

	if($u->addUsers($_POST)){
            
		$msg = "<span class=\"message\">User Added Successfully.</span>";
	}else{
		$msg = "<span class=\"error\">Unable to add User.</span>";
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
<title>Add Member</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<?php include('top.php');?>
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
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
					<h1>Add Member</h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- END PAGE HEAD -->
                        <?php if($msg!=''){ ?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				<?php echo $msg;?>
			</div>
                        <?php } ?>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
                            <form action="add_member.php" method="post" id="addbannerform" enctype="multipart/form-data">
				<div class="col-md-12">
				
					<!-- BEGIN EXTRAS PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-doc"></i>Member Details
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<div class="form-horizontal form-bordered">	
								<div class="form-body">
								
								
								
									<div class="form-group">
										<label class="control-label col-md-2">Name <span class="require"> * </span></label>
										<div class="col-md-10">
                                                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
										</div>
									</div>

											<div class="form-group">
												<label class="control-label col-md-2">User Type <span class="require"> * </span> </label>
												<div class="col-md-10">
												<select class="form-control" id="usertype" name="usertype">
								<?php foreach($user_types as $u_type) { ?>
                                                                                        <option value="<?php echo $u_type['id'];?>" ><?php echo $u_type['type'];?></option>
								<?php } ?>
													</select>
												</div>
											</div>



									<div class="form-group">
										<label class="control-label col-md-2">Email <span class="require"> * </span> </label>
										<div class="col-md-10">
                                                                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="" required>
										</div>
									</div>										
																		

											
									<div class="form-group">
										<label class="control-label col-md-2">UserName <span class="require"> * </span></label>
										<div class="col-md-10">
                                                                                    <input type="text" id="username" name="username" class="form-control" placeholder="UserName" value="<?php echo $username?>" required>
										</div>
									</div>									
								
									<div class="form-group">
										<label class="control-label col-md-2">Password <span class="require"> * </span></label>
										<div class="col-md-10">
											<input type="password" id="password" name="password" class="form-control" placeholder="Password" value="" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Confirm Password <span class="require"> * </span></label>
										<div class="col-md-10">
											<input type="password" id="conpassword" name="conpassword" class="form-control" placeholder="Confirm Password" value=""  required>
										</div>
									</div>																	

								</div>
							</div>
							<!-- END FORM-->
						</div>
					</div>
					<!-- END EXTRAS PORTLET-->
					
					
					
					
					<!-- BEGIN PAGE CONTENT-->
					<div class="row">
						<div class="col-md-12">
							<!-- BEGIN EXTRAS PORTLET-->
							<div class="portlet box yellow-crusta">
								<div class="portlet-title">
									<div class="caption">
										<i class="icon-doc"></i>Action
									</div>
								</div>
								<div class="portlet-body form">
									<!-- BEGIN FORM-->
									<div class="form-horizontal form-bordered">	
										<div class="form-body">	
											<div class="form-group last">
												<label class="control-label col-md-2">Status</label>
												<div class="col-md-10">
													<select class="form-control" id="status" name="status">
														<option value="1" <?php if($status=="1"){echo "Selected";}?>> Active </option>
														<option value="0" <?php if($status=="0"){echo "Selected";}?>> Inactive </option>
													</select>
												</div>
											</div>
										</div>
                                                                            <input type="hidden" id="actid" name="actid" class="form-control"  value="<?php echo $_SESSION['user_id']; ?>">
										<div class="form-actions">
											<div class="row">
												<div class="col-md-offset-2 col-md-10">
													<button type="submit" class="btn green"><i class="fa fa-check"></i> Publish</button>
													<input type="hidden" name="Submit"  value="Publish">
													<button type="button" id="back-btn" class="btn btn-default" onclick="window.location.href='all_member.php'">Back</button> 
													
												</div>
											</div>
										</div>
									</div>
									<!-- END FORM-->
								</div>
							</div>
							<!-- END EXTRAS PORTLET-->
							
							
							
							
						</div>
					</div>
					<!-- END PAGE CONTENT-->
		</div>
		</form>
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
	   jQuery("#addcourseform").validate({
		rules: {
			course_name: "required",
			course_description: "required",
			course_detail: "required",
		},
		messages: {
			course_name: "Required",
			course_description: "Required",
			course_detail: "Required",
		}
	});
});   
</script>

