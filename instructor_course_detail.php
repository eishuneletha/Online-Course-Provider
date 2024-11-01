<?php

include('connect.php');
include('header_inst.php');

$CourseID = $_REQUEST['CID'];
$_SESSION['CourseID'] = $CourseID;
$iid = $_SESSION['IID'];

$cselect = "SELECT co.*, ins.*, ca.*
            from courses co, instructors ins, categories ca
            where co.CategoryID=ca.CategoryID
            and co.InstructorID=ins.InstructorID            
            and co.CourseID=$CourseID
            and ins.InstructorID=$iid
            ";
$cstmt = $conn->prepare($cselect);
$crun = $cstmt->execute();
$cfetch = $cstmt->fetch($crun);

$ctitle = $cfetch['CourseTitle'];
$cimg = $cfetch['ThumbnailPicture'];
$cdes = $cfetch['Description'];
$coutcomes = $cfetch['Outcomes'];
$ccat = $cfetch['CategoryName'];
$cins = $cfetch['InstructorName'];
$cprice = $cfetch['Price'];
$cslvl = $cfetch['SkillLevel'];
$cdate = $cfetch['PublishedDate'];

$lcount = "SELECT l.*
        from learners l, courses c, purchase p
        where l.LearnerID=p.LearnerID
        and c.CourseID=p.CourseID
        and c.CourseID=$CourseID
        ";
$lstmt = $conn->prepare($lcount);
$lrun = $lstmt->execute();
$totallearner = $lstmt->rowCount();

$rquery = "SELECT Round (AVG(r.Scale),1)
                   from ratingsandreviews r, courses c
                   where r.CourseID=c.CourseID
                   and c.CourseID=$CourseID";
$rstmt = $conn->prepare($rquery);
$rrun = $rstmt->execute();
$avg = $rstmt->fetchColumn();



