<?php
include('connect.php');
include('header_reg.php');


//img
// $target_dir="userprofile/";
// $target_file=$target_dir.basename($_FILES["userimg"]["name"]);
// $uploadOk=1;

// $imageFileType=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if (isset($_POST['btnsubmit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedpassword = md5($password);
    $dob = $_POST['dob'];

    // $check=getimagesize($_FILES["userimg"]["tmp_name"]);

    $Image = $_FILES['userimg']['name'];
    $folder = "userprofile/";
    $filename = $folder . "_" . $Image;
    $copy = copy($_FILES['userimg']['tmp_name'], $filename);
    if (!$copy) {
        exit('Something went wrong');
    }

    $check = $conn->prepare("SELECT * from learners where Email=:email");
    $check->bindParam(":email", $email);
    $check->execute();

    if ($check->rowCount() > 0) {
        echo "<script>window.alert('Email already exist')</script>";
    } else {
        $insert = "INSERT into learners (LearnerName,Email,Password,DateOfBirth,ProfilePicture) values (:name,:email,:password,:dob,:uimg)";
        $stmt = $conn->prepare($insert);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":dob", $dob);
        $stmt->bindParam(":password", $hashedpassword);
        $stmt->bindParam(":uimg", $filename);
        $run = $stmt->execute();

        if ($run) {
            echo "<script>window.alert('Register Successful')</script>";
            echo "<script>location='LearnerLogin.php'</script>";
        } else {
            echo "<script>window.alert('Something went wrong')</script>";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <section class="registration-area">
        <div class="container">
            <div class="row justify-content-center">

                <div class=" col-lg-10 col-md-12">
                    <div class="course-form-section">
                        <h3 class="text-white">Register for Free</h3>
                        <p class="text-white">It is high time for learning</p>
                        <form class="course-form-area contact-page-form course-form" id="myForm" action="" method="post" enctype="multipart/form-data">

                            <div class=" col-sm-12 col-md-12 col-lg-12" style="color:white; ">
                                <div class=" row form-group col-md-12">

                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Name <i class="fas fa-user"> </i> :
                                    </div>

                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'">
                                    </div>

                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Email <i class="fas fa-envelope"></i> :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Password <i class="fas fa-key"></i> :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Date Of Birth :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="dob" placeholder="Enter Date of birth" onfocus="this.placeholder = ''" onblur="this.placeholder = ''">
                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Profile picture <i class="fas fa-image"></i> :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" name="userimg" placeholder="" onfocus="this.placeholder = ''" onblur="this.placeholder = ''">
                                    </div>
                                </div>


                                <div class="col-lg-12 text-center">
                                    <button class="btn text-uppercase" name="btnsubmit">Register</button>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <p style="padding-top:15px">Already have an account?</p>
                                    <button class="btn text-uppercase"><a href="LearnerLogin.php" style="color:white ;">Login</a></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>