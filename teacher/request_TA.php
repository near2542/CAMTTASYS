<?php 
require_once('./check_teacher.php');

require_once('../db/connect.php');
$conn->init();
$courses = $conn->query("SELECT course_id,course_name,m.major_id,major_name 
from course c
INNER JOIN major m on c.major_id = m.major_id
where deleted !=1 ORDER BY course_id,major_id");

// $AssignedCourse = $conn->query("SELECT * FROM matching_course m
// INNER JOIN semester s on m.sem_id = s.sem_id
// INNER JOIN course c on m.course_id = c.course_id
// INNER JOIN day_work d on m.t_date = d.id
// LEFT JOIN ta_request t ON t.m_course_id = m.m_course_id
// WHERE user_id = {$_SESSION['id']} and m.deleted = 0
// ORDER BY s.sem_number,m.m_status");


$semester = $conn->query("SELECT * from semester");
$day = $conn->query("SELECT * from day_work");

// $courses = $conn->query("SELECT * FROM course c LEFT JOIN major m ON c.major_id = m.major_id where c.deleted != 1 ");


$SemesterOption = '';
$coursesOption = '';
$day_option = '';
while($row = mysqli_fetch_assoc($courses))
{
  $coursesOption .= sprintf('<option value="%d">%s</option>',
  $row['course_id'],
  "{$row['course_id']} {$row['course_name']}:{$row['major_name']}");
}

while($row = mysqli_fetch_assoc($semester))
{

  $SemesterOption .= sprintf('<option value="%d">%s</option>',
  $row['sem_id'],
  "ปี {$row['year']} เทอม {$row['sem_number']} ");
}

while($row = mysqli_fetch_assoc($day))
{
  $day_option .= sprintf('<option value="%d">%s</option>',
  $row['id'],
  "{$row['day']}");
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
        
        <?php require_once('teacher_header.php');?>
        <?php 
  // $queryMatchCourse = "SELECT * FROM matching_course m
  // INNER JOIN semester s on m.sem_id = s.sem_id
  // INNER JOIN course c on m.course_id = c.course_id
  // INNER JOIN day_work d on m.t_date = d.id
  // LEFT JOIN ta_request t ON t.m_course_id = m.m_course_id
  // WHERE user_id = '{$_SESSION['id']}' and m.deleted = 0
  // ORDER BY s.sem_number,m.m_ststus;
  // ";
  $QueryAssignedCourse = "SELECT m.m_course_id,m.sem_id,m.courseID,c.course_id,section,m.t_date,m.user_id,LANGUAGE AS language,hr_per_week,m.m_status,m.deleted,
  t_time,DAY AS day,sem_number,year,course_name,t.approved,request_id
FROM matching_course m
LEFT JOIN ta_request t ON t.m_course_id = m.m_course_id
INNER JOIN semester s on m.sem_id = s.sem_id
INNER JOIN course c on m.courseID = c.id
INNER JOIN day_work d on m.t_date = d.id
WHERE user_id = '{$_SESSION['id']}' and m.deleted = 0 
ORDER BY s.sem_number,m.m_status;";
  $MatchCourse = $conn->query($QueryAssignedCourse);
  
  ?>
       
        <!-- page content -->
        <div class="right_col" role="main" style="min-height:100vh">
            <div class="panel p-4 mt-5">
                <!-- <div><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Course</a></div> -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new courses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="./request/add_logic.php" method="POST">
      <div class="modal-body">
       
     <div class="form-floating mb-3">
     <label for="floatingInput">Semester: </label>
     <select class="form-control" name="sem_id" placeholder="Select The Major">
     <?= $SemesterOption ?>
            </select>
            </div>
            <div class="form-floating mb-3">
       <label for="floatingInput">Course Name</label>
       <select class="form-control" name="course_id" placeholder="Select The Major">
            <?= $coursesOption ?>
            </select>
     </div>

     <div class="form-floating mb-3">
      <label for="floatingInput">section</label>
        <input type="text" class="form-control" id="floatingInput" name="section" placeholder="Course ID">
    </div>

    <div class="form-floating mb-3">
       <label for="floatingInput">Date:</label>
       <select class="form-control" name="day_id" placeholder="Select The Major">
            <?= $day_option ?>
            </select>
     </div>

     <div class="form-floating mb-3">
      <label for="floatingInput">Work Time</label>
        <input type="text" class="form-control" id="floatingInput" name="WORK_TIME" placeholder="Work Time">
    </div>

    <div class="form-floating mb-3">
      <label for="floatingInput">Language</label>
      <select class="form-control" name="language" placeholder="Select Language">
            <option>TH</option>
            <option>ENG</option>
            </select>
    </div>

    <div class="form-floating mb-3">
      <label for="floatingInput">Hour Per Week</label>
        <input type="text" class="form-control" id="floatingInput" name="HOUR" placeholder="HOUR PER WEEK">
    </div>



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
            <th>Status</th>
            <th>Semester</th>
            <th>Year</th>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Section</th>
            <th>Work Date</th>
            <th>Work Time</th>
            <th>Language</th>
            <th>Hour Per Week</th>
            <th>Action</th>
          </tr>
        <?= mysqli_error($conn);?>  
          <?php while($data=mysqli_fetch_assoc($MatchCourse))
          { 
        ?>
        


        <!---------------- ---------------------------->
        
          <tr>
            <td><?=$data['m_status'] == 1 ? "open":"close"?></td>
            <td><?=$data['sem_number']?></td>
            <td><?=$data['year']?></td>
            <td><?=$data['course_id']?></td>
            <td><?=$data['course_name']?></td>
            <td><?=$data['section']?></td>
            <td><?=$data['day']?></td>
            <td><?=$data['t_time']?></td>
            <td><?=$data['language']?></td>
            <td><?=$data['hr_per_week']?></td>
            <!-- <td><?=$data['hr_per_week']?></td> -->
            <!-- <td><?=$data['hr_per_week']?></td> -->
            <td>
            
            <?php if($data['approved'] != 0) {?>
              <button class="btn btn-success" data-target="#edit<?=$data['m_course_id']?>" data-toggle="modal" disabled>
            Approved
            </button> 
            <?php } ?>
            <?php if ($data['approved'] == 0) {?>
            <button class="btn btn-success" data-target="#edit<?=$data['m_course_id']?>" data-toggle="modal" <?=$data['request_id']? "disabled" : null?>>
            <?=$data['request_id']? "Cancel Request": "Request"?>
            </button> 
            </td>
            <?php } ?>

            <!--  Edit -->
              <?php 
?>
            <div class="modal fade" id="edit<?=$data['m_course_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new courses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="./request_TA/add.php?id=<?=$data['m_course_id']?>" method="POST">
      <div class="modal-body">
       
     <div class="form-floating mb-3">
     <label for="floatingInput">Semester: </label>
     <select class="form-control" name="sem_id" placeholder="Select The Major" disabled>
     <?= $SemesterOption ?>
            </select>
            </div>
            <div class="form-floating mb-3">
       <label for="floatingInput">Course Name</label>
       <select class="form-control" name="course_id" placeholder="Select The Major" disabled>
            <option><?=$data['course_id']?></option>
            </select>
     </div>

     <div class="form-floating mb-3">
      <label for="floatingInput">section</label>
        <input type="text" class="form-control" id="floatingInput" name="section" placeholder="Section" value="<?=$data['section']?>" disabled>
    </div>

    <div class="form-floating mb-3">
       <label for="floatingInput">Date:</label>
       <select class="form-control" name="day_id" placeholder="Select The Major" disabled>
            <?= $day_option ?>
            </select>
     </div>

     <div class="form-floating mb-3">
      <label for="floatingInput">Work Time(HOURS)</label>
        <input type="text" class="form-control" id="floatingInput" name="WORK_TIME" value="<?=$data['t_time']?>" disabled placeholder="Work Time">
    </div>

    <div class="form-floating mb-3">
      <label for="floatingInput">Language</label>
      <select class="form-control" name="language" placeholder="Select Language" disabled>
            <option><?=$data['language']?></option>
            </select>
    </div>

    <div class="form-floating mb-3">
      <label for="floatingInput">Wanted Student Number</label>
        <input type="text" class="form-control" id="floatingInput" name="Student" placeholder="Student Number">
    </div>

    <div class="form-floating mb-3">
      <label for="floatingInput">Wanted External Number</label>
        <input type="text" class="form-control" id="floatingInput" name="Ex" placeholder="External Number">
    </div>

    <div class="form-group">
  <label for="comment">Request Note:</label>
  <textarea class="form-control" rows="5" id="comment" name="Request"></textarea>
</div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add" class="btn btn-primary">Request</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--  Edit -->

<!-- Delete -->

<div class="modal fade"  id="delete<?=$data['course_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete courses <?=$data['course_id']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="./course/delete_logic.php?old=<?=$data['course_id']?>" method="POST">
      <div class="modal-body">
            
            <h2>Are you sure deleteing <?=$data['course_id'] ?> <?=$data['course_name']?></h2>
      
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
  <?php }; $conn->close()?>
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