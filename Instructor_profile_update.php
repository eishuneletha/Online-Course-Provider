<?php
include('connect.php');
include('header_inst.php');

$InstructorID=$_REQUEST['iIdToUpdate'];
$iselect="SELECT * from instructors where InstructorID=$InstructorID";
$istmt=$conn->prepare($iselect);
$irun=$istmt->execute();
$ifetch = $istmt->fetch($irun);

$iname = $ifetch['InstructorName'];
$iemail = $ifetch['Email'];
$pp = $ifetch['ProfilePicture'];
$about = $ifetch['About'];



if(isset($_POST['btnsubmit']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
   
   
    $about=$_POST['about'];
    


   
    $Image=$_FILES['userimg']['name'];
	$folder="userprofile/";
	$filename=$folder."_".$Image;
	$copy=copy($_FILES['userimg']['tmp_name'],$filename);
	if (!$copy) 
	{
		exit ('Something went wrong');
	}    

    
    
  
        $update="UPDATE instructors 
                Set InstructorName=:name, Email=:email,ProfilePicture=:uimg,About=:about
                Where InstructorID=$InstructorID
                ";
        $stmt=$conn->prepare($update);
        $stmt->bindParam(":name",$name);
        $stmt->bindParam(":email",$email);
       
        $stmt->bindParam(":uimg",$filename);
        $stmt->bindParam(":about",$about);
       
        $run=$stmt->execute();

        if($run)
        {
            echo "<script>window.alert('Instructor Profile update successful')</script>";
            echo "<script>location='instructor_profile.php'</script>";
            
        }
        else{
            echo "<script>alert('Something went wrong')</script>";
        }
    

        
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Register</title>
</head>

<body>
    <section class="registration-area">
        <div class="container">
            <div class="row justify-content-center">

                <div class=" col-lg-10 col-md-12">
                    <div class="course-form-section">
                        <h3 class="text-white">Profile Update</h3>
                        <!-- <p class="text-white">It is high time for learning</p> -->
                        <form class="course-form-area contact-page-form course-form" id="myForm" action="" method="post" enctype="multipart/form-data">

                            <div class=" col-sm-12 col-md-12 col-lg-12" style="color:white; ">
                                <div class=" row form-group col-md-12">

                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Name <i class="fas fa-user"> </i>  :
                                    </div>

                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $iname?>" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'">
                                    </div>

                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Email <i class="fas fa-envelope"></i> :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $iemail ?>" placeholder="Enter Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
                                    </div>
                                </div>                         

                                

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Profile picture: <i class="fas fa-image"></i> :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" name="userimg" placeholder="" onfocus="this.placeholder = ''" onblur="this.placeholder = ''">
                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        About :
                                    </div>
                                    <div class="col-md-9">
                                        <textarea  class="common-textarea form-control" name="about" value="<?php echo $about?>" placeholder="Tell us a lil bit about yourself" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"></textarea>
                                        
                                    </div>
                                </div>                                


                                <div class="col-lg-12 text-center">
                                    <button class="btn text-uppercase" name="btnsubmit">Update</button> <br><br><br>
                                                                       
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