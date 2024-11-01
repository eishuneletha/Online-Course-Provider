<?php
session_start();
include('connect.php');

if (isset($_SESSION['IID'])) {
    $instructorid = $_SESSION['IID'];

    $selectinst = "SELECT * from instructors where InstructorID=:iid";
    $stmt = $conn->prepare($selectinst);
    $stmt->bindParam(':iid', $instructorid);
    $stmt->execute();

    $idata = $stmt->fetch(PDO::FETCH_BOTH);
    $iname = $idata['InstructorName'];
    $iemail = $idata['Email'];
    $ipp = $idata['ProfilePicture'];
} else {
    echo "<script>window.alert('Instructor Access Denied! Login first')</script>";
    echo "<script>location='InstructorLogin.php'</script>";
}







?>


<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <script src="https://kit.fontawesome.com/c8fd1d96f9.js" crossorigin="anonymous"></script>

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/fav.png" />
    <!-- Author Meta -->
    <meta name="author" content="colorlib" />
    <!-- Meta Description -->
    <meta name="description" content="" />
    <!-- Meta Keyword -->
    <meta name="keywords" content="" />
    <!-- meta character set -->
    <meta charset="UTF-8" />
    <!-- Site Title -->
    <title>Educally</title>

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:900|Roboto:400,400i,500,700" rel="stylesheet" />
    <!--
      CSS
      =============================================
    -->
    <link rel="stylesheet" href="css/linearicons.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/owl.carousel.css" />
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/hexagons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>

<style>
    #link:hover {
            cursor: pointer;
            color: black;
            background-color: #ECE3F4;
        }
    @media only screen and (max-width:1000px) {
        #link {
            color: white;
        }

        #link:hover {
            cursor: pointer;
            color: black;
        }
    }
</style>

<body>
    <!-- ================ Start Header Area ================= -->


    <header class="default-header">
        <nav class="navbar navbar-expand-lg  navbar-light">
            <div class="container">
                <a class="navbar-brand" href="index.html" style="color:white;font-family: 'Playfair Display', serif;font-size: 30px;">

                    Educally
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="lnr lnr-menu"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">

                    <ul class="navbar-nav">

                        <li><a href="index.php">Home</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                Categories
                            </a>
                            <div class="dropdown-menu">
                                <?php
                                $caselect = "SELECT * from categories";
                                $castmt = $conn->prepare($caselect);
                                $castmt->execute();

                                $cacount = $castmt->rowCount();

                                for ($i = 0; $i < $cacount; $i++) {
                                    $cafetch = $castmt->fetch(PDO::FETCH_BOTH);
                                    $caid = $cafetch['CategoryID'];
                                    $caname = $cafetch['CategoryName'];

                                ?>
                                    <a class='dropdown-item' id="link" style='cursor:pointer;' href="categories.php?cidtoview=<?php echo $caid ?>"><?php echo $caname ?></a>
                                <?php
                                }
                                ?>



                            </div>
                        </li>

                        <li><a href="instructor_courses.php">Uploaded Courses</a></li>
                        <li><a href="instructor_course_upload.php">Upload Courses</a></li>
                        <li><a href="instructor_profile.php">View Profile</a></li>

                        <li><a href="Instructor_Logout.php" style=" padding:10px;background-color:#D54335;">Logout</a></li>
                        <!-- Dropdown -->


                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                <img style="width:40px; border-radius: 50%;  margin-top:-10px " src="<?php echo $ipp ?>" alt="">
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" id="link"><?php echo $iname ?></a>
                                <a class="dropdown-item" id="link"><?php echo $iemail ?></a>
                                <?php
                                if (isset($_SESSION['LID'])) {
                                    $learnerid = $_SESSION['LID'];

                                ?>
                                    <a class="dropdown-item" id="link" href="index.php">Switch to Learner</a>

                                <?php
                                } else {

                                ?>
                                    <a class="dropdown-item" id="link" style="font-weight:bold;" href="LearnerLogin.php">Switch to Learner</a>
                                <?php
                                }
                                ?>


                            </div>
                        </li>

                    </ul>




                </div>
            </div>
        </nav>
    </header>





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