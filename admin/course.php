<?php
require_once('./check_admin.php');

require_once('../db/connect.php');
$conn->init();
$major = $conn->query("SELECT * from major");
$option = '';
while ($row = mysqli_fetch_assoc($major)) {
  $option .= sprintf(
    '<option value="%d">%s</option>',
    $conn->real_escape_string($row['major_id']),
    $conn->real_escape_string($row['major_name'])
  );
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Course</title>

  <link rel="icon" href="../public/images/favicon.ico" type="image/ico" />
  <link href="../../public/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../../public/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../../public/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../../public/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  <!-- bootstrap-progressbar -->
  <link href="../../public/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="../../public/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
  <!-- bootstrap-daterangepicker -->
  <link href="../../public/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../../public/build/css/custom.min.css" rel="stylesheet">

  <!-- Bootstrap -->

</head>




<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php require_once('admin_header.php'); ?>
      <?php
      $filterQuery = '';
      if (isset($_GET['status']) and $_GET['status'] != 'all') {
        $courses = $conn->query("SELECT * FROM course c LEFT JOIN major m ON c.major_id = m.major_id where c.deleted = '$status'  order by c.deleted ");
      } else {
        $courses = $conn->query("SELECT * FROM course c LEFT JOIN major m ON c.major_id = m.major_id   order by c.deleted ");
      }
      ?>



      <!-- page content -->
      <div class="right_col" role="main" style="min-height:100vh">
        <div class="p-4 w-25">
          <form action="./course.php" method="GET">

            <label for="floatingInput">
              <h2>Search by Year:</h2>
            </label>
            <select class="form-control" default="<?= $_GET['status'] ? $_GET['status'] : 'all' ?>" name="year" placeholder="Select The Major">
              <option>All</option>
              <option value="0">Open Courses</option>
              <option value="1">Closed Courses</option>
            </select>
            <button type="submit" class="d-inline btn btn-danger mt-1">Search</button>
          </form>
        </div>
        <div class="panel p-4 ">
          <div><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Course</a></div>

          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add new courses</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="./course/add_logic.php" method="POST">
                  <div class="modal-body">

                    <div class="form-floating mb-3">
                      <label for="floatingInput">Course ID</label>
                      <input type="text" class="form-control" id="floatingInput" name="course_id" placeholder="Course ID">
                    </div>
                    <div class="form-floating mb-3">
                      <label for="floatingInput">Course Name</label>
                      <input type="text" name="course_name" class="form-control" id="floatingInput" placeholder="Course Name">


                    </div>
                    <label for="floatingInput">Major: </label>
                    <select class="form-control" name="major_id" placeholder="Select The Major">
                      <?= $option ?>
                    </select>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add" class="btn btn-primary">Add Courses</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="content mt-5">
            <table class="table table-striped">
              <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Major Name</th>
                <th>Action</th>
              </tr>

              <?php while ($data = mysqli_fetch_assoc($courses)) {
              ?>

                <!---------------- ---------------------------->
                <tr>
                  <td><?= $data['course_id'] ?></td>
                  <td><?= $data['course_name'] ?></td>
                  <td><?= $data['major_name'] ?></td>
                  <td>
                    <?php if ($data['deleted'] == 0) : ?>
                      <button class="btn btn-success" data-target="#edit<?= $data['course_id'] ?>" data-toggle="modal">Edit</button>
                      <button class="btn btn-danger" data-target="#delete<?= $data['course_id'] ?>" data-toggle="modal">Delete</button>
                    <?php elseif ($data['deleted'] == 1) : ?>
                      <button class="btn btn-danger" data-target="#retreive<?= $data['id'] ?>" data-toggle="modal">Retrieve Course</button>

                    <?php endif; ?>
                  </td>

                  <!--  Edit -->
                  <div class="modal fade" id="edit<?= $data['course_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Update courses</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="./course/update_logic.php?old=<?=$data['courseID'] ?>" method="POST">
                          <div class="modal-body">

                            <div class="form-floating mb-3">
                              <label for="floatingInput">Course ID</label>
                              <input type="text" class="form-control" id="floatingInput" value="<?= $data['course_id'] ?>" name="course_id" placeholder="Section">
                            </div>
                            <div class="form-floating mb-3">
                              <label for="floatingInput">Course Name</label>
                              <input type="text" name="course_name" class="form-control" value="<?= $data['course_name'] ?>" id="floatingInput" placeholder="Course Name">


                            </div>
                            <label for="floatingInput">Major: </label>
                            <select class="form-control" name="major_id" placeholder="Select The Major">
                              <?= $option ?>
                            </select>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!--  Edit -->
                      <!-- Retreive -->
                      <div class="modal fade" id="retreive<?= $data['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Retreive courses</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="./course/retreive_courses.php?old=<?= $data['id'] ?>" method="POST">
                          <div class="modal-body">

                            <div class="form-floating mb-3">
                              <label for="floatingInput">Course ID</label>
                              <input type="text" class="form-control" id="floatingInput" disabled value="<?= $data['course_id'] ?>" name="course_id" placeholder="Course ID">
                            </div>
                            <div class="form-floating mb-3">
                              <label for="floatingInput">Course Name</label>
                              <input type="text" name="course_name" class="form-control" disabled value="<?= $data['course_name'] ?>" id="floatingInput" placeholder="Course Name">


                            </div>
                            <label for="floatingInput">Major: </label>
                            <select class="form-control" disabled name="major_id" placeholder="Select The Major">
                              <?= $option ?>
                            </select>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="delete" class="btn btn-primary">Retrieve</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- Delete -->

                  <div class="modal fade" id="delete<?= $data['course_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Delete courses <?= $data['course_id'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="./course/delete_logic.php?old=<?= $data['courseID'] ?>" method="POST">
                          <div class="modal-body">

                            <h2>Are you sure deleteing <?= $data['course_id'] ?> <?= $data['course_name'] ?></h2>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>


                  <!-- Delete -->
                </tr>
                <!------------------ --------------------->
              <?php };
              $conn->close() ?>
            </table>
          </div>

        </div>
      </div>
      <!-- /page content -->


    </div>
  </div>


  <!---------------------- Add Course Modal---------------------->


</body>

</html>