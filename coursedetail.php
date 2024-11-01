<?php
error_reporting(0);
date_default_timezone_set("Asia/Yangon");

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

$CourseID = $_REQUEST['CDetailID'];
$_SESSION['CourseID'] = $CourseID;
$LearnerID = $_SESSION['LID'];



$cselect = "SELECT co.*, ins.*, ca.*
            from courses co, instructors ins, categories ca
            where co.CategoryID=ca.CategoryID
            and co.InstructorID=ins.InstructorID            
            and co.CourseID=$CourseID
           
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
$cinsid = $cfetch['InstructorID'];
$cprice = $cfetch['Price'];
$cslvl = $cfetch['SkillLevel'];
$cdate = $cfetch['PublishedDate'];
$lsup = $cfetch['LanguageUsed'];

if (isset($_REQUEST['btnsubmit'])) {
    // $scale = $_REQUEST['scale'];
    $scale = $_COOKIE['ratescale'];
    $scale++;
    $review = $_REQUEST['review'];
    $date = $_REQUEST['date'];

    $rinsert = "INSERT into ratingsandreviews (CourseID,LearnerID,Scale,Review,RRDateTime) values (:cid,:lid,:scale,:review,:date)";
    $rstmt = $conn->prepare($rinsert);
    $rstmt->bindParam(':cid', $CourseID);
    $rstmt->bindParam(':lid', $LearnerID);
    $rstmt->bindParam(':scale', $scale);
    $rstmt->bindParam(':review', $review);
    $rstmt->bindParam(':date', $date);

    $run = $rstmt->execute();
    if ($run) {
        echo "<script>window.alert('Thank you for your feedback!')</script>";
        echo "<script>location='coursedetail.php?CDetailID=$CourseID'</script>";
    } else {
        echo "<script>window.alert('Something went wrong!')</script>";
    }
}

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


