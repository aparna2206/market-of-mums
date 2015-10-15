<?php 
include $_SERVER['DOCUMENT_ROOT']."/includes/php_header.php";
$cats = $u->getCategoriesGpParent();
$parent_cats = $u->getParentsCategories();
//$shops = $u->getShopById($_GET['cat_id']);
//$cat = $u->getCategoriesbyId($_GET['cat_id']);


?>
                <div id="MainMenu">


    
  <div class="list-group panel">
<!--test code-->
    
<?php foreach($parent_cats as $p) { ?> 
<a href="#sub<?php echo $p['id']?>" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu"><?php echo $p['category']; ?></a>

    <div class="collapse" id="sub<?php echo $p['id']?>">
        <?php
foreach($cats[$p['id']] as $c){ ?>
      <a href="/shop.php?cat_id=<?php echo $c['id']; ?>" class="list-group-item" ><?php  echo $c['category'];?></a>
    <?php } ?>
    </div>
<?php }  ?>


  </div>
</div>

