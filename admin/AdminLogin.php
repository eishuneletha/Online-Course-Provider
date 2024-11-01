<?php
include('login_header.php');
include('../connect.php');

if (isset($_SESSION['adminlogin'])) {
  echo "<script>location='AdminLogin.php'</script>";
}

if (isset($_POST['btnlogin'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $md5 = md5($password);

  $Admin = "SELECT * FROM admin
      Where Email=:email
      AND Password=:md5 ";

  $stmt = $conn->prepare($Admin);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':md5', $md5);

  $stmt->execute();   //execute
  $checkcount = $stmt->rowCount();  //row count

  if ($checkcount == 1) {
    echo "<script>window.alert('Welcome Back. Login Successful')</script>";
    echo "<script>window.location='AdminLogin.php'</script>";
    $_SESSION['adminlogin'] = 1;
  } else {
    echo "<script>window.alert('Email or Password Incorrect')</script>";
    echo "<script>window.location='AdminLogin.php'</script>";
  }
}



?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<body>

 

    <section class="registration-area ">
      <div class="container">
        <div class="row " style=" justify-content:center;">


          <div class=" course-form-section col-sm-12  col-md-12  col-lg-8">
            <h3 class="text-white">Admin Login</h3>



            <form class="course-form-area contact-page-form course-form " id="myForm" action="" method="POST">

              <div class=" col-sm-12 col-md-12 col-lg-12" style="color:white; ">
                <div class="row form-group ">
                  <div class=" col-md-3 col-xs-3" style="padding-top: 15px;padding-bottom:15px ;">Email <i class="fas fa-envelope"></i> :</div>

                  <div class="col-md-9  col-xs-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
                  </div>
                </div>

                <div class="row form-group ">
                  <div class=" col-md-3 col-xs-3" style="padding-top: 15px; padding-bottom:15px ;">Password <i class="fas fa-key"></i> :</div>
                  <div class="col-md-9  col-xs-9">
                    <input type="password" class="form-control " id="password" name="password" placeholder="Enter Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">

                  </div>

                </div>




                <div class="col-lg-12 text-center">

                  <input class="btn text-uppercase" name="btnlogin" type="submit" value="Login">
                </div>

              </div>
            </form>

          </div>


        </div>
      </div>

    </section>





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