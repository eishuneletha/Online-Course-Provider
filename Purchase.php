<?php
error_reporting(0);
// session_start();
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
  echo "<script>window.alert('Please Login first to purchase this course')</script>";
  echo "<script>window.location='LearnerLogin.php'</script>";
}

$CourseID=$_REQUEST['cidToBuy'];
$LearnerID=$_SESSION['LID'];

$cselect="SELECT * from courses
        where CourseID=$CourseID ";

$cstmt=$conn->prepare($cselect);
$crun=$cstmt->execute();
$cfetch=$cstmt->fetch($crun);

$ctitle=$cfetch['CourseTitle'];
$cid=$cfetch['CourseID'];
$cprice=$cfetch['Price'];

//////////
$lselect="SELECT * from learners
        where LearnerID=$LearnerID";

$lstmt=$conn->prepare($lselect);
$lrun=$lstmt->execute();
$lfetch=$lstmt->fetch($lrun);

$lname=$lfetch['LearnerName'];





if (isset($_REQUEST['btnbuy'])) {
   $CourseID=$_REQUEST['cid'];
   $LearnerID=$_REQUEST['lid'];
   $PurchaseDate=$_REQUEST['date'];

   $insert="INSERT into purchase (LearnerID, CourseID,PurchaseDate) values (:lid,:cid,:pdate)";
   $stmt=$conn->prepare($insert);
   $stmt->bindParam(":lid",$LearnerID);
   $stmt->bindParam(":cid",$CourseID);
   $stmt->bindParam(":pdate",$PurchaseDate);
   $run=$stmt->execute();

   if($run)
   {
       echo "<script>window.alert('You have successfully purchased this course')</script>";
       echo "<script>location='coursedetail.php?CDetailID=$CourseID'</script>";
   }
   else{
       echo "<script>alert('Something went wrong')</script>";
   }  
}

?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<body>
<head>
    <title>Purchase</title>
</head>

    <section class="registration-area ">
        <div class="container">
            <div class="row " style=" justify-content:center;">


                <div class=" course-form-section col-sm-12  col-md-12  col-lg-8">
                    <h3 class="text-white">CheckOut</h3>



                    <form class="course-form-area contact-page-form course-form " id="myForm" action="" method="POST">

                        <div class=" col-sm-12 col-md-12 col-lg-12" style="color:white; ">
                            <div class="row form-group ">
                                <div class=" col-md-3 col-xs-3" style="padding-top: 15px;padding-bottom:15px ;">Course:</div>

                                <div class="col-md-9  col-xs-9">
                                    <input type="text" readonly class="form-control" id="course" name="ctitle" value="<?php echo $ctitle ?>">
                                    <input type="hidden"  class="form-control " name="cid" value="<?php echo $cid ?>">
                                </div>
                            </div>

                            <div class="row form-group ">
                                <div class=" col-md-3 col-xs-3" style="padding-top: 15px; padding-bottom:15px ;">Price :</div>
                                <div class="col-md-9  col-xs-9">
                                    <input type="text" readonly class="form-control " name="price" value= "$ <?php echo $cprice ?>" >
                                </div>
                            </div>

                            <div class="row form-group ">
                                <div class=" col-md-3 col-xs-3" style="padding-top: 15px; padding-bottom:15px ;">Your Name :</div>
                                <div class="col-md-9  col-xs-9">
                                    <input type="text" readonly class="form-control " name="lname" value="<?php echo $lname ?>">
                                    <input type="hidden"  class="form-control " name="lid" value="<?php echo $LearnerID ?>">
                                </div>
                            </div>

                            <h5 style="color:white; padding-top:15px; padding-bottom:15px; text-align:center">Credit/DebitCard <i class="fas fa-credit-card"></i></h5>
                            <div class="row form-group ">
                                <div class=" col-md-3 col-xs-3" style="padding-top: 15px; padding-bottom:15px ;">Name on the card: <i class="fas fa-credit-card"></i> :</div>
                                <div class="col-md-9  col-xs-9">
                                    <input required type="text" class="form-control " placeholder="Name on the card">
                                </div>
                            </div>

                            <div class="row form-group ">
                                <div class=" col-md-3 col-xs-3" style="padding-top: 15px; padding-bottom:15px ;">Card Number:</div>
                                <div class="col-md-9  col-xs-9">
                                    <td><input class="form-control" type="text" maxlength="16" onkeypress="isInputNumber(event)" placeholder="0000 0000 0000 0000" required></td>
                                </div>
                                <script type="text/javascript">
                                    function isInputNumber(evt) {
                                        var ch = String.fromCharCode(evt.which);

                                        if (!(/[0-9]/.test(ch))) {
                                            evt.preventDefault();
                                        };
                                    }
                                </script>
                            </div>

                            <div class="row form-group ">
                                <div class=" col-md-3 col-xs-3" style="padding-top: 15px; padding-bottom:15px ;">CVV/CVC:</div>
                                <div class="col-md-9  col-xs-9">
                                    <input required type="text" maxlength="4" class="form-control " onkeypress="isInputNumber(event)" placeholder=" Enter the three- or four-digit security number on the front or rear of a payment card.">
                                </div>
                                
                            </div>

                            <div class="row form-group ">
                                <div class=" col-md-3 col-xs-3" style="padding-top: 15px; padding-bottom:15px ;">Expirary Date:</div>
                                <div class="col-md-9  col-xs-9">
                                    <input required type="text" class="form-control "  placeholder="MM/YY">
                                </div>
                                
                            </div>

                            <div class="row form-group ">
                                <div class=" col-md-3 col-xs-3" style="padding-top: 15px; padding-bottom:15px ;">Purchase Date:</div>
                                <div class="col-md-9  col-xs-9">
                                    <input required type="text" readonly name="date" class="form-control " value="<?php echo date('Y-m-d') ?>">
                                </div>
                                
                            </div>








                            <div class="col-lg-12 text-center">

                                <input class="btn text-uppercase" name="btnbuy" type="submit" value="Check Out">
                            </div>



                        </div>
                    </form>

                </div>


            </div>
        </div>

    </section>

    <!-- </section> -->



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