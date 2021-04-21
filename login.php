<?php




if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
  header('location : ./index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>login</title>

  <!-- Bootstrap -->
  <link href="./public/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="./public/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="./public/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="./public/vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="./public/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>
    <?php if (isset($_GET['error'])) { ?>
      <script>
        alert('username หรือ password ไม่ถูกต้อง')
      </script>
    <?php } ?>
    <?php if (isset($_GET['register'])) {
      if ($_GET['register'] == 'pass') {
        echo " <script>alert('ลงทะเบียนสำเร็จ')</script>";
      }
      else {
        echo " <script>alert('ลงทะเบียนไม่สำเร็จ')</script>";
      }
    } ?>
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form action="./login_logic.php" method="POST">
            <h1>Login Form</h1>
            <div>
              <input type="text" class="form-control" placeholder="Username" required="" name="username" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" required="" name="password" />
            </div>
            <div>
              <button type="submit" class="btn btn-default" name="submit">Login</button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">New Account?
                <a href="#signup" class="to_register"> Create Account For TA </a>
              </p>

              <div class="clearfix"></div>
              <br />

            </div>
          </form>
        </section>
      </div>

      <div id="register" class="animate form registration_form">
        <section class="login_content">
          <form action="register.php" method="POST">
            <h1>Create Account For TA</h1>
            <div>
              <input type="text" required class="form-control" placeholder="Username" required="" name="username" />
            </div>
            <div>
              <input type="password" required class="form-control" placeholder="Password" required="" name="password" />
            </div>
            <div>
              <input type="text" required class="form-control" placeholder="ชื่อจริง" required="" name="Fname" />
            </div>
            <div>
              <input type="text" required class="form-control" placeholder="นามสกุล" required="" name="Lname" />
            </div>
            <div>
              <input type="text" required class="form-control" placeholder="รหัสนักศึกษา" pattern="\d*" required="" name="student_id" />
            </div>
            <div style="margin-bottom: 4%;">
              <select name="major" id="" class="form-control" style="border-radius: 3px;box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;border: 1px solid #c8c8c8; color: #777;">
                <option selected disabled hidden>เมเจอร์</option>
                <option value="MMIT">Modern Management and Information Technology</option>
                <option value="SE">Software Engineering</option>
                <option value="ANI">Animation and Visual Effects</option>
                <option value="DG">Digital Game</option>
                <option value="DII">Digital Industry Integration</option>
              </select>
            </div>
            <div style="margin-bottom: 4%;">
              <select name="user_type" id="" class="form-control" style="border-radius: 3px;box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;border: 1px solid #c8c8c8; color: #777;">
                <option selected disabled hidden>ระดับการศึกษา</option>
                <option value="3">กำลังศึกษา</option>
                <option value="4">สำเร็จการศึกษา</option>
              </select>
            </div>
            <div>
              <input type="email" required class="form-control" pattern="[a-z0-9._%+-]+@cmu.ac.th" placeholder="CMU e-mail" required="" name="cmu_email" />
            </div>
            <div>
              <input type="text" required class="form-control" placeholder="Line ID" required="" name="line" />
            </div>
            <div style="margin-bottom: 4%;">
              <input type="tel" required class="form-control" placeholder="เบอร์โทรศัพท์" pattern="\d{10}" required="" name="tel" />
            </div>
            <div>
              <input type="text" required class="form-control" placeholder="Facebook link" required="" name="facebook" />
            </div>
            <div>
              <input type="text" required class="form-control" placeholder="Portfolio link(Ex.Transcript / CV / Diploma)" required="" name="portfolio" />
            </div>

            <div>
              <button type="submit" class="btn btn-default" name="submit">Submit</button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">Already a member ?
                <a href="#signin" class="to_register"> Log in </a>
              </p>

              <div class="clearfix"></div>
              <br />
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</body>

</html>