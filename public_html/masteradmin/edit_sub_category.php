<?php include $_SERVER['DOCUMENT_ROOT']."/includes/php_header.php";
$msg='';
if($_GET['cat_id'] !=''){
	if($_POST['Submit'] == "Publish"){
		$_POST['id']=$_GET['cat_id'];
		if($u->updateSubCate($_POST)){
			$msg = "<span class=\"message\">Sub-Category Updated Successfully.</span>";
		}else{
			$msg = "<span class=\"error\">Unable to Update Sub-category.</span>";
		}
	}
	$category = $u->getSubCategoryDetails($_GET['cat_id']);
}
$categories = $u->getActiveCategories();
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
<title>Edit Sub-Category</title>
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
					<h1>Edit Sub-Category</h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- END PAGE HEAD -->
			
			<?php
			if ($msg !='')
			{
			?>
			<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				
				<?php
					echo $msg;
				?>
				
			</div>
			<?php
			}
			?>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
			<form action="" method="post" id="editbannerform">
				<div class="col-md-12">
				
					<!-- BEGIN EXTRAS PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-doc"></i>Sub Category Details
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<div class="form-horizontal form-bordered">	
								<div class="form-body">
									
									<div class="form-group">
										<label class="control-label col-md-2">Sub Category <span class="require"> * </span></label>
										<div class="col-md-10">
                                                                                    <input type="text" id="sub_category" name="sub_category" class="form-control" placeholder="Sub Category" value="<?php if($category['sub_category']!=''){echo $category['sub_category'];}?>" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2"> Category <span class="require"> * </span></label>
										<div class="col-md-10">
									<select name="category" id="category" required>
									<?php foreach($categories as $cat){?>
									<option value="<?php echo $cat['id']?>" <?php if($category['category'] == $cat['id']){echo 'selected';}?>><?php echo $cat['category']?></option>
									<?php } ?>
									</select>
			
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Details <span class="require"> * </span></label>
										<div class="col-md-10">
                                                                                    <input type="text" id="details" name="details" class="form-control" placeholder="Details" value="<?php if($category['description']!=''){echo $category['description'];}?>" required>
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
													<select class="form-control" id="lstatus" name="lstatus">
														<option value="1" <?php if($category['is_active']=="1"){echo "Selected";}?>> Active </option>
														<option value="0" <?php if($category['is_active']=="0"){echo "Selected";}?>> Inactive </option>
													</select>
												</div>
											</div>
										</div>									
										<div class="form-actions">
											<div class="row">
												<div class="col-md-offset-2 col-md-10">
													<button type="submit" class="btn green"><i class="fa fa-check"></i> Publish</button>
													<input type="hidden" name="Submit"  value="Publish">
													<button type="button" id="back-btn" class="btn btn-default" onclick="window.location.href='all_sub_categories.php'">Back</button> 
													
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
   Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Demo.init(); // init demo features
   TableAdvanced.init(); // Advanced table
   ComponentsEditors.init(); // HTML5 editor
   jQuery("#editcourseform").validate({
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
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
