<?php
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
} else {
    require_once('header_reg.php');
}

$CourseID = $_SESSION['CourseID'];
$LearnerID=$_SESSION['LID'];

$SectionID = $_REQUEST['SID'];
$_SESSION['SectionID'] = $SectionID;



$sselect = "SELECT co.*, ins.*, s.*
            from courses co, instructors ins, sections s
            where co.CourseID=s.CourseID
            and co.InstructorID=ins.InstructorID            
            and s.SectionID=$SectionID
            
           
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
                <h2 class="title" style="margin-top:30px; color:#9E33EC"><?php echo $stitle ?></h1>
                    <h3 style="margin-top:30px"> Description
                </h2>

                <div class="content" style="padding-top:30px; color:black">
                    <?php echo $sdes ?>
                </div>
                <div class="content" style="padding-top:30px; color:black">
                   
                        <?php
                        if ($smaterial == NULL) {
                            echo "<p> Material file : No material file to show</p>";
                        } else {

                        ?>
                             Material File: <?php echo $smaterial ?> | <a href="filedownload.php?file=<?php echo $smaterial ?>">Download</a>

                        <?php

                        }

                        ?> <br><br>
                        

                        



                </div>


            </div>
        </div>

        <h3 class="title" style="padding-top:30px; margin-bottom:30px; margin-left:10px">Lessons in this section</h3>
  
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
                        <a class="btn text-uppercase" style="color:white; background-color:#9440FF" href="lesson_details.php?LID=<?php echo $lid ?>">Enter Lesson</a>
                    </li>


                </ul>
            <?php endforeach; ?>
        </div>


        <h3 class="title" style="padding-top:30px; margin-bottom:30px; margin-left:10px">Other Sections in this course</h3>
  
        <div class="content" style="padding-top:30px; margin-left:0px">

        <?php
                        $sselect = "SELECT s.*, c.*
                                        from sections s, courses c
                                        where s.CourseID=c.CourseID
                                        and s.CourseID=$CourseID";

                        $sstmt = $conn->prepare($sselect);
                        $sstmt->execute();
                        $slist = $sstmt->fetchAll(PDO::FETCH_ASSOC);

                        /////
                        $pdata = "SELECT * from purchase where CourseID=$CourseID";

                        $pstmt = $conn->prepare($pdata);
                        $pstmt->execute();
                        $pfetch = $pstmt->fetch();
                        $plid = $pfetch['LearnerID'];
                        $pdate=$pfetch['PurchaseDate'];


                        foreach ($slist as $value) :
                        ?>

                            <ul class="course-list">
                                <li class="justify-content-between d-flex" style="margin-bottom:15px;background-color:#F3E8F9;padding:15px">
                                    <p style="padding-top:5px; color:black"><?php echo $value['SectionTitle'] ?></p>
                                    <?php $sid = $value['SectionID'] ?>

                                    <?php

                                    if ($LearnerID == $plid || isset($_SESSION['learnerlogin'])) {
                                    ?>
                                         <a class="btn" style="background: linear-gradient(to right, #7c32ff 0%, #c738d8);  border: none;color: white;" href="section_details.php?SID=<?php echo $sid ?>">Enter section</a>

                                    <?php
                                    } else {
                                    ?>
                                       
                                       <a class="btn text-uppercase" style="background: linear-gradient(to right, #7c32ff 0%, #c738d8);  border: none;color: white;" href="">Buy this course</a>
                                    <?php
                                    }

                                    ?>


                            
                                    
                                </li>


                            </ul>
                        <?php endforeach; ?>
        </div>

    </section>



    


</body>

</html>