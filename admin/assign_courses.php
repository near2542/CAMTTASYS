<?php 
require_once('./check_admin.php');

require_once('../db/connect.php');
$conn->init();
$courses = $conn->query("SELECT id,course_id,course_name,m.major_id,major_name 
from course c
INNER JOIN major m on c.major_id = m.major_id
where deleted !=1 ORDER BY course_id,major_id");
$semester = $conn->query("SELECT * from semester");
$day = $conn->query("SELECT * from day_work");
$teacher = $conn->query("SELECT * from user_tbl where user_type = 2");
// $courses = $conn->query("SELECT * FROM course c LEFT JOIN major m ON c.major_id = m.major_id where c.deleted != 1 ");

$semesterHold = [];
$dayHold = [];
$teacherHold = [];
$coursesHold = [];

while($row = mysqli_fetch_assoc($courses))
{
  $courseHold[] = $row;
}

while($row = mysqli_fetch_assoc($semester))
{
  $semesterHold[] = $row;

}


while($row = mysqli_fetch_assoc($day))
{
  $dayHold[] = $row;
}

while($row = mysqli_fetch_assoc($teacher))
{
  $teacherHold[] = $row;
}

$SemesterOption = '';
$coursesOption = '';
$day_option = '';
$teacher_option = '';
foreach($courses as $row)
{
    $coursesOption .= sprintf('<option value="%d">%s</option>',
  $row['id'],
  "{$row['course_id']} {$row['course_name']}:{$row['major_name']}");
}
foreach($semesterHold as $row)
{

  $SemesterOption .= sprintf('<option value="%d">%s</option>',
  $row['sem_id'],
  "ปี {$row['year']} เทอม {$row['sem_number']} ");
}

foreach($dayHold as $row)
{
  $day_option .= sprintf('<option value="%d">%s</option>',
  $row['id'],
  "{$row['day']}");
}

foreach($teacherHold as $row)
{
  $teacher_option  .= sprintf('<option value="%d">%s</option>',
  $row['user_id'],
  "{$row['f_name']} {$row['l_name']}"
);
}

$semester = $conn->query("SELECT * from SEMESTER");
$day = $conn->query("SELECT * from day_work");
$teacher = $conn->query("SELECT * from user_tbl where user_type = 2");







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
        
        <?php require_once('admin_header.php');?>
        <?php 
  $queryMatchCourse = "SELECT * FROM matching_course m
  INNER JOIN semester s on m.sem_id = s.sem_id
  INNER JOIN course c on m.courseID = c.id
  INNER JOIN day_work d on m.t_date = d.id
  INNER JOIN user_tbl u on m.user_id = u.user_id
  INNER JOIN major ma on ma.major_id = c.major_id
  WHERE m.deleted = 0 and c.deleted = 0
  ORDER BY s.sem_number desc,m.m_status ;
  ";
  
  $MatchCourse = $conn->query($queryMatchCourse);
  
  ?>
       
        <!-- page content -->
        <div class="right_col" role="main" style="min-height:100vh">
            <div class="panel p-4 mt-5">
                <div><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Assign Course</a></div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="./assign/add_logic.php" method="POST">
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
       <label for="floatingInput">Lecturer: </label>
       <select class="form-control" name="teacher_id" placeholder="Select Teacher" >
           
            <?= $teacher_option ?>
            </select>
     </div>

     <div class="form-floating mb-3">
      <label for="floatingInput">section</label>
        <input type="text" class="form-control" id="floatingInput" name="section" placeholder="Section">
    </div>

    <div class="form-floating mb-3">
       <label for="floatingInput">Date:</label>
       <select class="form-control" name="day_id" placeholder="Select The Major">
            <?= $day_option ?>
            </select>
     </div>

     <div class="form-floating mb-3">
      <label for="floatingInput">Work Time</label>
        <input type="text" class="form-control" id="floatingInput" name="WORK_TIME" placeholder="Ex 08.00-09.00">
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
        <button type="submit" name="add" class="btn btn-primary">Assign Course</button>
      </div>
      </form>
    </div>
  </div>
</div>

        <div class="content mt-5">
  
        </select>
        <table class="table table-striped">
          <tr>
            <th>Status</th>
            <th>Semester</th>
            <th>Year</th>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Major</th>
            <th>Section</th>
            <th>Work Date</th>
            <th>Work Time</th>
            <th>Language</th>
            <th>Hour Per Week</th>
            <th>Action</th>
          </tr>
          
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
            <td><?=$data['major_name']?></td>
            <td><?=$data['section']?></td>
            <td><?=$data['day']?></td>
            <td><?=$data['t_time']?></td>
            <td><?=$data['language']?></td>
            <td><?=$data['hr_per_week']?></td>
            <td>
            <button class="btn btn-success" data-target="#edit<?=$data['m_course_id']?>" data-toggle="modal">Edit</button> 
            <button class="btn btn-danger" data-target="#delete<?=$data['m_course_id']?>" data-toggle="modal">Delete</button>
            </td>

            <!--  Edit -->
            <div class="modal fade" id="edit<?=$data['m_course_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new courses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="./assign/update_logic.php?id=<?=$data['m_course_id']?>" method="POST">
      <div class="modal-body">
       
     <div class="form-floating mb-3">
     <label for="floatingInput">Semester: </label>
     <select class="form-control" name="sem_id" placeholder="Select The Major">
     <?php
     foreach($semesterHold as $semesterFetch):?>
     
        <option value="<?= $semesterFetch['sem_id']?>" <?=$semesterFetch['sem_id'] == $data['sem_id']? "selected" : null?> >
            ปี <?= $semesterFetch['year']?> เทอม <?=$semesterFetch['sem_number']?>
        </option>
     <?php endforeach; ?>
       </select>
            </div>
            <div class="form-floating mb-3">
            
       <label for="floatingInput">Course Name</label>
       <select class="form-control" name="course_id" placeholder="Select The Major">
            <?php foreach($courseHold as $row):?>
              <option value="<?=$row['id'] ?>" <?=$row['id']==$data['courseID']? "selected" : null?>>
             <?=$row['id']?> <?=$data['id']?> <?=$row['course_id']?> <?=$row['course_name']?>:<?=$row['major_name']?>
              </option>
            <?php endforeach ?>
            </select>
     </div>

     <div class="form-floating mb-3">อ
       <label for="floatingInput">Lecturer: </label>
       <select class="form-control" name="teacher_id" placeholder="Select Teacher" >
              <?php foreach($teacherHold as $row):?>
              <option value="<?=$row['user_id']?>" <?=$row['user_id']==$data['user_id']? "selected" : null?>>
              <?=$row['f_name']?> <?=$row['l_name']?></option>
              <?php endforeach;?>
            </select>
     </div>

     <div class="form-floating mb-3">
      <label for="floatingInput">section</label>
        <input type="text" class="form-control" id="floatingInput" value="<?= $data['section']?>" name="section" placeholder="Section">
    </div>

    <div class="form-floating mb-3">
       <label for="floatingInput">Date:</label>
       <select class="form-control" name="day_id" placeholder="Select The Major">
      <?php foreach($dayHold as $row): ?>

        <option value="<?=$row['id']?>" <?=$row['id']==$data['id']? "selected" : null?> ><?=$row['day']?></option>
 

<?php endforeach; ?>
            </select>
     </div>

     <div class="form-floating mb-3">
      <label for="floatingInput">Work Time</label>
        <input type="text" class="form-control" id="floatingInput" value="<?=$data['t_time']?>" name="WORK_TIME" placeholder="Ex 08.00-09.00 or 09.00-11.00">
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
        <input type="text" class="form-control" id="floatingInput" name="HOUR" value="<?=$data['hr_per_week'] ?>" placeholder="HOUR PER WEEK">
    </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add" class="btn btn-primary">Edit Courses</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--  Edit -->

<!-- Delete -->

<div class="modal fade"  id="delete<?=$data['m_course_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete courses <?=$data['course_id']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="./assign/delete_logic.php?old=<?=$data['m_course_id']?>" method="POST">
      <div class="modal-body">
            
            <h2>Are you sure deleteing <?=$data['course_id'] ?> <?=$data['course_name']?> <?=$data['section']?></h2>
            <h2>By Teacher <?=$data['f_name'],$data['l_name']?>?</h2>
      
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