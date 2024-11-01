<?php
// session_start();
include('connect.php');
include('header_inst.php');


$SectionID = $_REQUEST['sIdToUpdate'];
$uselect = "SELECT * from sections where SectionID=$SectionID";
$ustmt = $conn->prepare($uselect);
$ustmt->execute();
$ufetch = $ustmt->fetch();

$SectionTitle = $ufetch['SectionTitle'];
$sdescription = $ufetch['SectionDescription'];
$mfile = $ufetch['SectionMaterial'];


if (isset($_POST['btnsubmit'])) {

    $ustitle = $_REQUEST['stitle'];
    $usdescription = $_REQUEST['sdescription'];

    $filename = $_FILES['umfile']['name'];


    //destination of the file on the server
    $destination = "sectionmaterials/" . $filename;

    //get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    //the physical file on a temporary uploads directory on the server
    $file = $_FILES['umfile']['tmp_name'];
    $size = $_FILES['umfile']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx', 'doc', 'csv'])) {
        echo "<script>window.alert('Your file extension must be .zip,.pdf, .docx,.csv')</script>";
    } else if ($_FILES['umfile']['size'] > 500000000) //file shouldn't be larger than 1 megabite
    {

        echo "<script>window.alert('File too large')</script>";
    } else {
        if (move_uploaded_file($file, $destination)) {
            $sql = "UPDATE sections
                    Set SectionTitle=:stitle,SectionDescription=:sdescription,SectionMaterial=:filename
                    where SectionID=$SectionID";
            $updatestmt = $conn->prepare($sql);

            
            $updatestmt->bindParam(":stitle", $ustitle);
            $updatestmt->bindParam(":sdescription", $usdescription);
            $updatestmt->bindParam(":filename", $filename);

            $updatestmt->execute();

            echo "<script>window.alert('Section updated successfully with a file')</script>";
            echo "<script>location='instructor_section_detail.php?SID=$SectionID'</script>";
        } else {
            echo "<script>window.alert('fail to upload section')</script>";
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
    <title>Section Update</title>
   
</head>
<style>
    input[type="file"]{
        display: none;
    }

    label{
        color: white;
        height: 40px;
        width: 150px;
        background: linear-gradient(to right, #7c32ff 0%, #c738d8);
        /* font-size: 20px; */
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<body>
    <section class="registration-area">
        <div class="container">
            <div class="row justify-content-center">

                <div class=" col-lg-10 col-md-12">
                    <div class="course-form-section">
                        <h3 class="text-white">Update section</h3>
                        <!-- <p class="text-white">It is high time for learning</p> -->
                        <form class="course-form-area contact-page-form course-form" id="myForm" action="" method="post" enctype="multipart/form-data">

                            <div class=" col-sm-12 col-md-12 col-lg-12" style="color:white; ">
                                
                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Section Title:
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control" type='text' name='stitle' value="<?php echo $SectionTitle ?>">
                                    </div>

                                </div>




                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Section Description :
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="common-textarea form-control" name="sdescription" ><?php echo $sdescription ?></textarea>

                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Original File:
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" readonly name="" class="form-control" value="<?php echo $mfile ?>">

                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Update material :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" name="umfile" class="form-control" id="file" multiple>
                                        <label for="file">
                                        <i class="fas fa-upload" style="margin-right: 10px;"></i>Choose a file
                                        </label>
                                        <br>
                                        <p style="color:red"> if you're not updating the matieral file, please reupload the original material file from your device</p>
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