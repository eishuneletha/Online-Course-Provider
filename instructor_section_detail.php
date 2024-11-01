<?php
// session_start();
include('connect.php');
include('header_inst.php');

$CourseID = $_SESSION['CourseID'];

$SectionID = $_REQUEST['SID'];
$_SESSION['SectionID'] = $SectionID;

$iid = $_SESSION['IID'];

$sselect = "SELECT co.*, ins.*, s.*
            from courses co, instructors ins, sections s
            where co.CourseID=s.CourseID
            and co.InstructorID=ins.InstructorID            
            and s.SectionID=$SectionID
            and co.CourseID=$CourseID
            and ins.InstructorID=$iid
            ";
$sstmt = $conn->prepare($sselect);
$srun = $sstmt->execute();
$sfetch = $sstmt->fetch($srun);

$stitle = $sfetch['SectionTitle'];
$sdes = $sfetch['SectionDescription'];
$smaterial = $sfetch['SectionMaterial'];

// $smaterial = !empty($sfetch['SectionMaterial']) ? $sfetch['SectionMaterial'] : "No File Found";

$cname = $sfetch['CourseTitle'];




?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Section Detail</title>
</head>


<body>


    <!--================ Start Course Details Area =================-->
    <section class="section-gap container">


        <div class="col-lg-12 course-details-left">
            <div class="content-wrapper">
                <h1 class="title"><?php echo $cname; ?></h1>
                <h2 class="title" style="margin-top:30px"><?php echo $stitle ?></h1>
                    <h3 style="margin-top:30px"> Description
                </h2>

                <div class="content" style="padding-top:30px; color:black">
                    <?php echo $sdes ?>
                </div>
                <br><br>

                <a class="btn text-uppercase" style="color:white; background-color:#9440FF" href="instructor_section_update.php?sIdToUpdate=<?php echo $SectionID ?>">Edit Section</a>
                <div class="content" style="padding-top:30px; color:black">

                    <?php
                    if ($smaterial == NULL) {
                        echo "<p> Material file : No material file to show</p>";
                    } else {

                    ?>
                        Material File: <?php echo $smaterial ?> | <a href="filedownload.php?file=<?php echo $smaterial ?>">Download</a>

                    <?php

                    }

                    ?> 


                   



                </div>


            </div>
        </div>

        <h4 class="title" style="padding-top:30px; margin-bottom:30px; margin-left:10px">Lessons in this section</h4>
        <a class="btn text-uppercase" style="margin-left:10px;padding:10px; background-color:#54BE29; color:white" href="lesson_upload.php?SID=<?php echo $SectionID ?>">+ Add Lessons</a>
        <div class="content" style="padding-top:30px; margin-left:0px">

            <?php
            $lselect = "SELECT s.*, l.*
                                        from sections s, lessons l
                                        where s.SectionID=l.SectionID
                                        and s.SectionID=$SectionID";

            $lstmt = $conn->prepare($lselect);
            $lstmt->execute();
            $llist = $lstmt->fetchAll(PDO::FETCH_ASSOC);


            foreach ($llist as $value) :
            ?>

                <ul class="course-list">
                    <li class="justify-content-between d-flex" style="margin-bottom:15px;background-color:#F3E8F9;padding:15px">
                        <p style="padding-top:5px; color:black"><?php echo $value['LessonTitle'] ?></p>
                        <?php $lid = $value['LessonID'] ?>
                        <a class="btn text-uppercase" style="color:white; background-color:#9440FF" href="instructor_lessons_detail.php?LID=<?php echo $lid ?>">View Details</a>
                    </li>


                </ul>
            <?php endforeach; ?>
        </div>

        <h4 class="title" style="padding-top:30px; margin-bottom:30px">Other sections from <?php echo $cname ?></h4>
        <a class="btn text-uppercase" style="padding:10px; background-color:#54BE29; color:white" href="section_upload.php?CID=<?php echo $CourseID ?>">+ Add Sections</a>
        <div class="content" style="padding-top:30px">

            <?php
            $sselect = "SELECT s.*, c.*
                                        from sections s, courses c
                                        where s.CourseID=c.CourseID
                                        and s.CourseID=$CourseID";

            $sstmt = $conn->prepare($sselect);
            $sstmt->execute();
            $slist = $sstmt->fetchAll(PDO::FETCH_ASSOC);


            foreach ($slist as $value) :
            ?>

                <ul class="course-list">
                    <li class="justify-content-between d-flex" style="margin-bottom:15px;background-color:#F3E8F9;padding:15px">
                        <?php
                            if($value['SectionTitle']==$stitle){

                            
                        ?>
                        <p style="padding-top:5px; color:purple; font-weight:bold; font-style:italic; "><i class="fas fa-forward" style="padding-right:3px"></i><?php echo $value['SectionTitle'] ?></p>
                        <?php
                        }
                        else{
                        ?>
                          <p style="padding-top:5px; color:black"><?php echo $value['SectionTitle'] ?></p>
                        <?php
                        }
                        ?>

                        <?php $sid = $value['SectionID'] ?>
                        <a class="btn btn-primary" style=" background: linear-gradient(to right, #7c32ff 0%, #c738d8);border:none" href="instructor_section_detail.php?SID=<?php echo $sid ?>">View Details</a>
                    </li>


                </ul>
            <?php endforeach; ?>
        </div>

    </section>



    <!-- <h4 class="title">Reviews</h4>
                    <div class="content">
                        <div class="review-top row pt-40">
                            <div class="col-lg-12">
                                <h6 class="mb-15">Provide Your Rating</h6>
                                <div class="d-flex flex-row reviews justify-content-between">
                                    <span>Quality</span>
                                    <div class="star">
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span>Outstanding</span>
                                </div>
                                <div class="d-flex flex-row reviews justify-content-between">
                                    <span>Puncuality</span>
                                    <div class="star">
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span>Outstanding</span>
                                </div>
                                <div class="d-flex flex-row reviews justify-content-between">
                                    <span>Quality</span>
                                    <div class="star">
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star checked"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span>Outstanding</span>
                                </div>
                            </div>
                        </div>
                        <div class="feedeback">
                            <h6 class="mb-10">Your Feedback</h6>
                            <textarea name="feedback" class="form-control" cols="10" rows="10"></textarea>
                            <div class="mt-10 text-right">
                                <a href="#" class="btn text-center text-uppercase enroll">Submit</a>
                            </div>
                        </div>
                        <div class="comments-area mb-30">
                            <div class="comment-list">
                                <div class="single-comment single-reviews justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c1.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Emilly Blunt</a>
                                                <div class="star">
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star"></span>
                                                    <span class="fa fa-star"></span>
                                                </div>
                                            </h5>
                                            <p class="comment">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-list">
                                <div class="single-comment single-reviews justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c2.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Elsie Cunningham</a>
                                                <div class="star">
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star"></span>
                                                    <span class="fa fa-star"></span>
                                                </div>
                                            </h5>
                                            <p class="comment">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-list">
                                <div class="single-comment single-reviews justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c3.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Maria Luna</a>
                                                <div class="star">
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star"></span>
                                                    <span class="fa fa-star"></span>
                                                </div>
                                            </h5>
                                            <p class="comment">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->



    <!--================ End Course Details Area =================-->

    <!-- ================ start footer Area ================= -->

    <!-- ================ End footer Area ================= -->


</body>

</html>