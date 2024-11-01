<?php
error_reporting(0);
session_start();

include('connect.php');

if (isset($_SESSION['LID'])) {
    $learnerid = $_SESSION['LID'];

    $selectlearner = "SELECT * from learners where LearnerID=:lid";
    $stmt = $conn->prepare($selectlearner);
    $stmt->bindParam(':lid', $learnerid);
    $stmt->execute();

    $ldata = $stmt->fetch(PDO::FETCH_BOTH);
    $lname = $ldata['LearnerName'];
    $lemail = $ldata['Email'];
    $lpp = $ldata['ProfilePicture'];
} else {
    echo "<script>window.alert('Access Denied! Login first')</script>";
    echo "<script>location='LearnerLogin.php'</script>";
}



if (isset($_POST['search'])) {
    $response = "";
    // $response2 = "";

    $q = $_REQUEST['q'];

    $casql = "  SELECT CategoryName
                  from categories 
                  where CategoryName like '%$q%'  
                                  ";
    $castmt = $conn->prepare($casql);

    $castmt->execute();
    $cacount = $castmt->rowCount(); //my sqli num rows


    ///////////////////////////////////////
    $cosql = " SELECT ca.CategoryName, co.CourseTitle
                  from categories ca, courses co 
                  where ca.CategoryID=co.CategoryID
                  and  (ca.CategoryName like '%$q%'
                  or co.CourseTitle like '%$q%')
                  and co.Status=1";
    $costmt = $conn->prepare($cosql);

    $costmt->execute();
    $cocount = $costmt->rowCount(); //my sqli num rows



    if ($cacount > 0) {
        // echo "cacount= " . $cacount;

        $response = "<ul id='ulli'>";

        for ($i = 0; $i < $cacount; $i++) {

            $cafetch = $castmt->fetch(PDO::FETCH_BOTH);
            $caname = $cafetch['CategoryName'];



            $response .=   "<li id='calist' col-md-6>" . $caname . "</li>";
        }



        // $response .= "</ul>";

    }

    if ($cocount > 0) {
        // echo "cocount= " . $cocount;

        // $response2 = "<ul >";

        for ($i = 0; $i < $cocount; $i++) {
            $cofetch = $costmt->fetch(); //mysqli fetch array

            $coname = $cofetch['CourseTitle'];


            $response .=   "<li id='colist' col-md-6>" . $coname . "</li>";
        }

        $response .= "</ul>";
    } else {
        echo "<script>
      document.getElementById('response').innerHTML='No results to show';
      </script>";
    }


    exit($response);
}



if (isset($_REQUEST['btnsearch'])) {
    $search = $_REQUEST['txtsearch'];
    echo "<script>location='search.php?svalue=$search'</script>";
}







?>


<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <script src="https://kit.fontawesome.com/c8fd1d96f9.js" crossorigin="anonymous"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> -->

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
    .lnr-magnifier {
        background-color: white;
        border: none;
        color: #9533EC;
        font-weight: bolder;
        padding: 10px;
        width: 37px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 15px;
        border-radius: 30px;
        cursor: pointer;
        margin-top: -50px;
    }

    .searchbutton {
        background-color: #9533EC;
        color: white;
        border: none;
        padding: 0px;
        width: 40px;
        text-align: center;
        text-decoration: none;
        /* display: inline-block; */
        /* font-size: 15px; */
        border-radius: 45px;
        cursor: pointer;
        margin-right: 25px;
    }

    #response {
        display: block;

        background-color: white;

        /* border-width: 1px;     */
        /* border-color: black; */
        margin-top: 55px;

        border-radius: 10px;
        text-align: left;
        box-shadow: 0 2px 8px -5px black;
        max-height: 60vh;
        overflow-x: auto;

        white-space: nowrap;
    }

    #response li {
        padding-bottom: 10px;
        padding-top: 10px;
        color: black;
        cursor: pointer;
        padding-left: 20px;
    }

    #response li:hover {
        background-color: #F6ECFF;

    }



    @media only screen and (max-width:1000px) {
        .searchbutton {
            background-color: #9533EC;
            color: white;
            border: none;
            padding: 0px;
            width: 45px;
            text-align: center;
            text-decoration: none;
            /* display: inline-block; */
            /* font-size: 15px; */
            border-radius: 60%;
            cursor: pointer;
            margin-right: 10px;

        }

        #search-input-box {
            max-width: 90%;


        }

        #searchbox {
            width: 100%;
            text-align: left;

        }

        #link:hover {
            /* background-color: purple; */
            color: black;
        }

       
        


    }
