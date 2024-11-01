<?php
// session_start();
// error_reporting(0);

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



$results_per_page = 2;



$cselect = "SELECT co.*, ins.*, ca.*
          from courses co, instructors ins, categories ca
          where co.CategoryID=ca.CategoryID
          and co.InstructorID=ins.InstructorID          
          and co.Status=1
          ";
$cstmt = $conn->prepare($cselect);
$cstmt->execute();
$clist = $cstmt->fetchAll(PDO::FETCH_ASSOC); //mysqli_fetch_array
$crow = $cstmt->rowCount(); //mysqli_num_rows

// $number_of_pages = ceil($crow / $results_per_page);


//determine which page number visitor is currently on
// if (!isset($_GET['page'])) {
//   $page = 1;
// } else {
//   $page = $_GET['page'];
// }


//limit
// $this_page_first_result = ($page - 1) * $results_per_page;

// $cselect = "SELECT co.*, ins.*, ca.*
//           from courses co, instructors ins, categories ca
//           where co.CategoryID=ca.CategoryID
//           and co.InstructorID=ins.InstructorID          
//           and co.Status=1
//           LIMIT $this_page_first_result,  $results_per_page";
// $cstmt = $conn->prepare($cselect);
// $cstmt->execute();
// $clist = $cstmt->fetchAll(PDO::FETCH_ASSOC); //mysqli_fetch_array





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
      echo "<script>location='index.php'</script>";
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
        echo "<script>location='index.php'</script>";
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
  //     echo "<script>location='index.php'</script>";
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

  #row2 {
    align-items: stretch;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    overflow-y: auto;
    scrollbar-width: none;  /* Firefox */

    /* overflow-y: hidden; */
  }

  #row2::-webkit-scrollbar {
    display: none;
  }


  /* #child {
    align-items: stretch;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    overflow: auto;

    overflow-y: hidden;
  } */

  .btn-primary{
    background:linear-gradient(to right, #7c32ff 0%, #c738d8  ); border:none;

  }



  @media only screen and (max-width:1000px) {
    .container {
      overflow: hidden;
      padding-left: 30px;


    }


    #row2 {
      align-items: stretch;
      display: flex;
      flex-direction: row;
      flex-wrap: nowrap;
      overflow-x: auto;
      /* overflow-x:scroll; */
      overflow-y: hidden;
      scrollbar-width: none;  /* Firefox */
    }

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
      /* display: flex;
      flex-wrap: wrap;
      width: 80px; */
      /* padding: 10px; */
      text-align: center;
      background:linear-gradient(to right, #7c32ff 0%, #c738d8  ); border:none;


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
      /* background-image: url('img/home-banner-bg.png'); */
      max-height: 720px !important;

    }



    .home-banner-left {
      padding-top: 20px;
    }

    .popular-course-area {
      margin-top: -190px;
      /* background-color: red; */
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
</style>



<body>
  <!-- ================ start banner Area ================= -->
  <div class="homebg">
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
  </div>



  <section class="popular-course-area ">




    <div class="container-fluid" style="padding:5 rem">

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
      <?php



      // if ($searchtype == 2) {
      //   $cnamefetch = $stmt->fetch(PDO::FETCH_BOTH);

      //   $catname = $cnamefetch['CategoryName'];
      //   echo "<p style='text-align:center;'>Results for $catname</p>";
      // }


      ?>


      <br><br>
      <h2>Popular courses on Educally</h2> <br>

      <div class="row" id="row2">

        <!-- <div class="owl-carousel popuar-course-carusel" > -->
        <!-- <div class="single-popular-course"> -->

        <?php

        $cselect = "SELECT  ins.*, ca.*,p.*,co.*, COUNT(p.LearnerID) as lcount
                    from courses co, instructors ins, categories ca, purchase p
                    where co.CategoryID=ca.CategoryID
                    and co.InstructorID=ins.InstructorID    
                    and co.CourseID=p.CourseID      
                    and co.Status=1
                    Group by co.CourseTitle
                    order by lcount desc
                    limit 5";
        $cstmt = $conn->prepare($cselect);
        $cstmt->execute();
        $clist = $cstmt->fetchAll(PDO::FETCH_ASSOC); //mysqli_fetch_array
        $crow = $cstmt->rowCount();



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
                // $courseid = $value['CourseID'];

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
                  $pfetch = $pstmt->fetch(PDO::FETCH_BOTH);
                  // $plid = $pfetch['LearnerID'];
                  $pdate = $pfetch['PurchaseDate'];
                }


                if (!isset($_SESSION['learnerlogin']) || $LearnerID !== $plid) {

                ?>
                  <a href='CourseDetail.php?CDetailID=<?php echo $value['CourseID'] ?>' class='btn btn-primary'>Learn More</a>
                <?php
                } else {

                ?>
                  <a href='CourseDetail.php?CDetailID=<?php echo $value['CourseID'] ?>&&LID=<?php echo $LearnerID ?>' class='btn btn-primary' style="">Continue Course </a>

                <?php
                }
                ?>



              </div>
            </div>
          </div>
        <?php endforeach; ?>


      </div>


      <br><br>
      
      <?php
      if (isset($_SESSION['learnerlogin'])) {

        $caselect = "SELECT ca.* 
        from courses co, instructors ins, categories ca, purchase p
        where co.CategoryID=ca.CategoryID
        and co.InstructorID=ins.InstructorID    
        and co.CourseID=p.CourseID      
        and co.Status=1
        and p.LearnerID=$LearnerID
        Group by ca.CategoryName ";

        $cstmt = $conn->prepare($caselect);
        $cstmt->execute();
        $clist = $cstmt->fetchAll(PDO::FETCH_ASSOC); //mysqli_fetch_array
        $crow = $cstmt->rowCount();
       $crow;

        echo "<h2>Recommended courses for you</h2><br>";

        // for ($i = 0; $i < $crow; $i++) {
        foreach ($clist as $data) {
           $category = $data['CategoryName'];
           $catid=$data['CategoryID'];



      ?>
          <p style="color:black">Because you have joined  <a href="categories.php?cidtoview=<?php echo $catid ?>"><span style="font-weight: bold; color:#9533EC; font-size:x-large"><?php echo $category ?></span></a>  courses</p>
      <!-- <h3></h3><br> -->

          <div class="row" id="row2">

            <?php
            $coselect = "SELECT  ins.*, ca.*,p.*,co.* 
                        from courses co, instructors ins, categories ca, purchase p
                        where co.CategoryID=ca.CategoryID
                        and co.InstructorID=ins.InstructorID    
                        and co.CourseID=p.CourseID

                        and co.Status=1
                        and ca.CategoryID=$catid
                        Group by co.CourseID
                        limit 7";

            $cstmt = $conn->prepare($coselect);
            $cstmt->execute();
            $c2list = $cstmt->fetchAll(PDO::FETCH_ASSOC); //mysqli_fetch_array
            // $crow = $cstmt->rowCount();

            foreach ($c2list as $value) :
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
                    // $courseid = $value['CourseID'];

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
                      $pfetch = $pstmt->fetch(PDO::FETCH_BOTH);
                      // $plid = $pfetch['LearnerID'];
                      $pdate = $pfetch['PurchaseDate'];
                    }


                    if (!isset($_SESSION['learnerlogin']) || $LearnerID !== $plid) {

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
            <?php endforeach;
            ?>
            
          </div>
          <hr><hr>
      <?php
        }
      }
      ?>





    </div>

  </section>
  <!-- ================ End Popular Course Area ================= -->

  <!-- ================ Start Registration Area ================= -->

  <!-- ================ End Feature Area ================= -->

  <!-- ================ start footer Area ================= -->

  <!-- ================ End footer Area ================= -->


  <script src="js/owl.carousel.min.js"></script>

</body>

</html>