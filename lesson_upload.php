<?php
// session_start();
include('connect.php');
include('header_inst.php');

$SectionID = $_REQUEST['SID'];
$CourseID=$_SESSION['CourseID'];

if (isset($_POST['btnsubmit'])) {
    $sectionid = $_REQUEST['sid'];
    $ltitle = $_REQUEST['ltitle'];
    $ldescription = $_REQUEST['ldescription'];
    $date=$_REQUEST['date'];

    $filename = $_FILES['vfile']['name'];

    if ($filename == "") {
        
            echo "<script>window.alert('Lesson cannot be uploaded without the video file')</script>";            
       
    } else {
        //destination of the file on the server
        $destination = "lessonvideos/" . $filename;

        //get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        //the physical file on a temporary uploads directory on the server
        $file = $_FILES['vfile']['tmp_name'];
        $size = $_FILES['vfile']['size'];

        if (!in_array($extension, ['mp4', 'ts'])) {
            echo "<script>window.alert('Your video must be in mp4 or ts form')</script>";
        } else if ($_FILES['vfile']['size'] >500000000) //file shouldn't be larger than 1 megabite
        {

            echo "<script>window.alert('File too large')</script>";
            
        } else {
            if (move_uploaded_file($file, $destination)) {
                $sql = "INSERT INTO lessons (SectionID, LessonTitle,VideoFile,LessonDescription,UploadDate) values (:sectionid,:ltitle,:filename,:ldescription,:date)";
                $insertstmt = $conn->prepare($sql);

                $insertstmt->bindParam(":sectionid", $sectionid);
                $insertstmt->bindParam(":ltitle", $ltitle);
                $insertstmt->bindParam(":ldescription", $ldescription);
                $insertstmt->bindParam(":filename", $filename);
                $insertstmt->bindParam(":date", $date);

                $insertstmt->execute();

                echo "<script>window.alert('Lesson uploaded successfully')</script>";
                echo "<script>window.location='instructor_section_detail.php?SID=$SectionID'</script>";
            }
            else {
                echo "<script>window.alert('fail to upload section')</script>";
              }
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
    <title>Lesson Upload</title>
</head>

<body>
    <section class="registration-area">
        <div class="container">
            <div class="row justify-content-center">

                <div class=" col-lg-10 col-md-12">
                    <div class="course-form-section">
                        <h3 class="text-white">Upload Lessons</h3>
                        <!-- <p class="text-white">It is high time for learning</p> -->
                        <form class="course-form-area contact-page-form course-form" id="myForm" action="" method="post" enctype="multipart/form-data">

                            <div class=" col-sm-12 col-md-12 col-lg-12" style="color:white; ">
                                <div class=" row form-group col-md-12">

                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Instructor Name:
                                    </div>

                                    <div class="col-md-9">
                                        <?php
                                        $iid = $_SESSION['IID'];
                                        $iselect = "SELECT * from instructors where InstructorID=$iid";
                                        $istmt = $conn->prepare($iselect);
                                        $istmt->execute();
                                        $ifetch = $istmt->fetch();

                                        $iname = $ifetch['InstructorName'];
                                        $insid = $ifetch['InstructorID'];

                                        echo "<input  type='text' class='form-control' value=' $iname' readonly>";
                                        echo "<input type='hidden' name='insid' value='$insid'>";

                                        ?>
                                    </div>

                                </div>

                                <div class=" row form-group col-md-12">

                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Course Title:
                                    </div>

                                    <div class="col-md-9">
                                        <?php
                                        $cselect = "SELECT * from courses where CourseID=$CourseID";
                                        $cstmt = $conn->prepare($cselect);
                                        $cstmt->execute();
                                        $cfetch = $cstmt->fetch();
                                        $ctitle = $cfetch['CourseTitle'];
                                        
                                        ?>
                                        <input readonly type="text" class="form-control" name="ctitle" value="<?php echo $ctitle ?>">
                                        
                                    </div>

                                </div>

                                <div class=" row form-group col-md-12">

                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        SectionTitle:
                                    </div>

                                    <div class="col-md-9">
                                        <?php
                                        $sselect = "SELECT * from sections where SectionID=$SectionID";
                                        $sstmt = $conn->prepare($sselect);
                                        $sstmt->execute();
                                        $sfetch = $sstmt->fetch();
                                        $stitle = $sfetch['SectionTitle'];
                                        $sid = $sfetch['SectionID'];
                                        ?>
                                        <input readonly type="text" class="form-control" name="stitle" value="<?php echo $stitle ?>">
                                        <input type='hidden' name='sid' value='<?php echo $sid ?>'>
                                    </div>

                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Lesson Title:
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control" type='text' name='ltitle' placeholder="Enter lesson title">
                                    </div>

                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Video File(s) for lesson :
                                    </div>
                                    <div class="col-md-9">
                                        <input required type="file" name="vfile" class="form-control" multiple>

                                    </div>
                                </div>


                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Lesson Description :
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="common-textarea form-control" name="ldescription" placeholder="Describe details for this lesson" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"></textarea>

                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Upload Date :
                                    </div>
                                    <div class="col-md-9">
                                        <input readonly type="text" name="date" class="form-control" value="<?php echo date('Y-m-d')?>">

                                    </div>
                                </div>



                                

                                

                                <div class="col-lg-12 text-center">
                                    <button class="btn text-uppercase" name="btnsubmit">Upload</button> <br>

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