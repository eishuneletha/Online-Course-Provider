<?php
// session_start();
include('connect.php');
include('header_inst.php');

$LessonID = $_REQUEST['lIdToUpdate'];
$uselect = "SELECT * from lessons where LessonID=$LessonID";
$ustmt = $conn->prepare($uselect);
$ustmt->execute();
$ufetch = $ustmt->fetch();

$LessonTitle = $ufetch['LessonTitle'];
$ldescription = $ufetch['LessonDescription'];
$vfile = $ufetch['VideoFile'];

if (isset($_POST['btnsubmit'])) {

    $ultitle = $_REQUEST['ultitle'];
    $uldescription = $_REQUEST['udes'];
    $ovfile = $_REQUEST['ovfile'];

    $filename = $_FILES['vfile']['name'];

    if ($filename == "") {

        // echo "<script>window.alert('If you're not updating the video, please upload the original video again')</script>";  
        $sql = "UPDATE lessons
                        set LessonTitle=:ultitle, VideoFile=:ovfile, LessonDescription=:uld
                        where LessonID=$LessonID";
        $insertstmt = $conn->prepare($sql);

        $insertstmt = $conn->prepare($sql);


        $insertstmt->bindParam(":ultitle", $ultitle);
        $insertstmt->bindParam(":uld", $uldescription);
        $insertstmt->bindParam(":ovfile", $ovfile);


        if( $insertstmt->execute()){
            echo "<script>window.alert('Lesson uploaded successfully with the original video file')</script>";
            echo "<script>location='instructor_lessons_detail.php?LID=$LessonID'</script>";
        }

        else{
            echo "<script>window.alert('error')</script>";
        }

       


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
        } else if ($_FILES['vfile']['size'] > 500000000) //file shouldn't be larger than 1 megabite
        {

            echo "<script>window.alert('File too large')</script>";
        } else {
            if (move_uploaded_file($file, $destination)) {
                $sql = "UPDATE lessons
                        set LessonTitle=:ultitle, VideoFile=:uvfile, LessonDescription=:uld
                        where LessonID=$LessonID";
                $insertstmt = $conn->prepare($sql);


                $insertstmt->bindParam(":ultitle", $ultitle);
                $insertstmt->bindParam(":uld", $uldescription);
                $insertstmt->bindParam(":uvfile", $filename);


                $insertstmt->execute();

                echo "<script>window.alert('Lesson updated successfully with new video file')</script>";
                echo "<script>location='instructor_lessons_detail.php?LID=$LessonID'</script>";
            } else {
                echo "<script>window.alert('fail to update lesson')</script>";
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
    <title>Lesson Update</title>
</head>

<body>
    <section class="registration-area">
        <div class="container">
            <div class="row justify-content-center">

                <div class=" col-lg-10 col-md-12">
                    <div class="course-form-section">
                        <h3 class="text-white">Update Lessons</h3>
                        <!-- <p class="text-white">It is high time for learning</p> -->
                        <form class="course-form-area contact-page-form course-form" id="myForm" action="" method="post" enctype="multipart/form-data">

                            <div class=" col-sm-12 col-md-12 col-lg-12" style="color:white; ">


                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Lesson Title:
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control" type='text' name="ultitle" value="<?php echo $LessonTitle ?>" placeholder="Enter lesson title">
                                    </div>

                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Original video :
                                    </div>
                                    <div class="col-md-9">
                                        <input readonly type="text" name="ovfile" value="<?php echo $vfile ?>" class="form-control">

                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        new video :
                                    </div>
                                    <div class="col-md-9">
                                        <input  type="file" name="vfile" class="form-control" multiple>

                                    </div>
                                </div>


                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Lesson Description :
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="common-textarea form-control" name="udes" placeholder="Describe details for this lesson"><?php echo $ldescription ?></textarea>

                                    </div>
                                </div>



                                <div class="col-lg-12 text-center">
                                    <button class="btn text-uppercase" name="btnsubmit">Update</button> <br>

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