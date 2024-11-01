<?php

include('connect.php');
error_reporting(0);

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


$results_per_page = 2;


$search = $_REQUEST['svalue'];


$cselect = "SELECT co.*, ins.*, ca.*
            from courses co, instructors ins, categories ca
            where co.CategoryID=ca.CategoryID
            and co.InstructorID=ins.InstructorID          
            and (co.CourseTitle  like '%$search%'  
            or co.SkillLevel  like '%$search%'
            or ca.CategoryName like '%$search%' )
            and co.Status=1";
$cstmt = $conn->prepare($cselect);
$cstmt->execute();
$clist = $cstmt->fetchAll(PDO::FETCH_ASSOC); //mysqli_fetch_array
$crow = $cstmt->rowCount(); //mysqli_num_rows

if ($crow == 0) {
    echo "<script>window.alert('No courses found for $search')</script>";
    // echo "<script>location='index.php'</script>";
}

echo $search;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
     .btn-primary{
    background:linear-gradient(to right, #7c32ff 0%, #c738d8  ); border:none;

  }

</style>

<body>
    <section class="popular-course-area section-gap">
        <div class="container" style="padding:5 rem">
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
                                    $plid = $pfetch['LearnerID'] ?? 'default';
                                    $pdate = $pfetch['PurchaseDate'] ?? 'default';
                                } else {
                                    $pdata = "SELECT * from purchase where CourseID=$cid";
                                    $pstmt = $conn->prepare($pdata);
                                    $pstmt->execute();
                                    $pfetch = $pstmt->fetch();
                                    $plid = $pfetch['LearnerID'] ?? 'default';
                                    $pdate = $pfetch['PurchaseDate'] ?? 'default';
                                }






                                if ($LearnerID == $plid || isset($_SESSION['learnerlogin'])) {
                                ?>
                                    <a href='CourseDetail.php?CDetailID=<?php echo $value['CourseID'] ?>' class='btn btn-primary'>Continue Course</a>

                                <?php
                                } else {

                                ?>
                                    <a href='CourseDetail.php?CDetailID=<?php echo $value['CourseID'] ?>' class='btn btn-primary'>Learn More</a>

                                <?php
                                }
                                ?>



                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>
</body>

</html>