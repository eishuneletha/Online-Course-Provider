<?php
// session_start();
include('connect.php');
include('header_inst.php');


$CourseID = $_REQUEST['CID'];

if (isset($_POST['btnsubmit'])) {
    $courseid = $_REQUEST['coid'];
    $stitle = $_REQUEST['stitle'];
    $sdescription = $_REQUEST['sdescription'];

    $filename = $_FILES['mfile']['name'];

    if ($filename == "") {
        $sql = "INSERT INTO sections (CourseID, SectionTitle,SectionDescription,SectionMaterial) values (:courseid,:stitle,:sdescription,null)";
        $insertstmt = $conn->prepare($sql);
        $insertstmt->bindParam(":courseid", $courseid);
        $insertstmt->bindParam(":stitle", $stitle);
        $insertstmt->bindParam(":sdescription", $sdescription);

        if ($insertstmt->execute()) {
            echo "<script>window.alert('Section uploaded successfully without file')</script>";
            echo "<script>location='instructor_course_detail.php?CID=$CourseID'</script>";
        } else {
            echo var_dump($insertstmt->errorInfo());
        }
    } else {
        //destination of the file on the server
        $destination = "sectionmaterials/" . $filename;

        //get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        //the physical file on a temporary uploads directory on the server
        $file = $_FILES['mfile']['tmp_name'];
        $size = $_FILES['mfile']['size'];

        if (!in_array($extension, ['zip', 'pdf', 'docx', 'doc','csv'])) {
            echo "<script>window.alert('Your file extension must be .zip,.pdf, .docx,.csv')</script>";
        } else if ($_FILES['mfile']['size'] > 500000000) //file shouldn't be larger than 1 megabite
        {

            echo "<script>window.alert('File too large')</script>";
            
        } else {
            if (move_uploaded_file($file, $destination)) {
                $sql = "INSERT INTO sections (CourseID, SectionTitle,SectionDescription,SectionMaterial) values (:courseid,:stitle,:sdescription,:filename)";
                $insertstmt = $conn->prepare($sql);

                $insertstmt->bindParam(":courseid", $courseid);
                $insertstmt->bindParam(":stitle", $stitle);
                $insertstmt->bindParam(":sdescription", $sdescription);
                $insertstmt->bindParam(":filename", $filename);

                $insertstmt->execute();

                echo "<script>window.alert('Section uploaded successfully with a file')</script>";
                echo "<script>window.location=instructor_course_detail.php?CID=$CourseID</script>";
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
    <title>Section Upload</title>
</head>

<body>
    <section class="registration-area">
        <div class="container">
            <div class="row justify-content-center">

                <div class=" col-lg-10 col-md-12">
                    <div class="course-form-section">
                        <h3 class="text-white">Upload section</h3>
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
                                        CourseTitle:
                                    </div>

                                    <div class="col-md-9">
                                        <?php
                                        $coselect = "SELECT * from courses where CourseID=$CourseID";
                                        $costmt = $conn->prepare($coselect);
                                        $costmt->execute();
                                        $cofetch = $costmt->fetch();
                                        $cotitle = $cofetch['CourseTitle'];
                                        $coid = $cofetch['CourseID'];
                                        ?>
                                        <input readonly type="text" class="form-control" name="title" value="<?php echo $cotitle ?>">
                                        <input type='hidden' name='coid' value='<?php echo $coid ?>'>
                                    </div>

                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Section Title:
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control" type='text' name='stitle' placeholder="Enter section title">
                                    </div>

                                </div>




                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Section Description :
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="common-textarea form-control" name="sdescription" placeholder="Describe details for section" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"></textarea>

                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Material File(s) for section :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" name="mfile" class="form-control" multiple>
                                        <p style="color:red; padding-top:15px">* To upload more than one material files, please upload those files in ZIP Form</p>

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