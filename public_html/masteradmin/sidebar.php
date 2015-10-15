<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->

			<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        
				<li class="<?php # echo $updateprofileopen;?>">
					<a href="updateprofile.php">
					<i class="icon-user"></i>
					<span class="title">Update Profile</span>
					</a>
				</li>

        
				
				<li class="<?php #echo $languageopen;?>">
					<a href="#">
					<i class="icon-doc"></i>
					<span class="title">Categories</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu" style="<?php #echo $languagedisplay;?>">
						<li class="<?php #echo $alllanguageopen;?>">
                                                    <a href="all_categories.php">
							All Categories</a>
						</li>
						<li class="<?php #echo $addlanguageopen;?>">
							<a href="add_category.php">
							Add Category</a>
						</li>
					</ul>
				</li>
				<li class="<?php #echo $languageopen;?>">
					<a href="#">
					<i class="icon-doc"></i>
					<span class="title">Sub Categories</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu" style="<?php #echo $languagedisplay;?>">
						<li class="<?php #echo $alllanguageopen;?>">
                                                    <a href="all_sub_categories.php">
							All Sub Categories</a>
						</li>
						<li class="<?php #echo $addlanguageopen;?>">
							<a href="add_sub_category.php">
							Add Sub Category</a>
						</li>
					</ul>
				</li>


              <li class="<?php #echo $languageopen;?>">
					<a href="#">
					<i class="icon-doc"></i>
					<span class="title">Charity</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu" style="<?php #echo $languagedisplay;?>">
						<li class="<?php #echo $alllanguageopen;?>">
                                                    <a href="all_charities.php">
							All Charity</a>
						</li>
						<li class="<?php #echo $addlanguageopen;?>">
                                                    <a href="add_charity.php">
							Add Charity</a>
						</li>
					</ul>
				</li>
                                
                                <li class="<?php #echo $languageopen;?>">
					<a href="#">
					<i class="icon-doc"></i>
					<span class="title">Members</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu" style="<?php #echo $languagedisplay;?>">
						<li class="<?php #echo $alllanguageopen;?>">
                                                    <a href="all_members.php">
							All Members</a>
						</li>
						<li class="<?php #echo $addlanguageopen;?>">
                                                    <a href="add_member.php">
							Add Member</a>
						</li>
					</ul>
				</li>
				
           
				

			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
