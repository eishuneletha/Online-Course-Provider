<?php
// session_start();
error_reporting(0);

include('connect.php');
if (!isset($_SESSION)) {
  session_start();
} else {
  session_destroy();
  session_start();
}


if (isset($_SESSION['learnerlogin'])) {
  require_once('header.php');
  $LearnerID = $_SESSION['LID'];
} else {
  require_once('header_reg.php');
}



// include('header.php');
$CategoryID = $_REQUEST['cidtoview'];



$results_per_page = 8;



$cselect = "SELECT co.*, ins.*, ca.*
          from courses co, instructors ins, categories ca
          where co.CategoryID=ca.CategoryID
          and co.InstructorID=ins.InstructorID      
          and ca.CategoryID=:cid
          and co.Status=1
          ";
$cstmt = $conn->prepare($cselect);
$cstmt->bindParam(":cid", $CategoryID);
$crun = $cstmt->execute();
// $clist = $cstmt->fetchAll(PDO::FETCH_ASSOC); 
$clist = $cstmt->fetch($crun); //mysqli_fetch_array
$crow = $cstmt->rowCount(); //mysqli_num_rows

$number_of_pages = ceil($crow / $results_per_page);


//determine which page number visitor is currently on
if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}


//limit
$this_page_first_result = ($page - 1) * $results_per_page;

$cselect = "SELECT co.*, ins.*, ca.*
          from courses co, instructors ins, categories ca
          where co.CategoryID=ca.CategoryID
          and co.InstructorID=ins.InstructorID          
          and co.Status=1
          and ca.CategoryID=$CategoryID
          LIMIT $this_page_first_result,  $results_per_page";
$cstmt = $conn->prepare($cselect);
$cstmt->execute();
$clist = $cstmt->fetchAll(PDO::FETCH_ASSOC); //mysqli_fetch_array





if (isset($_REQUEST['btnsearch'])) {
  $searchtype = $_REQUEST['rdo'];

  if ($searchtype == 1) //search by course or level
  {
    $search = $_REQUEST['txtsearch'];
    $cselect = "SELECT co.*, ins.*, ca.*
            from courses co, instructors ins, categories ca
            where co.CategoryID=ca.CategoryID
            and co.InstructorID=ins.InstructorID          
            and (co.CourseTitle  like '%$search%'  
            or co.SkillLevel  like '%$search%')
            and co.Status=1";


    $cstmt = $conn->prepare($cselect);
    $cstmt->execute();

    $clist = $cstmt->fetchAll(PDO::FETCH_ASSOC);

    $crow = $cstmt->rowCount();

    if ($crow == 0) {
      echo "<script>window.alert('No courses found for $search')</script>";
      echo "<script>location='categories.php'</script>";
    }
  }

  if ($searchtype == 2) //search by category
  {
    $searchcat = $_REQUEST['selcat'];
    $cselect = "SELECT co.*, ins.*, ca.*
            from courses co, instructors ins, categories ca
            where co.CategoryID=ca.CategoryID
            and co.InstructorID=ins.InstructorID          
            and co.CategoryID='$searchcat'
            and co.Status=1";


    $cstmt = $conn->prepare($cselect);
    $cstmt->execute();
    $clist = $cstmt->fetchAll(PDO::FETCH_ASSOC);

    $crow = $cstmt->rowCount();

    if ($crow == 0) {
      if ($crow == 0) {
        echo "<script>window.alert('No results for $searchcat')</script>";
        echo "<script>location='categories.php'</script>";
      }
    }
  }

  // if ($searchtype == 3) //your purchase
  // {

  //   $cselect = "SELECT co.*, ins.*, ca.*,l.*, p.*
  //           from courses co, instructors ins, categories ca, learners l, purchase p
  //           where co.CategoryID=ca.CategoryID
  //           and co.InstructorID=ins.InstructorID  
  //           and co.CourseID=p.CourseID
  //           and p.LearnerID=l.LearnerID        
  //           and l.LearnerID=:learnerid
  //           and co.Status=1";


  //   $cstmt = $conn->prepare($cselect);
  //   $cstmt->bindParam(":learnerid", $LearnerID);
  //   $cstmt->execute();
  //   $clist = $cstmt->fetchAll(PDO::FETCH_ASSOC);
  //   $crow = $cstmt->rowCount();
  //   if ($crow == 0 || !isset($_SESSION['learnerlogin'])) {
  //     echo "<script>window.alert('You have not purchased any course yet')</script>";
  //     echo "<script>location='categories.php'</script>";
  //   }
  // }
}

