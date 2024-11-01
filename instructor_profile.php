<?php
error_reporting(0);

include('header_inst.php');

$InstructorID = $_SESSION['IID'];


$iselect = "SELECT * from instructors          
            where InstructorID=$InstructorID
           
            ";
$istmt = $conn->prepare($iselect);
$irun = $istmt->execute();
$ifetch = $istmt->fetch($irun);

$iname = $ifetch['InstructorName'];
$iemail = $ifetch['Email'];
$pp = $ifetch['ProfilePicture'];
$about = $ifetch['About'];
$is = $ifetch['InstructorSince'];
$icat = $ifetch['Interestedcategories'];


$lcount = "SELECT l.*
        from learners l, courses c, instructors i, purchase p
        where l.LearnerID=p.LearnerID
        and p.CourseID=c.CourseID
        and i.InstructorID=c.InstructorID
        and i.InstructorID=$InstructorID";
$lstmt = $conn->prepare($lcount);
$lrun = $lstmt->execute();
$totallearner = $lstmt->rowCount();

$rcount = "SELECT r.*
        from ratingsandreviews r, courses c, instructors i
        where r.CourseID=c.CourseID
        and c.InstructorID=i.InstructorID
        and i.InstructorID=c.InstructorID
        and i.InstructorID=$InstructorID";

$rstmt = $conn->prepare($rcount);
$rrun = $rstmt->execute();
$totalreview = $rstmt->rowCount();


$cselect = "SELECT co.*, ins.*, ca.*
          from courses co, instructors ins, categories ca
          where co.CategoryID=ca.CategoryID
          and co.InstructorID=ins.InstructorID
          and ins.InstructorID=$InstructorID
          and co.Status=1";
$cstmt = $conn->prepare($cselect);
$cstmt->execute();
$clist = $cstmt->fetchAll(PDO::FETCH_ASSOC);
$crow = $cstmt->rowCount();





?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<body>


    <!--================ Start Course Details Area =================-->
    <section class="section-gap container">

        <div class="row" style="width:100%; margin-left:0px">
            <div class="col-lg-4 course-details-left">
                <div class="main-image">
                    <img class="img-fluid" src="<?php echo $pp ?>" alt="">
                </div>

                <div>
                <a style="margin-top:15px; background-color: #9E33EC; color:white "href="Instructor_profile_update.php?iIdToUpdate=<?php echo $InstructorID ?>" class="btn text-uppercase enroll">Update Profile</a>
                </div>

            </div>

            <div class="col-lg-8 right-contents">

                <h1 class="title"><?php echo $iname ?></h1>
                <p style="padding-top:15px">Total Learners</p>
                <h2 class="title"> <?php echo $totallearner ?></h2>
                <p style="padding-top:15px"> Total reviews</p>
                <h2 class="title"><?php echo $totalreview ?></h2>

                <br><br>
                <h3 class="title">Instructor on Educally since:</h3>
                <p style="padding-top:15px"><?php echo $is ?></p>

                <br><br>
                <h3 class="title">Interested in</h3>
                <p style="padding-top:15px"><?php echo $icat ?></p>

                <br><br>
                <h3 class="title">About the instructor</h3>
                <p style="padding-top:15px"><?php echo $about ?></p>


                <div class="row justify-content-center section-title">
                    <div class="col-lg-12">
                        <h2>
                            Instructor's courses
                        </h2>

                    </div>
                </div>
                <!-- <section class="popular-course-area section-gap"> -->

                <div class="row gy-5">
          <?php foreach ($clist as $value) : ?>

            <div class="" style="padding:10px;">
              <div class="card" style="width: 20rem ">
                <img class="card-img-top" style="max-height:180px" src="<?php echo $value['ThumbnailPicture']; ?>">
                <div class="card-body">                 
                      <h2 class="card-title"><?php echo $value['CourseTitle'] ?></h2>
                      <h5 class="card-title">Category: <?php echo $value['CategoryName']?></h5></br>
                      <h5 class="card-title">Price: $<?php echo $value['Price']?></h5></br>
                      <h6 class="card-title">Skill level: <?php echo $value['SkillLevel']?></h5></br>
                      <h6 class="card-title">Language Used: <?php echo $value['LanguageUsed']?></h5></br>
                      <?php  $cid=$value['CourseID'];?>
                      
                 
                 
                  <p class="card-text" style="overflow:hidden;
                                              line-height: 2rem;
                                              max-height: 8rem;
                                              -webkit-box-orient: vertical;
                                              display: block;
                                              display: -webkit-box;
                                              overflow: hidden !important;
                                              text-overflow: ellipsis;
                                              -webkit-line-clamp: 4;
                                              color:black"><?php echo $value['Description']?></p>
                  <a href="instructor_course_detail.php?CID=<?php echo $cid ?>" class="btn btn-primary">Edit/Manage</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

                        <!-- </div> -->





                    </div>

                </section>



    </section>