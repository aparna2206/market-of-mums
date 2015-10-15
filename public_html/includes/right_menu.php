<?php
include $_SERVER['DOCUMENT_ROOT']."/includes/php_header.php"; 
$menus = $u->getLatestMenucard();
$recipes = $u->getAllRecipesByRecipeId();
$i =1;
?>
<?php 	foreach($menus as $menu){ 
	$recs = explode(",",$menu['recipe_ids']);
	$date = new DateTime($menu['date']);
	?>
	<div class="accordion-group">
	<div class="accordion-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#collapse_<?php echo $i;?>">
		<?php echo $date->format('d-m-Y l'); ?> Todays menu
		</a>
	</div>
	<div id="collapse_<?php echo $i;?>" class="accordion-body collapse" style="height: 0px; ">
	<div class="accordion-inner">
	<ul>
	<?php foreach($recs as $rec){ 
	echo "<li>$recipes[$rec]</li>";
	}?>
	</ul>
	</div>
	</div>
	</div>
	<?php  $i++; }?>
