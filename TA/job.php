<?php 
require_once('./check_ta.php');
require_once('../db/connect.php');
$conn->init();
$major = $conn->query("SELECT * from major");
$courses = $conn->query("SELECT * FROM course c LEFT JOIN major m ON c.major_id = m.major_id where c.deleted != 1 order by r_status desc");


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
        
        <?php require_once('TAheader.php');
        $filterQuery = '';
        if(isset($_GET['year']) && $_GET['year'] != 'all')
        {
          $year = $_GET['year'];
            $filterQuery = "SELECT *,m.m_course_id AS matching_id,ISNULL(r.m_course_id) AS matching_course_id
            FROM ta_request t 
				LEFT JOIN matching_course m ON t.m_course_id = m.m_course_id
            LEFT JOIN course c ON c.id = m.courseID
            LEFT JOIN user_tbl u ON u.user_id = m.user_id
            LEFT JOIN major ma ON ma.major_id = c.major_id
            LEFT JOIN semester s ON m.sem_id = s.sem_id
            LEFT JOIN day_work d ON m.t_date = d.id
            LEFT JOIN register r ON r.m_course_id = m.m_course_id AND (r.user_id = '{$_SESSION['id']}')
            WHERE approved = 1 and s.sem_id = {$year}";
        }
        else{
            $filterQuery= "SELECT *,m.m_course_id AS matching_id,ISNULL(r.m_course_id) AS matching_course_id
            FROM ta_request t 
				LEFT JOIN matching_course m ON t.m_course_id = m.m_course_id
            LEFT JOIN course c ON c.id = m.courseID
            LEFT JOIN user_tbl u ON u.user_id = m.user_id
            LEFT JOIN major ma ON ma.major_id = c.major_id
            LEFT JOIN semester s ON m.sem_id = s.sem_id
            LEFT JOIN day_work d ON m.t_date = d.id
            LEFT JOIN register r ON r.m_course_id = m.m_course_id AND (r.user_id = '{$_SESSION['id']}')
            WHERE approved = 1 
         ";
        }
        $openJob = $conn->query($filterQuery);
        if(mysqli_error($conn)) die(mysqli_error($conn))
        
        ?>
        
     

       
        <!-- page content -->
        <div class="right_col" role="main" style="min-height:100vh">
         <h1>
             Sign Course
         </h1>
      <div class="w-25" >
        <form action="./job.php" method="GET">
        <?php if(isset($_GET['year'])){
          $yearQuery = sprintf("SELECT * from semester where sem_id = '%d'",$_GET['year']);

            $year = mysqli_query($conn,$yearQuery);
          $yearShow = mysqli_fetch_row($year);

        }?>
        <?= mysqli_error($conn);?>
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
            <th>Apply For A Job</th>
        </tr>
    
        <?php while($data=mysqli_fetch_assoc($openJob))
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
            <?php if( $data['r_status'] == 0 || $data['r_status'] == null):?>
            <button class="btn btn-success" data-target="#edit<?=$data['request_id']?>" data-toggle="modal">
            Sign
                
            </button>
            <?php elseif ($data['r_status'] == 1 ) : ?> 
                <button class="btn btn-danger"  data-toggle="modal">
                    <a class="text-white" href="./job/unsigned.php?id=<?=$data['register_id']?>">Cancel Apply</a>
            </button>
                <?php elseif ($data['r_status'] ==2 ) : ?> 
                <button class="btn btn-success" data-target="#delete<?=$data['time_stamp']?>" disabled data-toggle="modal">Approved</button>
                  <?php elseif ($data['r_status'] ==3 ): ?>
                <button class="btn btn-danger" disabled >Rejected</button>
         
                <?php endif; ?>

            </td>

            <!--  Edit -->
            <div class="modal fade" id="edit<?=$data['request_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update courses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
       
      <h6>Enroll Course: <?=$data['course_id']?></h6> 
      <h6>Section: <?=$data['section']?></h6>
      <h6>Teacher: <?=$data['f_name'],$data['l_name']?></h6>
      <h6>Year <?=$data['year']?>,<?=$data['sem_number']?></h6> 
      <h6>Work Time: <?=$data['t_time'] ?> ON <?=$data['day'] ?></h6>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="update" class="btn btn-primary">
            <a class="text-white" href="./job/sign.php?id=<?= $_SESSION['id']?>&m_course_id=<?=$data['matching_id']?>&register_id=<?=$data['register_id']?>">
            Sign</a> 
    </button>
      </div>
      
    </div>
  </div>
</div>
<!--  Edit -->

<!-- Delete -->

<div class="modal fade" id="unsigned<?=$data['timestamp']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update courses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
       
      <h6>Enroll Course: <?=$data['course_id']?></h6> 
      <h6>Teacher: <?=$data['f_name'],$data['l_name']?></h6>
      <h6>Year <?=$data['year']?>,<?=$data['sem_number']?></h6> 
      <h6>Work Time: <?=$data['t_time'] ?> ON <?=$data['day'] ?></h6>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="update" class="btn btn-primary"><a class="text-white" href="./job/sign.php?id=<?=$data['matching_id']?>">Sign</a> 
    </button>
      </div>
      
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