<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">جاهز للانسحاب
                    ؟</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">حدد "تسجيل الخروج" أدناه إذا كنت مستعدًا لإنهاء جلستك الحالية.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">الغاء</button>
                <a class="btn btn-primary" href="logout.php">الخروج</a>
            </div>
        </div>
    </div>
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars fa_bar"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block" >
        <img src="images/logo_stathotel.png" class="img-fluid" width="10%"  alt="banner">
            <!-- <h2 class="nav-link" style="color: white;padding-top: 13px; font-style: italic; " >STATHOTEL</h2> -->
        </li>
        
    </ul>
      <!-- Right navbar links -->
    <ul class="navbar-nav mr-auto-navbav">
         <!-- ACOUNT USER NAV PROFILE -->
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img src="<?php echo $arrive->Get_profile_image(); ?>" class="img-responsive rounded-circle responsive" width="40" height="40" alt="User Image">
                <span class="mr-2 d-none d-lg-inline"><?php echo $arrive->Get_admin_name(); ?></span> 
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    البروفايل
                </a>
                <a class="dropdown-item" href="change_password.php">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    تغيرر كلمة المرور
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    الخروخ
                </a>
            </div>
        </li>

    </ul>
</nav>