?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InstructorCourses</title>
</head>

<style>
  .table {

    border-collapse: collapse;
    margin-top: -30px;



  }

  .table td {

    font-size: 12px;
    border: none;
    /* border: 1px solid; */
  }



  @media only screen and (max-width:1000px) {
    .container {
      overflow: hidden;
      padding-left: 30px;


    }


    /* .row {
      align-items: stretch;
      display: flex;
      flex-direction: row;
      flex-wrap: nowrap;
      overflow-x: auto;
      overflow-y: hidden;
    } */

    .search {
      margin-top: -90px;
    }

    .card {
      /* float: left; */
      max-width: 9rem;
      padding: .75rem;
      margin-bottom: 2rem;
      border: 0;
      flex-basis: 33.333%;
      flex-grow: 0;
      flex-shrink: 0;
      border-style: solid;
      border-width: 1px;

    }

    .card>img {
      margin-bottom: .75rem;
      width: 100%;
    }

    .card-text,
    .card-title {
      font-size: 70%;
    }

    .table {
      margin-top: 5px;
    }

    .table,
    .table tr,
    .table tbody,
    .table td {
      float: none;
      display: block;
      width: 100%;
    }

    .table td {
      text-align: center;
    }






    .btn-primary {
      font-size: 10px;
    }

    .sbyname {
      display: block;
    }

    .dropdown {

      max-width: 300px;
      font-size: 12px;
      float: left;
      left: 20%;
      right: 40%;
      margin: 0 0 auto;
      /* display: flex; */
      /* margin: 0 auto;
     position: absolute; */




    }

    .radio {
      width: 10px;
      height: 10px;
    }

    .form-control {
      height: 30px;
      font-size: 10px;
      max-width: 300px;
      margin: auto;
    }

    .homebg {
      background-image: url('img/home-banner-bg.png');
      max-height: 700px !important;
      background-size: cover;

      /* display: none; */
    }

    .home-banner-left {
      padding-top: 70px;
    }




  }


  .sbtn {
    margin-top: 0px;
    text-align: center;
    font-size: 10px;



  }


  .sbar {
    background-color: #9533EC;
    border: none;
    color: white;
    padding: 10px;
    width: 45px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 15px;
    border-radius: 30px;
    cursor: pointer;

  }

  .homebg {
    background-image: url('img/home-banner-bg.png');
    height: 900px;
    ;
    background-size: cover;
  }
  .btn-primary{
    background:linear-gradient(to right, #7c32ff 0%, #c738d8  ); border:none;

  }

</style>



<body>
  <!-- ================ start banner Area ================= -->
  <!-- <div class="homebg">
    <div class="container">
      <div class="row justify-content-center fullscreen align-items-center">
        <div class="col-lg-5 col-md-8 home-banner-left">
          <h1 class="text-white">
            Take the first step <br />
            to learn with us
          </h1>
          <p class="mx-auto text-white  mt-20 mb-40">
            In the history of modern astronomy, there is probably no one
            greater leap forward than the building and launch of the space
            telescope known as the Hubble.
          </p>
        </div>
        <div class="offset-lg-2 col-lg-5 col-md-12 home-banner-right">
          <img class="img-fluid" src="img/header-img.png" alt="" />
        </div>
      </div>
    </div>
  </div> -->



  <section class="popular-course-area section-gap">



    <div class="container" style="padding:5 rem">

      <form action="" method="post">
        <table class="table" align="center">
          <tbody>
            <tr>

              <td><input type="radio" name="rdo" class="radio" value="2" style="margin-top:12px"> Course Category</td>
              <td style="padding-bottom: 50px; ">
                <select class="dropdown" name="selcat">
                  <?php
                  $caselect = "SELECT * from categories";
                  $castmt = $conn->prepare($caselect);
                  $castmt->execute();

                  $cacount = $castmt->rowCount();

                  for ($i = 0; $i < $cacount; $i++) {
                    $cafetch = $castmt->fetch(PDO::FETCH_BOTH);
                    $caid = $cafetch['CategoryID'];
                    $caname = $cafetch['CategoryName'];

                    echo "<option value='$caid'>$caname</option>";
                  }


                  ?>
                </select>
              </td>



              <td><input type="radio" name="rdo" value="1" style="margin-top:12px"> Search by Course or Level</td>
              <td><input class="form-control" type="text" placeholder="search here" name="txtsearch"></td>


              <!-- <td><input type="radio" name="rdo" value="3" style="margin-top:12px"> Your Purchases</td> -->




              <td class="sbtn"><button class="sbar" name="btnsearch"><i class="fas fa-search"></i></button></td>
            </tr>
          </tbody>

        </table>
      </form>
     

      <div class="row">


        <?php
        foreach ($clist as $value) :
          $cid = $value['CourseID'];

          $lcount = "SELECT l.*
           from learners l, courses c, purchase p
           where l.LearnerID=p.LearnerID
           and c.CourseID=p.CourseID
           and  c.CourseID=$cid
           ";
          $lstmt = $conn->prepare($lcount);
          $lrun = $lstmt->execute();
          $totallearner = $lstmt->rowCount();

          $rquery = "SELECT Round (AVG(r.Scale),1)
                   from ratingsandreviews r, courses c
                   where r.CourseID=c.CourseID
                   and c.CourseID=$cid";
          $rstmt = $conn->prepare($rquery);
          $rrun = $rstmt->execute();
          $avg = $rstmt->fetchColumn();



        ?>


          <div class="" style="padding:10px;">

            <div class="card" style="width: 15rem ">
              <img class="card-img-top" style="max-height:180px" src="<?php echo $value['ThumbnailPicture']; ?>">
              <div class="card-body">
                <h4 class="card-title"><?php echo $value['CourseTitle'] ?></h4>
                <h6 class="card-title">Category: <?php echo $value['CategoryName'] ?></h6>
                <p class="card-title"><?php echo $value['InstructorName'] ?></p>

                <h5 class="card-title">Price: $<?php echo $value['Price'] ?></h5></br>
                <h6 class="card-title">Students: <?php echo $totallearner ?></h6>
                <h6 class="card-title">Average Rating: <?php echo $avg ?>/5</h6>
                <?php
                if (isset($_SESSION['learnerlogin'])) {
                  $pdata = "SELECT * from purchase where CourseID=$cid and LearnerID=$LearnerID";
                  $pstmt = $conn->prepare($pdata);
                  $pstmt->execute();
                  $pfetch = $pstmt->fetch();
                  $plid = $pfetch['LearnerID'];
                  $pdate = $pfetch['PurchaseDate'];
                } else {
                  $pdata = "SELECT * from purchase where CourseID=$cid";
                  $pstmt = $conn->prepare($pdata);
                  $pstmt->execute();
                  $pfetch = $pstmt->fetch();
                  $plid = $pfetch['LearnerID'];
                  $pdate = $pfetch['PurchaseDate'];
                }


              

                

                if ($LearnerID !== $plid || !isset($_SESSION['learnerlogin'])) {
                ?>
                  <a href='CourseDetail.php?CDetailID=<?php echo $value['CourseID'] ?>' class='btn btn-primary'>Learn More</a>
                <?php
                } else {

                ?>
                  <a href='CourseDetail.php?CDetailID=<?php echo $value['CourseID'] ?>' class='btn btn-primary'>Continue Course</a>

                <?php
                }
                ?>



              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- </div> -->





    </div>

  </section>
  <!-- ================ End Popular Course Area ================= -->

  <!-- ================ Start Registration Area ================= -->

  <!-- ================ End Feature Area ================= -->

  <!-- ================ start footer Area ================= -->

  <!-- ================ End footer Area ================= -->


  <nav class="blog-pagination justify-content-center d-flex">
    <ul class="pagination">
      <?php

      $prevPage = $page - 1;



      if ($prevPage < $number_of_pages && $prevPage !== 0) {
      ?>
        <li class="page-item">
          <a href="categories.php?cidtoview=<?php echo $CategoryID ?>&page=<?php echo $prevPage ?>" class=" page-link" aria-label="Previous">
            <span aria-hidden="true">
              <span class="lnr lnr-chevron-left"></span>
            </span>
          </a>
        </li>
      <?php
      } else if ($prevPage == 0) {
      ?>
        <li class="page-item">
          <a href="categories.php?cidtoview=<?php echo $CategoryID ?>&page=<?php echo $number_of_pages ?>" class=" page-link" aria-label="Previous">
            <span aria-hidden="true">
              <span class="lnr lnr-chevron-left"></span>
            </span>
          </a>
        </li>
      <?php
      } else {
      ?>
        <li class="page-item">
          <a href="categories.php" class="page-link" aria-label="Previous">
            <span aria-hidden="true">
              <span class="lnr lnr-chevron-left"></span>
            </span>
          </a>
        </li>
      <?php
      }
      ?>





      <!-- <li class="page-item"><a href="#" class="page-link">01</a></li>
      <li class="page-item active"><a href="#" class="page-link">02</a></li>
      <li class="page-item"><a href="#" class="page-link">03</a></li>
      <li class="page-item"><a href="#" class="page-link">04</a></li>
      <li class="page-item"><a href="#" class="page-link">09</a></li> -->

      <?php
      //display links to the page
      for ($i = 1; $i <= $number_of_pages; $i++) {

        if ($i == $page) {
      ?>
          <li class="page-item active"><a href="categories.php?cidtoview=<?php echo $CategoryID ?> &page=<?php echo $i ?>" class="page-link"><?php echo $i ?> </a></li>
        <?php
        } else {
        ?>
          <li class="page-item"><a href="categories.php?cidtoview=<?php echo $CategoryID ?>&page=<?php echo $i ?>" class="page-link"><?php echo $i ?> </a></li>
      <?php

        }
      }
      ?>
      <!-- <td><a class="text-danger" onClick="return confirm('Are you sure you want to clear this record?')" href="clear_records.php?id=<?php echo $rows4['id']; ?>&p_id=<?php echo $rows5['p_id']; ?>"><i class="fa fa-times text-danger"></i>Clear</a></td> -->

      <?php
      $nextPage = $page + 1;



      if ($nextPage > $number_of_pages) {
      ?>

        <li class="page-item">
          <a href="categories.php?cidtoview=<?php echo $CategoryID ?>" class=" page-link" aria-label="Next">
            <span aria-hidden="true">
              <span class="lnr lnr-chevron-right"></span>
            </span>
          </a>
        </li>

      <?php
      } else {
      ?>
        <li class="page-item">
          <a href="categories.php?cidtoview=<?php echo $CategoryID ?>&page=<?php echo $nextPage ?>" class=" page-link" aria-label="Next">
            <span aria-hidden="true">
              <span class="lnr lnr-chevron-right"></span>
            </span>
          </a>
        </li>
      <?php
      }
      ?>
      <!-- <li class="page-item">
        <a href="#" class="page-link" aria-label="Next">
          <span aria-hidden="true">
            <span class="lnr lnr-chevron-right"></span>
          </span>
        </a>
      </li> -->
    </ul>
  </nav>

</body>

</html>