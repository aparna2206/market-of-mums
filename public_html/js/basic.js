function cal_discount(flag){
	var amount=document.getElementById('amount').value;
	if(amount !='' ){
		if(flag==1){
			var per = document.getElementById('discount_per').value; 
			var dis_amnt= (per * amount)/100;
			document.getElementById('discount_amount').value=dis_amnt;
		}else{
			var dis_amnt = document.getElementById('discount_amount').value; 
			var per= (dis_amnt * 100)/amount;
			document.getElementById('discount_per').value=per;

		}
	}else{
		alert('Amount field should not be empty.!');
		return false;
	}
}

function show_edit_user_frm(id){
                $.post('/ajax/edit_user_form.php', {id: id}, function(data) {
                                jQuery('#user_form').html(data);
//alert('data='+ data);
                });
}




function show_edit_category_frm(id){
  
                $.post('/ajax/edit_category_form.php', {id: id}, function(data) {
                                jQuery('#category_form').html(data);
//alert('data='+ data);
                });
}






function getBoxList(d_date){
                $.post('/ajax/get_box_data_by_date.php', {d_date: d_date}, function(data) {
                                jQuery('#days_boxes').html(data);
		//alert("data="+data);
                });
}
function show_order_details(id){
                $.post('/ajax/order_details.php', {id:id}, function(data) {
                 jQuery('#category_form').html(data);
                });
}

function show_recipe_details(id){
                $.post('/ajax/recipe_details.php', {id:id}, function(data) {
                 jQuery('#rec_details').html(data);
        	jQuery.featherlight('#rec_details');
                });

}
function get_checked_categories(){
        var chkArray= [];
        $("#cat_list input:checked").each(function(){
                chkArray.push($(this).val());
        });
        var selected;
        selected =  chkArray.join(",") ;
        /*if(selected.length > 1){
                alert("you have selected " + selected);
        }else{
                alert("you have not selected " );

        }*/
        return selected;
}

function level_click_action(level){
	 jQuery('#rec_level').val(level);	
 	 getRecipeList(level);
}
function validate_qnt(qnt,limit){
	if(limit < $(qnt).val()){
		$(qnt).val(limit);
	}
}
function show_edit_coupons_frm(id){
  $.post('/ajax/edit_coupons_frm.php', {id: id}, function(data) {
      jQuery('#coupons_form').html(data);
//alert('data='+ data);
   });
}


function show_edit_sub_category_frm(id){

                $.post('/ajax/edit_sub_category_form.php', {id: id}, function(data) {
                                jQuery('#category_form').html(data);
//alert('data='+ data);
                });
}


// for shops management
function show_edit_shops_frm(id){

                $.post('/ajax/edit_shops_form.php', {id: id}, function(data) {
                                jQuery('#category_form').html(data);
//alert('data='+ data);
                });
}

// for manage users ajax
function show_user_frm(id){

                $.post('/ajax/edit_user_form.php', {id: id}, function(data) {
                                jQuery('#category_form').html(data);
//alert('data='+ data);
                });
}


// for content ajax
function show_edit_content_frm(id){

                $.post('/ajax/edit_content_form.php', {id: id}, function(data) {
                                jQuery('#category_form').html(data);
//alert('data='+ data);
                });
}

// for simple banner ajax
function show_edit_banner_frm(id){

                $.post('/ajax/edit_banner_form.php', {id: id}, function(data) {
                                jQuery('#category_form').html(data);
//alert('data='+ data);
                });
}

//for promobanner
function show_edit_promobanner_frm(id){

                $.post('/ajax/edit_promobanner_form.php', {id: id}, function(data) {
                                jQuery('#category_form').html(data);
//alert('data='+ data);
                });
}


function show_shops(id){

                $.post('/ajax/shops.php', {id: id}, function(data) {
                                jQuery('#shops_div').html(data);
//alert('data='+ data);
                });
}

//for videos
function show_edit_video_frm(id){

                $.post('/ajax/edit_video_form.php', {id: id}, function(data) {
                                jQuery('#category_form').html(data);
//alert('data='+ data);
                });
}



function show_edit_logos_frm(id){

                $.post('/ajax/edit_logos_form.php', {id: id}, function(data) {
                                jQuery('#category_form').html(data);
//alert('data='+ data);
                });
}

function hideshow(flag){
if(flag ==1){
	document.getElementById('btn_cod').style.display='block';
	document.getElementById('btn_cc').style.display='none';
}else{
	document.getElementById('btn_cod').style.display='none';
	document.getElementById('btn_cc').style.display='block';

}

}

function show_edit_orders_frm(id){

             //   $.post('/ajax/order_details.php', {id: id}, function(data) {
		$.post('/ajax/myorder_details.php', {id: id}, function(data) {
                                jQuery('#order_form').html(data);
//alert('data='+ data);
                });
}

