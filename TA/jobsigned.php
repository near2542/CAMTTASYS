<?php 
require_once('./check_ta.php');

require_once('../db/connect.php');
$conn->init();
$major = $conn->query("SELECT * from major");
$courses = $conn->query("SELECT * FROM course c LEFT JOIN major m ON c.major_id = m.major_id where c.deleted != 1 ");


$semesterQuery = $conn->query("SELECT * from semester");
$semesterOption = '<option value="all">all</option>';
while($row = mysqli_fetch_assoc($semesterQuery))
{
  $semesterOption .= "<option value='{$row['sem_id']}'>semester {$row['sem_number']} year {$row['year']}</option>";
}


$option = '';
while($row = mysqli_fetch_assoc($major))
{

  $option .= sprintf('<option value="%d">%s</option>',
  $conn->real_escape_string($row['major_id']),
  $conn->real_escape_string($row['major_name']));
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
        
        <?php require_once('TAheader.php');?>
        <?php 

$signedJob = $conn->query("SELECT *,m.m_course_id AS matching_id,ISNULL(r.m_course_id) AS matching_course_id
FROM ta_request t 
LEFT JOIN matching_course m ON t.m_course_id = m.m_course_id
LEFT JOIN course c ON c.course_id = m.course_id
LEFT JOIN user_tbl u ON u.user_id = m.user_id
LEFT JOIN major ma ON ma.major_id = c.major_id
LEFT JOIN semester s ON m.sem_id = s.sem_id
LEFT JOIN day_work d ON m.t_date = d.id
LEFT JOIN register r ON r.m_course_id = m.m_course_id AND (r.user_id = '{$_SESSION['id']}')
WHERE approved = 1 AND r_status = 2");
  
  ?>
       
        <!-- page content -->
        <div class="right_col" role="main" style="min-height:100vh">
            <div class="panel p-4 mt-5">
            <?php if(isset($_GET['year'])){
          $yearQuery = sprintf("SELECT * from semester where sem_id = '%d'",$_GET['year']);

            $year = mysqli_query($conn,$yearQuery);
          $yearShow = mysqli_fetch_row($year);

        }?>
         <div class="w-25" >
        <form action="./jobsigned.php" method="GET">
        <?php if(isset($_GET['year'])){
          $yearQuery = sprintf("SELECT * from semester where sem_id = '%d'",$_GET['year']);

            $year = mysqli_query($conn,$yearQuery);
          $yearShow = mysqli_fetch_row($year);

        }?>
        <label for="floatingInput"><h2>Search by Year: <?= isset($_GET['year']) && $_GET['year'] != 'all'? "Sem {$yearShow[1]} Year{$yearShow[2]}" : null?></h2>  </label>
     <select class="form-control" default="<?= $_GET['year']? $_GET['year'] : 'all'?>" name="year" placeholder="Select The Major">
     <?= $semesterOption ?>
            </select>
        <button type="type="submit"  class="d-inline btn btn-danger mt-1">Search</button>
        </form>
    </div>

        <div class="content mt-5">
        <table class="table table-striped">
          <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Section</th>
            <th>Major Name</th>
            <th>Year</th>
            <th>Semester</th>
            <th>Teacher Name</th>
            <th>Language</th>
            <th>Job Status</th>
        </tr>
        <?php while($data=mysqli_fetch_assoc($signedJob))
          {
        ?>

        <!---------------- ---------------------------->
          <tr>
            <td><?=$data['course_id']?></td>
            <td><?=$data['course_name']?></td>
            <td><?=$data['section']?></td>
            <td><?=$data['major_name']?> </td>
            <td><?=$data['year']?> </td>
            <td><?=$data['sem_number']?> </td>
            <td> <?= $data['f_name']?>  <?= $data['l_name']?></td>
            <td><?=$data['language']?> </td>
            <td>
            <?php if($data['r_status'] ==0 || $data['r_status'] == null):?>
            <button class="btn btn-success" data-target="#edit<?=$data['course_id']?>" data-toggle="modal">Sign</button>
            <?php elseif($data['r_status'] == 2) :?> 
            <button class="btn btn-success" disable data-target="#delete<?=$data['course_id']?>" disabled data-toggle="modal">Appoved</button>
            <?php endif; ?>
            </td>

            <!--  Edit -->
            <div class="modal fade" id="edit<?=$data['course_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update courses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="./course/update_logic.php?old=<?=$data['course_id']?>" method="POST">
      <div class="modal-body">
       
      <div class="form-floating mb-3">
      <label for="floatingInput">Course ID</label>
        <input type="text" class="form-control" id="floatingInput" value="<?=$data['course_id']?>"  name="course_id" placeholder="Course ID">
    </div>
     <div class="form-floating mb-3">
       <label for="floatingInput">Course Name</label>
         <input type="text" name="course_name" class="form-control" value="<?=$data['course_name']?>" id="floatingInput" placeholder="Course Name">


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