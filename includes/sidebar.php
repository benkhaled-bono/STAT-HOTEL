<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="https://www.mta.gov.dz" class="brand-link" target="_blanc">
        <img src="images/logomta.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-2"
            style="opacity: .9">
        <span class="brand-text font-weight-light " style="font-size: 22px;">MTA-ALGERIA</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" id="sidebar" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <?php 
	            	$page_name = basename($_SERVER['PHP_SELF']);
                    $dashboard_active = '';
                    $arrives_open_menu = '';
                    $liste_arrives_active = '';
                    $nuitee_incompl_active = '';
                    $raport_open_menu = '';
                    $raport_arrive_total_active = '';
                    $raport_nuitee_total_active = '';
                    $raport_details_arrive_active = '';
                    $user_active = '';

//  KEEP OPEN MENU + ACTIVE ********************** 
                    if($page_name == 'dashboard.php')
	            	{
	            		$dashboard_active = 'active';
	            	}
// ---- Start Arrive Nuitee Menu
                    if($page_name == 'nuitees.php' or $page_name == 'nuitee_incomplet.php')
	            	{
	            		$arrives_open_menu = 'menu-open';
                        $arrives_nuites_active = 'active';
	            	}
                    if($page_name == 'nuitees.php')
	            	{
	            		$liste_arrives_active = 'active';
	            	}
                    if($page_name == 'nuitee_incomplet.php')
	            	{
	            		$nuitee_incompl_active = 'active';
	            	}
// ---- Start Raport Menu
                    if($page_name == 'raport_nuitee_total.php' or $page_name == 'raport_arrive_total.php' or $page_name == 'raport_details_arrive.php'  )
	            	{
                        $raport_open_menu  = 'menu-open';
                       
	            	}
                    if($page_name == 'raport_arrive_total.php')
	            	{
                        $raport_arrive_total_active = 'active';
	            	}
                    if($page_name == 'raport_nuitee_total.php')
	            	{
                        $raport_nuitee_total_active = 'active';
	            	}
                    if($page_name == 'raport_details_arrive.php')
	            	{
                        $raport_details_arrive_active = 'active';
	            	}
// ------------------- user ***************** 
                    if($page_name == 'user.php')
	            	{
	            		$user_active = 'active';
	            	}
	            	?>
                <!-- End Menu PHPs -->
                <li class="nav-header">
                    <a href="dashboard.php" class="nav-link <?php echo $dashboard_active; ?>"
                        style="font-size: 20px;"><i class="nav-icon fas fa-tachometer-alt" style="font-size: 24px;"></i>
                        لوحــة التحكم</a>
                </li>
                <li class="nav-header">
                    <a href="#" style="font-size: 16px; color:#e1ebeb">العمليات</a>
                </li>
                <!-- Start liste arrive nuite -->
                <li class="nav-item has-treeview <?php echo $arrives_open_menu; ?>">
                    <?php   
               // ------------------------ ACTIVE TREEVIEW LINK *********************
                    $link = '';
                    if($page_name == 'nuitees.php')
                    {
                        $link = 'active';
                    }
                    if($page_name == 'nuitee_incomplet.php')
                    {
                        $link = 'active';
                    }
                  
                    ?>
                    <a href="<?php echo $page_name; ?>" class="nav-link <?php echo $link; ?>">
                        <i class="nav-icon fas fa-bed" style="font-size: 22px; "></i>
                        <p style="font-size: 16px; "> الوافدون و الليالي <i class="right fas fa-angle-left"
                                style="font-size: 20px; "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ">
                        <li class="nav-item">
                            <a href="nuitees.php" class="nav-link <?php echo $liste_arrives_active; ?>">
                                <i class="nav-icon far fa-circle text-warning"></i>
                                <p>قائمة الوافدين و الليالي</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="nuitee_incomplet.php" class="nav-link <?php echo $nuitee_incompl_active ; ?>">
                                <i class="far fa-circle nav-icon text-warning"></i>
                                <p>حساب الشهر الموالي</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End liste arrive nuite -->
                <li class="nav-header">
                    <a href="#" style="font-size:16px; color:#e1ebeb "> التقارير
                    </a>
                </li>

                <!-- Start Rapport Liste-->
                <li class="nav-item has-treeview <?php echo $raport_open_menu; ?>">
                    <?php   
               // ------------------------ ACTIVE TREEVIEW LINK *********************
                    $link = '';
                    if($page_name == 'raport_arrive_total.php')
                    {
                        $link = 'active';
                    }
                    if($page_name == 'raport_details_arrive.php')
                    {
                        $link = 'active';
                    }
                    if($page_name == 'raport_nuitee_total.php')
                    {
                        $link = 'active';
                    }
                    ?>
                    <a href="<?php echo $page_name; ?>" class="nav-link <?php echo $link; ?>">
                        <i class="nav-icon fas fa-list" style="font-size: 22px; "></i>
                        <p style="font-size: 16px; "> التقــاريــــر
                            <i class="right fas fa-angle-left" style="font-size: 20px; "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ">
                        <li class="nav-item">
                            <a href="raport_details_arrive.php"
                                class="nav-link <?php echo $raport_details_arrive_active; ?>">
                                <i class="nav-icon far fa-circle text-warning"></i>
                                <p>التقرير المفصل</p>
                            </a>
                        </li>
                        <?php
            if ($arrive->is_dta_user() or $arrive->is_master_user() ) 
            {
            ?>
                        <li class="nav-item">
                            <a href="raport_arrive_total.php"
                                class="nav-link <?php echo $raport_arrive_total_active; ?>">
                                <i class="nav-icon far fa-circle text-warning"></i>
                                <p>اجمالي الوافدين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="raport_nuitee_total.php"
                                class="nav-link <?php echo $raport_nuitee_total_active; ?>">
                                <i class="nav-icon far fa-circle text-warning"></i>
                                <p>اجمالي الليالي</p>
                            </a>
                        </li>
                        <?php
                }
                ?>

                </li>
            </ul>
            </li>
            <!-- End Rapport Liste-->
            <?php
            if ($arrive->is_dta_user() or $arrive->is_master_user() ) 
            {
            ?>
            <li class="nav-header" style="font-size: 14px; ">
                <a href="#"> المراجع
                </a>
            </li>
            <li class="nav-item has-treeview ">
                <a href="#" class="nav-link ">
                    <i class="nav-icon fas fa-book-open" style="font-size: 22px; "></i>
                    <p>
                        المراجــع
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                <?php
                if ($arrive->is_master_user() ) 
                {
                ?>   
                    <li class="nav-item">
                        <a href="wilaya.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>الولا يات</p>
                        </a>
                    </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a href="etab_hebergement.php" class="nav-link ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>المؤسسات الفندقية</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../tables/simple.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>التصنيف</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../tables/jsgrid.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>اقسام الوافدون</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../tables/jsgrid.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>الجنسيات</p>
                        </a>
                    </li>
                </ul>
            </li>
            <?php
                }
                ?>
            <?php
                if ($arrive->is_master_user() or $arrive->is_dta_user()) {
                ?>
            <!-- <li class="nav-header">المستخدمين</li> -->
            <li class="nav-header">
                <!-- <a href="#"> المستخدمون
                    </a> -->
            </li>
            <li class="nav-item">
                <a href="user.php" class="nav-link <?php echo $user_active; ?>">
                    <i class="nav-icon far fa-user" style="font-size: 22px;"></i>
                    <p style="font-size: 16px; ">المستخدمون</p>
                </a>
            </li>

            <?php
                }
                ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>