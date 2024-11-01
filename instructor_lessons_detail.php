<?php
// session_start();
error_reporting(0);
include('connect.php');
include('header_inst.php');

$CourseID = $_SESSION['CourseID'];
$SectionID = $_SESSION['SectionID'];

$LessonID = $_REQUEST['LID'];
$iid = $_SESSION['IID'];



$lselect = "SELECT co.*, ins.*, s.*,l.*
            from courses co, instructors ins, sections s, lessons l
            where co.CourseID=s.CourseID
            and co.InstructorID=ins.InstructorID            
            and s.SectionID=l.SectionID
            and s.SectionID=$SectionID
            and co.CourseID=$CourseID
            and l.LessonID=$LessonID
            and ins.InstructorID=$iid
            ";
$lstmt = $conn->prepare($lselect);
$lrun = $lstmt->execute();
$lfetch = $lstmt->fetch($lrun);

$ltitle = $lfetch['LessonTitle'];
$ldes = $lfetch['LessonDescription'];
$lvid = $lfetch['VideoFile'];
$ldate = $lfetch['UploadDate'];
$iname = $lfetch['InstructorName'];
$iid = $lfetch['InstructorID'];
$ipp = $lfetch['ProfilePicture'];
$ctitle = $lfetch['CourseTitle'];
$stitle = $lfetch['SectionTitle'];
$sid = $lfetch['SectionID'];

if (isset($_REQUEST['btnsubmit'])) {
    $qusid = $_REQUEST['qid'];
    $reply = $_REQUEST['reply'];
    $date = $_REQUEST['date'];

    $sql = "INSERT into reply (QuestionID, Reply,ReplyDate) values (:qid, :reply, :date)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":qid", $qusid);
    $stmt->bindParam(":reply", $reply);
    $stmt->bindParam(":date", $date);

    $run = $stmt->execute();

    if ($run) {
        echo "<script>window.alert('Reply success')</script>";
    } else {
        echo "<script>window.alert('Something went wrong!')</script>";
    }
}

// $repselect="SELECT r.*,q.*,l.*,s.*,c.*,i.*
//             where Reply r, Questions q, Lessons l, Sections s, Instructors i, Courses c
//             and r.QuestionID=q.QuestionID
//             and l.LessonID=q.LessonID
//             and l.SectionID=s.SectionID
//             and s.CourseID=c.CourseID
//             and c.InstructorID=i.InstructorID
//             ";
$repselect = "SELECT r.*, q.*  
            from reply r, questions q 
            where r.QuestionID= q.QuestionID";
$rprepare = $conn->prepare($repselect);
$reprun = $rprepare->execute();
$repfetch = $rprepare->fetch($reprun);
$repdate = $repfetch['ReplyDate'];
$repdata = $repfetch['Reply'];




?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesson Detail</title>
</head>


