<?php
include('connect.php');
include('header.php');
// if (!isset($_SESSION)) {
//     session_start();
// } else {
//     session_destroy();
//     session_start();
// }

if (isset($_SESSION['learnerlogin'])) {
    require_once('header.php');
    $LearnerID = $_SESSION['LID'];
  } else {
    require_once('header_reg.php');
  }
// $LearnerID = $_SESSION['LID'];


$cselect = "SELECT co.*, ins.*, ca.*,l.*, p.*
            from courses co, instructors ins, categories ca, learners l, purchase p
            where co.CategoryID=ca.CategoryID
            and co.InstructorID=ins.InstructorID  
            and co.CourseID=p.CourseID
            and p.LearnerID=l.LearnerID        
            and l.LearnerID=:learnerid
            and co.Status=1";
$cstmt = $conn->prepare($cselect);
$cstmt->bindParam(":learnerid", $LearnerID);
$cstmt->execute();
$clist = $cstmt->fetchAll(PDO::FETCH_ASSOC);
$crow = $cstmt->rowCount();
// $CourseID = $clist['CourseID'];


// $results_per_page = 4;

// $number_of_pages = ceil($crow / $results_per_page);


//determine which page number visitor is currently on
// if (!isset($_GET['page'])) {
//     $page = 1;
// } else {
//     $page = $_GET['page'];
// }


//limit
// $this_page_first_result = ($page - 1) * $results_per_page;

// $cselect = "SELECT co.*, ins.*, ca.*,l.*, p.*
//             from courses co, instructors ins, categories ca, learners l, purchase p
//             where co.CategoryID=ca.CategoryID
//             and co.InstructorID=ins.InstructorID  
//             and co.CourseID=p.CourseID
//             and p.LearnerID=l.LearnerID        
//             and l.LearnerID=:learnerid
//             and co.Status=1
//             LIMIT $this_page_first_result,  $results_per_page";
// $cstmt = $conn->prepare($cselect);
// $cstmt->bindParam(":learnerid", $LearnerID);
// $cstmt->execute();
// $clist = $cstmt->fetchAll(PDO::FETCH_ASSOC); //mysqli_fetch_array

// if ($crow == 0) {
//     echo "<script>window.alert('You have not purchased any course yet')</script>";
// }


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
    @media only screen and (max-width:922px) {
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
            margin-right: auto;
            /* background-color: red; */

        }



        .card>img {
            margin-bottom: .75rem;
            width: 100%;
        }

        .card-text,
        .card-title {
            font-size: 70%;
           
        }

        .btn-primary {
            font-size: 10px;
            
     
        }

       
      


    }
</style>

<body>
    <section class="popular-course-area section-gap">
        <div class="container-fluid">
            <div class="row justify-content-center section-title">
                <div class="col-lg-12">

                    <h3>
                        The following are the courses you have purchased.
                    </h3>
                </div>
            </div>

            <div class="container overflow-hidden">
                <div class="row gy-5">
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
                                    <a href="CourseDetail.php?CDetailID=<?php echo $value['CourseID'] ?>" class="btn btn-primary" style="background-color: #9E33EC; color:white; border:0px">Continue Course</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>


        </div>
    </section>
    
</body>

</html>