</style>

<body>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <!-- ================ Start Header Area ================= -->


    <header class="default-header">
        <nav class="navbar navbar-expand-lg  navbar-light">
            <div class="container">
                <a class="navbar-brand" href="index.php" style="color:white;font-family: 'Playfair Display', serif;font-size: 30px;">

                    Educally
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="lnr lnr-menu"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">

                    <ul class="navbar-nav">
                        <li>
                            <button class="search">
                                <span class="lnr lnr-magnifier" id="search"></span>
                                <!-- <span><i class="fas fa-search" id="search"></i></span> -->
                            </button>

                            <div class="search-input" id="search-input-box">
                                <div class="container">
                                    <form class="d-flex justify-content-between" method="post">

                                        <input type="text" class="form-control" id="searchbox" name="txtsearch" placeholder="Search Here">

                                        <button name="btnsearch" class="searchbutton"><i class="fas fa-search"></i></button>

                                        <span class="lnr lnr-cross" id="close-search" title="Close Search"></span>

                                        <div id="response">
                                            <!-- <ul>
                        <li>hiehrewrewor</li>
                        <li>hiehrewrewor</li>
                        <li>hiehrewrewor</li>
                        <li>hiehrewrewor</li>
                      </ul> -->
                                        </div>

                                    </form>
                                    <script>
                                        $(document).ready(function() {
                                            $("#searchbox").keyup(function appear() {
                                                console.log('key up activated');
                                                var query = $("#searchbox").val();
                                                var sug = document.getElementById('response');

                                                if (query.length > 0) {
                                                    sug.style.display = 'block';
                                                    $.ajax({
                                                        url: "header_reg.php",
                                                        method: "POST",
                                                        data: {
                                                            search: 1,
                                                            q: query
                                                        },
                                                        success: function(data) { //if this ajax code is succeeded
                                                            // console.log(data);
                                                            $("#response").html(data);


                                                        },
                                                        dataType: 'text'
                                                    });

                                                } else {

                                                    sug.style.display = 'none';
                                                    console.log('no text');

                                                }

                                            });
                                            $(document).on('click', '#calist', function() {
                                                var search = $(this).text();
                                                console.log(search);
                                                $("#searchbox").val(search);
                                                $("#response").html("");
                                                document.getElementById('response').style.display = 'none';

                                            });

                                            $(document).on('click', '#colist', function() {
                                                var search = $(this).text();
                                                console.log(search);
                                                $("#searchbox").val(search);
                                                $("#response").html("");

                                                box.style.display = 'none';
                                            });
                                        });

                                        document.addEventListener('click', function hide(event) {
                                            console.log('user clicked: ', event.target);

                                            const box = document.getElementById('response');

                                            if (!box.contains(event.target)) {
                                                document.getElementById('response').style.display = 'none';
                                            }
                                        });
                                    </script>


                                </div>




                            </div>
                        </li>

                        <script>
                            // $(document).ready(function () {
                            //     $('#search-input').keyup(function () {
                            //         var svalue=$(this).val();
                            //         alert(svalue);
                            //         if (svalue!='') {
                            //             $.ajax({
                            //                 url:"header.php",
                            //                 method:"POST",
                            //                 data:{query:svalue},
                            //                 success:function (data){
                            //                     $('#searchlist').fadeIn();
                            //                     $('#searchlist').html(data);
                            //                 }
                            //             });
                            //         }

                            //     })
                            // })

                            function load_data(quey) {

                            }
                        </script>
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

                        <li><a href="index.php">Home</a></li>
                        <li><a href="learner_courses.php">Your Purchases</a></li>

                        <?php
                        if (isset($_SESSION['IID'])) {


                        ?>
                            <li><a href="instructor_courses.php" style=" padding:10px; margin-right:10px; background-color:#FE993F;">Teach at Educally</a></li>

                        <?php
                        } else {

                        ?>
                            <li><a href="InstructorLogin.php" style=" padding:10px; margin-right:10px; background-color:#FE993F;">Teach at Educally</a></li>
                        <?php
                        }
                        ?>


                        <li><a href="LearnerLogout.php" style=" padding:10px;background-color:#D54335;">Logout</a></li>
                        <!-- Dropdown -->




                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                <img style="width:40px; border-radius: 50%;  margin-top:-10px " src="<?php echo $lpp ?>" alt="">
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item"><?php echo $lname ?></a>
                                <a class="dropdown-item"> <?php echo $lemail ?></a>



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