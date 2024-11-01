<?php
// session_start();
error_reporting(0);
include('connect.php');
include('header_inst.php');

$instructorid = $_SESSION['IID'];

$cselect = "SELECT co.*, ins.*, ca.*
          from courses co, instructors ins, categories ca
          where co.CategoryID=ca.CategoryID
          and co.InstructorID=ins.InstructorID
          and ins.InstructorID=$instructorid
          and co.Status=1";
$cstmt = $conn->prepare($cselect);
$cstmt->execute();
$clist = $cstmt->fetchAll(PDO::FETCH_ASSOC);
$crow = $cstmt->rowCount();
$CourseID = $clist['CourseID'];




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
  .card {
    /* float: left; */
    max-width: 15rem;
    padding: .9rem;
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

    .card-title {
      font-size: 20px;
      padding-bottom: 10px;
    }


    .card-text
    {
      font-size:12px;
    }

    .btn-primary {
      
      background: linear-gradient(to right, #7c32ff 0%, #c738d8);
      border: none;
    }
   
  @media only screen and (max-width:1000px) {
    .card {
      /* float: left; */
      max-width: 9rem;
      padding: 0srem;
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

    .card-text{
      font-size: 60%;
      padding-bottom: 0%;
    }
    .card-title {
      font-size: 100%;
    }

    .btn-primary {
      font-size: 10px;
      background: linear-gradient(to right, #7c32ff 0%, #c738d8);
      border: none;
    }
  }
</style>

<body>

  <section class="popular-course-area section-gap">
    <div class="container-fluid">
      <div class="row justify-content-center section-title">
        <div class="col-lg-12">
          <h2>
            Your courses
          </h2>
          <p>
            The following are the courses you have uploaded.
          </p>
        </div>
      </div>

      <div class="container overflow-hidden">
        <div class="row gy-5">
          <?php foreach ($clist as $value) :
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
              <div class="card" style="width: 20rem ">
                <img class="card-img-top" style="max-height:180px" src="<?php echo $value['ThumbnailPicture']; ?>">
                <div class="card-body">
                  <h1 class="card-title"><?php echo $value['CourseTitle'] ?></h1>
                  <!-- <h2 class="card-title"><?php echo $cid ?></h2> -->
                  <h5 class="card-text">Category: <?php echo $value['CategoryName'] ?></h5></br>
                  <h5 class="card-text">Price: $<?php echo $value['Price'] ?></h5></br>
                  <h6 class="card-text">Skill level: <?php echo $value['SkillLevel'] ?></h5></br>
                    <h6 class="card-text">Language Used: <?php echo $value['LanguageUsed'] ?></h5></br>
                      <h6 class="card-text">Students: <?php echo $totallearner ?></h5></br>
                        <h6 class="card-text">Rating: <?php echo $avg ?> /5</h5></br>



                          <p class="card-text" style="overflow:hidden;
                                              line-height: 2rem;
                                              max-height: 8rem;
                                              -webkit-box-orient: vertical;
                                              display: block;
                                              display: -webkit-box;
                                              overflow: hidden !important;
                                              text-overflow: ellipsis;
                                              -webkit-line-clamp: 4;
                                              color:black"><?php echo $value['Description'] ?></p>
                          <a href="instructor_course_detail.php?CID=<?php echo $cid ?>" class="btn btn-primary">Edit/Manage</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>






    </div>
    </div>
  </section>
  <!-- ================ End Popular Course Area ================= -->

  <!-- ================ Start Registration Area ================= -->

  <!-- ================ End Registration Area ================= -->

  <!-- ================ Start Feature Area ================= -->

  <!-- ================ End Feature Area ================= -->

  <!-- ================ start footer Area ================= -->


</body>

</html>