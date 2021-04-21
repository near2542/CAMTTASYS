<?php

if(isset($_SESSION['error']))
{
  $error = $_SESSION['error'];
  unset($_SESSION['error']);
  echo "<script>alert('$error')</script>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="images/favicon.ico" type="image/ico" />
  <link href="../public/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../public/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../public/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../public/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  <!-- bootstrap-progressbar -->
  <link href="../public/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="../public/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
  <!-- bootstrap-daterangepicker -->
  <link href="../public/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../public/build/css/custom.min.css" rel="stylesheet">

</head>
<body>
  <div class="col-md-3 left_col">
    <div class="left_col scroll-view">
      <div class="navbar nav_title" style="border: 0;">
      <a href="../index.php" class="site_title"><img src="../public/images/logo.jfif" class="w-50 h-auto p-3" style="background-color:rgba(0,0,0,0);"/><span>TA CAMT</span></a>
      </div>

      <div class="clearfix"></div>

      <!-- menu profile quick info -->
      <div class="profile clearfix">
        <div class="profile_pic">
          <img src="<?= isset($img)? $img: '../public/images/logo.jfif' ?>" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
          <span>Welcome,</span>
          <h2>
          <?= $_SESSION['name'] ?>
          </h2>
        </div>
      </div>
      <!-- /menu profile quick info -->

      <br />

      <!-- sidebar menu -->
     
      
         
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="./request_courses.php">Request For Courses</a></li>
                      <li><a href="./request_TA.php">Request For TA</a></li>
                      <li><a href="./approve_ta.php">Approve TA</a></li>
                      <li><a href="./approved_ta.php">Approved TA List</a></li>
                    </ul>
                  </li>
              
              </div>


            </div>
    
              <!-- /sidebar menu -->

              <!-- /menu footer buttons -->
              <div class="sidebar-footer hidden-small">
              
                <a data-toggle="tooltip" data-placement="top" title="Logout" href="../logout.php">
                  <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                </a>
              </div>
              <!-- /menu footer buttons -->
    </div>
  </div>
  <!-- top navigation -->
  <div class="top_nav">
    <div class="nav_menu">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <nav class="nav navbar-nav">
        <ul class=" navbar-right">
          <li class="nav-item dropdown open" style="padding-left: 15px;">
            <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
              data-toggle="dropdown" aria-expanded="false">
              <?= $_SESSION['name'] ?>
            </a>
            <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
            
              <a class="dropdown-item" href="../logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
            </div>
          </li>

          <!-- <li role="presentation" class="nav-item dropdown open">
            <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-envelope-o"></i>
              <span class="badge bg-green">6</span>
            </a>
            <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
              <li class="nav-item">
                <a class="dropdown-item">
                  <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                  <span>
                    <span>John Smith</span>
                    <span class="time">3 mins ago</span>
                  </span>
                  <span class="message">
                    Film festivals used to be do-or-die moments for movie makers. They were where...
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="dropdown-item">
                  <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                  <span>
                    <span>John Smith</span>
                    <span class="time">3 mins ago</span>
                  </span>
                  <span class="message">
                    Film festivals used to be do-or-die moments for movie makers. They were where...
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="dropdown-item">
                  <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                  <span>
                    <span>John Smith</span>
                    <span class="time">3 mins ago</span>
                  </span>
                  <span class="message">
                    Film festivals used to be do-or-die moments for movie makers. They were where...
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="dropdown-item">
                  <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                  <span>
                    <span>John Smith</span>
                    <span class="time">3 mins ago</span>
                  </span>
                  <span class="message">
                    Film festivals used to be do-or-die moments for movie makers. They were where...
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <div class="text-center">
                  <a class="dropdown-item">
                    <strong>See All Alerts</strong>
                    <i class="fa fa-angle-right"></i>
                  </a>
                </div>
              </li>
            </ul>
          </li> -->
        </ul>
      </nav>
    </div>
  </div>
  <!-- /top navigation -->


  <!-- jQuery -->
  <script src="../public/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../public/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../public/vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="../public/vendors/nprogress/nprogress.js"></script>
  <!-- Chart.js -->
  <script src="../public/vendors/Chart.js/dist/Chart.min.js"></script>
  <!-- gauge.js -->
  <script src="../public/vendors/gauge.js/dist/gauge.min.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="../public/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="../public/vendors/iCheck/icheck.min.js"></script>
  <!-- Skycons -->
  <script src="../public/vendors/skycons/skycons.js"></script>
  <!-- Flot -->
  <script src="../public/vendors/Flot/jquery.flot.js"></script>
  <script src="../public/vendors/Flot/jquery.flot.pie.js"></script>
  <script src="../public/vendors/Flot/jquery.flot.time.js"></script>
  <script src="../public/vendors/Flot/jquery.flot.stack.js"></script>
  <script src="../public/vendors/Flot/jquery.flot.resize.js"></script>
  <!-- Flot plugins -->
  <script src="../public/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
  <script src="../public/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
  <script src="../public/vendors/flot.curvedlines/curvedLines.js"></script>
  <!-- DateJS -->
  <script src="../public/vendors/DateJS/build/date.js"></script>
  <!-- JQVMap -->
  <script src="../public/vendors/jqvmap/dist/jquery.vmap.js"></script>
  <script src="../public/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="../public/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="../public/vendors/moment/min/moment.min.js"></script>
  <script src="../public/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="../public/build/js/custom.min.js"></script>

</body>

</html>