?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Detail</title>
</head>
<style>
    .text-uppercase{
        background: linear-gradient(to right, #7c32ff 0%, #c738d8);
      border: none;
      color: white;
    }
</style>

<body>


    <!--================ Start Course Details Area =================-->
    <section class="section-gap container">

        <div class="row" style="width:100%; margin-left:0px">
            <div class="col-lg-8 course-details-left">
                <div class="main-image">
                    <img class="img-fluid" src="<?php echo $cimg ?>" alt="">
                </div>
                <div class="content-wrapper" style="padding-top:30px">
                    <h1 class="title"><?php echo $ctitle ?></h1>
                    <div class="content" style="padding-top:30px">
                        <?php echo $cdes ?>
                    </div>

                    <h2 class="title" style="padding-top:30px">Learning Outcomes</h2>
                    <div class="content" style="padding-top:30px">
                        <?php echo $coutcomes ?>
                    </div>

                    <h4 class="title" style="padding-top:30px; margin-bottom:30px">Sections</h4>
                    <a class="btn text-uppercase" style="padding:10px; background-color:#54BE29; color:white" href="section_upload.php?CID=<?php echo $CourseID ?>">+ Add Sections</a>
                    <div class="content" style="padding-top:30px">

                        <?php
                        $sselect = "SELECT s.*, c.*
                                        from sections s, courses c
                                        where s.CourseID=c.CourseID
                                        and c.CourseID=$CourseID";

                        $sstmt = $conn->prepare($sselect);
                        $sstmt->execute();
                        $slist = $sstmt->fetchAll(PDO::FETCH_ASSOC);


                        foreach ($slist as $value) :
                        ?>

                            <ul class="course-list">
                                <li class="justify-content-between d-flex" style="margin-bottom:15px;background-color:#F3E8F9;padding:15px">
                                    <p style="padding-top:5px; color:black"><?php echo $value['SectionTitle'] ?></p>
                                    <?php $sid = $value['SectionID'] ?>
                                    <a class="btn text-uppercase" style=" background: linear-gradient(to right, #7c32ff 0%, #c738d8);border: none; color:white" href="instructor_section_detail.php?SID=<?php echo $sid ?>">View Details</a>
                                </li>


                            </ul>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 right-contents">
                <ul>
                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Instructor's Name</p>
                            <span class="or"> <?php echo $cins ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Category </p>
                            <span><?php echo $ccat ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Course Fee </p>
                            <span>$ <?php echo $cprice ?></span>
                        </a>
                    </li>

                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Skill Level </p>
                            <span><?php echo $cslvl ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Students: </p>
                            <span><?php echo $totallearner ?></span>
                        </a>
                    </li>

                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Average Rating: </p>
                            <span><?php echo $avg ?>/5</span>
                        </a>
                    </li>
                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Published Date </p>
                            <span><?php echo $cdate ?></span>
                        </a>
                    </li>
                </ul>
                <a href="instructor_course_update.php?cidToUpdate=<?php echo $CourseID ?>" class="btn text-uppercase enroll">Update Course Detail</a>
                <a href="instructor_course_delete.php?cidToDelete=<?php echo $CourseID ?>" class="btn text-uppercase enroll">Delete Course</a>


                <br>
                <hr>

                <h3>Ratings and Reviews for this course</h3>


                <?php
                $rselect = "SELECT r.*, l.*
                                        from ratingsandreviews r, learners l
                                        where l.LearnerID=r.LearnerID
                                        and r.CourseID=$CourseID
                                    ";

                $rstmt = $conn->prepare($rselect);
                $rstmt->execute();
                $rlist = $rstmt->fetchAll(PDO::FETCH_ASSOC);



                foreach ($rlist as $value) :

                ?>
                    <div class="comments-area mb-30">

                        <div class="comment-list">

                            <div class="single-comment single-reviews justify-content-between d-flex">
                                <div class="user justify-content-between d-flex">

                                    <div class="thumb">
                                        <img style="width:40px; border-radius: 50%;  margin-top:-10px " src="<?php echo $value['ProfilePicture'] ?>" alt="">
                                    </div>
                                    <div class="desc" style="width:100% ; ">
                                        <h5><a href="#"><?php echo $value['LearnerName'] ?></a> </h5>

                                        <!-- <p> Rating: <?php echo $value['Scale'] ?> / 5 </p> -->

                                        <?php
                                    if ($value['Scale'] == 1) {
                                    ?>
                                        <div align="">
                                            <i class="fas fa-star " style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class="fas fa-star " style=" text-shadow: 0 0 2px #000; color:white"></i>
                                            <i class="fas fa-star " style=" text-shadow: 0 0 2px #000;color:white"></i>
                                            <i class="fas fa-star " style=" text-shadow: 0 0 2px #000;color:white"></i>
                                            <i class="fas fa-star " style=" text-shadow: 0 0 2px #000;color:white"></i>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if ($value['Scale'] == 2) {
                                    ?>
                                        <div align="">

                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000;color :#FFBD33"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000;color :#FFBD33"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:white"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:white"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:white"></i>
                                        </div>
                                    <?php
                                    }
                                    ?>


                                    <?php
                                    if ($value['Scale'] == 3) {
                                    ?>
                                        <div align="">
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class="fas fa-star=" 3" style=" text-shadow: 0 0 2px #000; color:white"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:white"></i>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if ($value['Scale'] == 4) {
                                    ?>
                                        <div align="">
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class=" fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:white"></i>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if ($value['Scale'] == 5) {
                                    ?>
                                        <div align="">
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class="fas fa-star fa" style=" text-shadow: 0 0 2px #000; color:#FFBD33"></i>
                                            <i class=" fas fa-star fa" style=" text-shadow: 0 0 2px #000;color:#FFBD33 "></i>
                                        </div>
                                    <?php
                                    }
                                    ?> <br>
                                        <p class="comment">
                                            <?php echo $value['Review'] ?>
                                        </p>
                                        <p><?php echo $value['RRDateTime'] ?></p>

                                    </div>


                                </div>
                            </div>
                            <hr>
                        </div>
                        </div>

                    <?php endforeach; ?>



                   

            </div>
        </div>
    </section>




</body>

</html>