<body>


    <!--================ Start Course Details Area =================-->
    <section class="section-gap container">



        <div class="row" style="width:100%; margin-left:0px">
            <div class="col-lg-7 course-details-left">
                <div class="main-image">
                    <video width="800" controls style="max-width:100% ; height:auto">
                        <source src="lessonvideos/<?php echo $lvid ?>" type="video/mp4">
                        <source src="lessonvideos/<?php echo $lvid ?>" type="video/ts">

                    </video>
                </div>
                <div class="content-wrapper" style="padding-top:30px">
                    <h1 class="title"><?php echo $ltitle ?></h1>
                    <div class="content" style="padding-top:30px">
                        <?php echo $ldes ?>
                    </div>

                    <!-- <h2 class="title" style="padding-top:30px">Uploaded Date</h2>
                    <div class="content" style="padding-top:30px">
                       
                    </div> -->


                </div>
                <h4 style="padding-top:30px ;">Go to other lessons under <?php echo $stitle ?> </h4>
                <div class="content" style="padding-top:30px; margin-left:0px">

                    <?php
                    $lselect = "SELECT s.*, l.*
                                from sections s, lessons l
                                where s.SectionID=l.SectionID
                                and s.SectionID=$SectionID
                                ";

                    $lstmt = $conn->prepare($lselect);
                    $lstmt->execute();
                    $llist = $lstmt->fetchAll(PDO::FETCH_ASSOC);


                    foreach ($llist as $value) :
                    ?>

                        <ul class="course-list">
                            <li class="justify-content-between d-flex" style="margin-bottom:15px;background-color:#F3E8F9;padding:15px">
                                <?php
                                if ($value['LessonTitle'] == $ltitle) {

                                ?>
                                    <p style="padding-top:5px;color:purple; font-weight:bold; font-style:italic;"><i class="fas fa-forward" style="padding-right:3px"></i><?php echo $value['LessonTitle'] ?></p>
                                <?php
                                } else {
                                ?>
                                <p style="padding-top:5px;color:black;"><?php echo $value['LessonTitle'] ?></p>
                                <?php
                                }
                                ?>
                                <?php $lid = $value['LessonID'] ?>
                                <a class="btn btn-primary" style=" background: linear-gradient(to right, #7c32ff 0%, #c738d8); color:white; border:none" href="instructor_lessons_detail.php?LID=<?php echo $lid ?>">Enter Lesson</a>
                            </li>


                        </ul>
                    <?php endforeach; ?>
                </div>
            </div>


            <div class="col-lg-5 right-contents">
                <ul>
                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Instructor's Name</p>
                            <span class="or"> <?php echo $iname ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Course Title </p>
                            <span><?php echo $ctitle ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Section Title </p>
                            <span> <?php echo $stitle ?></span>

                        </a>
                    </li>

                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Uploaded Date </p>
                            <span> <?php echo $ldate ?></span>
                        </a>
                    </li>



                </ul>
                <a href="instructor_lessons_update.php?lIdToUpdate=<?php echo $LessonID ?>" class="btn text-uppercase enroll">Edit Lesson</a>
                <a href="instructor_section_detail.php?SID=<?php echo $sid ?>" class="btn text-uppercase enroll">Go back to Section</a>

                <br>
                <hr><br>

                <h3>Questions for this lesson</h3>
                <div class="comments-area">

                    <div class="comment-list">

                        <?php

                        $qselect = "SELECT q.*,l.*
                                    from  questions q, learners l
                                
                                    where q.LearnerID=l.LearnerID
                                    and q.LessonID=$LessonID";

                        $qstmt = $conn->prepare($qselect);
                        $qstmt->execute();
                        $qlist = $qstmt->fetchAll(PDO::FETCH_ASSOC);

                        // $selcount = $qstmt->rowCount();

                        // $rselect="SELECT r.*, q.*
                        //         from questions q, reply r
                        //         where q.QuestionID=r.QuestionID";
                        $rselect = "SELECT * from reply";
                        $rstmt = $conn->prepare($rselect);
                        $rrun = $rstmt->execute();
                        $rfetch = $rstmt->fetch($rrun);
                        $qid = $rfetch['QuestionID'];



                        foreach ($qlist as $value) :

                        ?>

                            <br>
                            <div class="single-comment justify-content-between d-flex">
                                <div class="user justify-content-between d-flex">
                                    <div class="thumb">
                                        <img style="width:40px; border-radius: 50%; " src="<?php echo $value['ProfilePicture']; ?>" alt="">
                                    </div>
                                    <div class="desc">
                                        <h5><a href="#"><?php echo $value['LearnerName'] ?></a></h5>
                                        <p class="date"><?php echo $value['AskedDate'] ?></p>



                                        <p class="comment">
                                            <?php echo $value['Question'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <?php
                            $quesid = $value['QuestionID'];
                            $rselect = "SELECT r.*,q.*,l.*,s.*,c.*,i.*
                                        from reply r, questions q, lessons l, sections s, instructors i, courses c
                                        where r.QuestionID=q.QuestionID
                                        and l.LessonID=q.LessonID
                                        and s.CourseID=c.CourseID
                                        and c.InstructorID=i.InstructorID
                                        and r.QuestionID=$quesid 
                                        and i.InstructorID=$iid";
                            $rstmt = $conn->prepare($rselect);
                            $rrun = $rstmt->execute();
                            $rfetch = $rstmt->fetch($rrun);
                            $qid = $rfetch['QuestionID'];

                            if ($qid === $value['QuestionID']) {

                            ?>

                                <div class="comment-list left-padding">
                                    <div class="single-comment justify-content-between d-flex">
                                        <div class="user justify-content-between d-flex">
                                            <div class="thumb">
                                                <img style="width:40px; border-radius: 50%; " src="<?php echo $rfetch['ProfilePicture'] ?>" alt="">
                                            </div>
                                            <div class="desc">
                                                <h5><a href="#"><?php echo $rfetch['InstructorName'] ?></a></h5>

                                                <p class="date"><?php echo $rfetch['ReplyDate'] ?> </p>
                                                <p class="comment">
                                                    <?php echo $rfetch['Reply'] ?>
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr>

                            <?php
                            } else {

                            ?>

                                <form action="" method="post">
                                    <div class="feedeback">

                                        <textarea name='reply' required placeholder="Give a reply to this course" class="form-control" cols="10" rows="10"></textarea>
                                        <input type="text" name="date" hidden value="<?php echo date('Y-m-d') ?>">
                                        <div class="mt-10 text-right">

                                            <input type="text" name="qid" hidden value="<?php echo $value['QuestionID'] ?>">
                                            <button class="btn" style="background-color: #9E33EC; color:white;" name="btnsubmit">Reply</button> <br>
                                        </div>
                                    </div>
                                </form>
                                <hr>

                            <?php
                            }
                            ?>


                        <?php
                        endforeach;
                        ?>

                    </div>








                </div>




            </div>
        </div>
    </section>




</body>

</html>