if (isset($_REQUEST['btnupdate'])) {
    $scale = $_COOKIE['ratescale'];
    $scale++;

    // $_SESSION['uscale']=$scale;

    $review = $_REQUEST['ureview'];
    // $_SESSION['ureview']=$review;

    $date = $_REQUEST['date'];
    // $_SESSION['udate']=$date;

    $urid = $_REQUEST['urid'];

    $rupdate = "UPDATE ratingsandreviews
                                SET Scale=:scale, 
                                Review=:review, 
                                RRDateTime=:date
                                where RRID=:urid";
    $rustmt=$conn->prepare($rupdate);
    $rustmt->bindParam(":scale",$scale);
    $rustmt->bindParam(":review",$review);
    $rustmt->bindParam(":date",$date);
    $rustmt->bindParam(":urid",$urid);

    $urun=$rustmt->execute();
    if($urun)
    {
        echo "<script>window.alert('Your feedback has been updated')</script>";
        echo "<script>location='coursedetail.php?CDetailID=$CourseID'</script>";
    }
    else {
        echo "<script>window.alert('Update Error!')</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">
<style>
    .pop-container {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        background-color: rgba(0, 0, 0, 0.3);
        opacity: 0;
        pointer-events: none;
    }

    .pop {
        background-color: white;
        padding: 30px 50px;
        width: 600px;
        max-width: 100%;
    }

    .pop-container.show {
        opacity: 1;
        pointer-events: auto;
    }

    #butt{
        background: linear-gradient(to right, #7c32ff 0%, #c738d8);
      border: none;
      color: white;
    }
    
</style>



<body>
    <!-- star rating -->

    <script>
        var ratedIndex = -1;



        $(document).ready(function() {
            resetStarColors();

            if (localStorage.getItem('ratedIndex') != null) {
                setStars(parseInt(localStorage.getItem('ratedIndex')));
            }


            $('.fa-star.rate').on('click', function() {
                ratedIndex = parseInt($(this).data('index'));
                localStorage.setItem('ratedIndex', ratedIndex);
                saveToDB();
                document.cookie = "ratescale = " + ratedIndex;
            });

            $('.fa-star.rate').mouseover(function() {
                resetStarColors();

                var currentIndex = parseInt($(this).data('index'));

                setStars(currentIndex);
            });

            $('.fa-star.rate').mouseleave(function() {
                resetStarColors();

                //if someone didn't rate
                if (ratedIndex != -1) {
                    setStars(ratedIndex);
                }
            });
        });

        function saveToDB() {
            $.ajax({
                url: "coursedetail.php",
                method: "POST",
                dataType: "json",
                data: {
                    save: 1,
                    ratedIndex: ratedIndex + 1,
                },
                // success: function (r){

                // }

            })
        }

        function setStars(max) {
            for (var i = 0; i <= max; i++) {
                $('.fa-star.rate:eq(' + i + ')').css('color', '#FFBD33');
            }
        }

        function resetStarColors() {
            $('.fa-star.rate').css('color', 'white');
        }
    </script>


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

                    <h4 class="title" style="padding-top:30px; margin-bottom:30px">Sections in this course:</h4>

                    <div class="content" style="padding-top:30px">

                        <?php
                        $sselect = "SELECT s.*, c.*
                                        from sections s, courses c
                                        where s.CourseID=c.CourseID
                                        and c.CourseID=$CourseID";

                        $sstmt = $conn->prepare($sselect);
                        $sstmt->execute();
                        $slist = $sstmt->fetchAll(PDO::FETCH_ASSOC);

                        /////

                        if (isset($_SESSION['learnerlogin'])) {
                            $pdata = "SELECT * from purchase where CourseID=$CourseID and LearnerID=$LearnerID";
                            $pstmt = $conn->prepare($pdata);
                            $pstmt->execute();
                            $pfetch = $pstmt->fetch();
                            $plid = $pfetch['LearnerID'];
                            $pdate = $pfetch['PurchaseDate'];
                        } else {
                            $pdata = "SELECT * from purchase where CourseID=$CourseID";
                            $pstmt = $conn->prepare($pdata);
                            $pstmt->execute();
                            $pfetch = $pstmt->fetch();
                            $plid = $pfetch['LearnerID'];
                            $pdate = $pfetch['PurchaseDate'];
                        }





                        foreach ($slist as $value) :
                        ?>

                            <ul class="course-list">
                                <li class="justify-content-between d-flex" style="margin-bottom:15px;background-color:#F3E8F9;padding:15px">
                                    <p style="padding-top:5px; color:black"><?php echo $value['SectionTitle'] ?></p>
                                    <?php $sid = $value['SectionID'] ?>

                                    <?php

                                    if ($LearnerID !== $plid || !isset($_SESSION['learnerlogin'])) {

                                    ?>
                                        <a class="btn text-uppercase" href="" id="butt">Buy this course</a>




                                    <?php
                                    } else {
                                    ?>

                                        <a class="btn text-uppercase" href="section_details.php?SID=<?php echo $sid ?>" id="butt">Enter section</a>

                                    <?php
                                    }

                                    ?>




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
                            <p>Instructor</p>
                            <a href="Instructor_detail.php?IdetailId=<?php echo $cinsid ?>"><span><?php echo $cins ?></span></a>
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
                            <p>Total Learner: </p>
                            <span><?php echo $totallearner ?></span>
                        </a>
                    </li>

                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Average rating: </p>
                            <span><?php echo $avg ?> /5 </span>
                        </a>
                    </li>

                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Language </p>
                            <span><?php echo $lsup ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="justify-content-between d-flex">
                            <p>Published Date </p>
                            <span><?php echo $cdate ?></span>
                        </a>
                    </li>
                </ul>

                <?php



                if ($LearnerID != $plid or !isset($_SESSION['learnerlogin'])) {
                ?>
                    <a href="Purchase.php?cidToBuy=<?php echo $CourseID ?>" class="btn text-uppercase enroll" id="butt">Buy This Course</a>

                <?php
                } else {
                ?>
                    <h3 style="text-align: center; padding-top:15px">You have purchased this course on <?php echo $pdate ?> </h3>

                <?php
                }

                ?>

                <hr>


                <div class="content" style="margin:0%">
                    <div class=" ">
                        <?php
                        if ($LearnerID !== $plid || !isset($_SESSION['learnerlogin'])) {
                        ?>
                            <p> You have not purchased this course and thus cannot rate nor give feedback</p>
                            <?php
                        } else {
                            $rldata = $conn->prepare("SELECT r.* from Learners l,  courses c, ratingsandreviews r
                                                    where l.LearnerID=r.LearnerID
                                                    and c.CourseID=r.CourseID
                                                    and c.CourseID=$CourseID
                                                    and l.LearnerID=$plid
                                    ");
                            $rldata->execute();

                            if ($rldata->rowCount() > 0) {
                                echo "<br><h6 style='text-align:center'>You have already provided rating and review for this course</h6>";
                            } else {
                            ?>

                                <form action="" method="post">
                                    <div class="col-lg-12">
                                        <h6 class="mb-15">Provide Your Rating</h6>

                                        <!-- <select name="scale" id="" style="color:black">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select> -->

                                        <div align="center">
                                            <i class="fas fa-star rate fa-2x" data-index="0" style=" text-shadow: 0 0 2px #000;"></i>
                                            <i class="fas fa-star rate fa-2x" data-index="1" style=" text-shadow: 0 0 2px #000;"></i>
                                            <i class="fas fa-star rate fa-2x" data-index="2" style=" text-shadow: 0 0 2px #000;"></i>
                                            <i class="fas fa-star rate fa-2x" data-index="3" style=" text-shadow: 0 0 2px #000;"></i>
                                            <i class="fas fa-star rate fa-2x" data-index="4" style=" text-shadow: 0 0 2px #000;"></i>
                                        </div>
                                        <input type="text" hidden name="date" class="form-control" value="<?php echo date('Y-m-d H:i:s') ?>">
                                    </div>
                    </div>
                    <div class="feedeback">
                        <h6 class="mb-10">Your Feedback</h6>
                        <textarea name='review' placeholder="Tell us what you feel about this course" class="form-control" cols="10" rows="10"></textarea>
                        <div class="mt-10 text-right">
                            <button class="btn" style="background-color: #9E33EC; color:white;" name="btnsubmit">Submit</button> <br>
                        </div>
                    </div>
                    </form>
            <?php

                            }
                        }

            ?>
            <br>
            <hr>

            <h3>Ratings and Reviews for this course</h3>

            <!-- <div class="comments-area" style=" width:100%; height: 100%;">

                    <div class="comment-list"> -->
            <?php
            $rselect = "SELECT r.*, l.*
                                        from ratingsandreviews r, learners l
                                        where l.LearnerID=r.LearnerID
                                        and r.CourseID=$CourseID
                                        order by RRDateTime DESC
                                    ";

            $rstmt = $conn->prepare($rselect);
            $rstmt->execute();
            $rlist = $rstmt->fetchAll(PDO::FETCH_ASSOC);



            foreach ($rlist as $value) :

            ?>
                <div class="comments-area" style=" width:100%;padding-left:20px">

                    <div class="comment-list">

                        <div class="single-comment single-reviews justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">

                                <div class="thumb">
                                    <img style="width:40px; border-radius: 50%;  margin:-6px " src="<?php echo $value['ProfilePicture'] ?>" alt="">
                                </div>
                                <div class="desc" style="width:100% ; ">
                                    <h5><a href="#"><?php echo $value['LearnerName'] ?></a> </h5> <br> <br>


                                    <!-- <p style="background-color: red;">Rating:                                           -->


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
                                    ?>



                                    <!-- </p> -->

                                    <br>
                                    <p class="comment">
                                        <?php echo $value['Review'] ?>
                                    </p>
                                    <p><?php echo $value['RRDateTime'] ?></p>

                                    <?php
                                    if ($value['LearnerID'] == $_SESSION['LID']) {
                                    ?>
                                        <button class="btn" style="background-color: #9E33EC; color:white;" id="open"><i class="fas fa-pen"></i></button> <br><br><br>


                                        <div class="pop-container" id="pop_container">
                                            <div class="pop">
                                                <button class="btn" style="background-color: #9E33EC; color:white; float:right" id="close">x</i></button>

                                                <form action="CourseDetail.php?CDetailID=<?php echo $CourseID ?>" method="post">

                                                    <h6 class="mb-15">Update Your Rating</h6>



                                                    <div>
                                                        <i class="fas fa-star rate fa-2x" data-index="0" style=" text-shadow: 0 0 2px #000;"></i>
                                                        <i class="fas fa-star rate fa-2x" data-index="1" style=" text-shadow: 0 0 2px #000;"></i>
                                                        <i class="fas fa-star rate fa-2x" data-index="2" style=" text-shadow: 0 0 2px #000;"></i>
                                                        <i class="fas fa-star rate fa-2x" data-index="3" style=" text-shadow: 0 0 2px #000;"></i>
                                                        <i class="fas fa-star rate fa-2x" data-index="4" style=" text-shadow: 0 0 2px #000;"></i>
                                                    </div>

                                                    <input type="text" hidden name="date" class="form-control" value="<?php echo date('Y-m-d H:i:s') ?>">


                                                    <div class="feedeback">
                                                        <h6 class="mb-10">Your Feedback</h6>
                                                        <textarea name='ureview' placeholder="Tell us what you feel about this course" class="form-control" cols="10" rows="10"></textarea>

                                                    </div>


                                                    <input type="text" hidden name="urid" value=" <?php echo $value['RRID'] ?>">

                                                    <div class="mt-10 text-right">

                                                        <button align="center" class="btn" style="background-color: #9E33EC; color:white;" name="btnupdate">Update</button> <br>
                                                    </div>

                                                </form>
                                            </div>



                                        </div>

                                </div>

                                <script>
                                    const open = document.getElementById('open');
                                    const pop_container = document.getElementById('pop_container');
                                    const close = document.getElementById('close');

                                    open.addEventListener('click', () => {
                                        pop_container.classList.add('show');
                                    });

                                    close.addEventListener('click', () => {
                                        pop_container.classList.remove('show');
                                    });
                                </script>



                            <?php

                                    }

                            ?>

                            </div>


                        </div>
                    </div>

                </div>
                <hr style="margin: 0px;">






                </div>
            <?php endforeach; ?>
            </div>

        </div>


        </div>
    </section>





    <!--================ End Course Details Area =================-->

    <!-- ================ start footer Area ================= -->

    <!-- ================ End footer Area ================= -->

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/parallax.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/hexagons.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>