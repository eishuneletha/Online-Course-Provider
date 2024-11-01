<?php
include('connect.php');
include('header_inst.php');

$CourseID = $_REQUEST['cidToUpdate'];
$uslct = "SELECT co.*, ca.*
         from Courses CO, Categories ca
        where CourseID=$CourseID";
$ustmt = $conn->prepare($uslct);
$ustmt->execute();
$ufetch = $ustmt->fetch();

$Ctitle = $ufetch['CourseTitle'];
$Skill = $ufetch['SkillLevel'];
$tpic = $ufetch['ThumbnailPicture'];
$cprice = $ufetch['Price'];
$cdesc = $ufetch['Description'];
$coutcomes = $ufetch['Outcomes'];
$clang = $ufetch['LanguageUsed'];



if (isset($_POST['btnsubmit'])) {

    $ctitle = $_REQUEST['title'];
    $slvl = $_REQUEST['slvl'];
    $cid=$_REQUEST['category'];

    $price = $_REQUEST['price'];
    $des = $_REQUEST['description'];
    $outcomes = $_REQUEST['outcomes'];
    $language = $_REQUEST['language'];

    $Image = $_FILES['timg']['name'];
    $folder = "coursethumbnail/";
    $filename = $folder . "_" . $Image;
    $copy = copy($_FILES['timg']['tmp_name'], $filename);
    if (!$copy) {
        exit('Something went wrong');
    }




    $update = "UPDATE courses
                set CourseTitle=:ctitle,
                CategoryID=:cid,
                SkillLevel=:slvl,
                Price=:price,
                Description=:des,
                Outcomes=:outcomes,
                LanguageUsed=:lang,
                ThumbnailPicture=:timg
                where CourseID=$CourseID";
    $stmt = $conn->prepare($update);

    $stmt->bindParam(":cid",$cid);
    $stmt->bindParam(":ctitle", $ctitle);
    $stmt->bindParam(":slvl", $slvl);
    $stmt->bindParam(":timg", $filename);
    $stmt->bindParam(":price", $price);
    $stmt->bindParam(":des", $des);
    $stmt->bindParam(":outcomes", $outcomes);
    $stmt->bindParam(":lang", $language);

    $run = $stmt->execute();

    if ($run) {
        echo "<script>window.alert('Course successfully updated')</script>";
        echo "<script>location='instructor_course_detail.php?CID=$CourseID'</script>";
    } else {
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
    <title>Course Upload</title>
</head>

<body>
    <section class="registration-area">
        <div class="container">
            <div class="row justify-content-center">

                <div class=" col-lg-10 col-md-12">
                    <div class="course-form-section">
                        <h3 class="text-white">Update Course</h3>
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


                                        ?>
                                    </div>

                                </div>
                                <div class=" row form-group col-md-12">

                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        CourseTitle:
                                    </div>

                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="title" value="<?php echo $Ctitle ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'">
                                    </div>

                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Category:
                                    </div>
                                    <div class="col-md-9">

                                        <select name="category" id="" class="dropdown-item" required>
                                            <?php
                                            $cselect = "SELECT * from categories";
                                            $cstmt = $conn->prepare($cselect);
                                            $cstmt->execute();

                                            $ccount = $cstmt->rowCount();

                                            for ($i = 0; $i < $ccount; $i++) {
                                                $cfetch = $cstmt->fetch(PDO::FETCH_BOTH);
                                                $cid = $cfetch['CategoryID'];
                                                $cname = $cfetch['CategoryName'];

                                                echo "<option value='$cid'>$cname</option>";
                                            }
                                            ?>


                                        </select>

                                        <p style="color: red;">Select category for this course</p>
                                    </div>

                                </div>

                                <div class=" row form-group col-md-12">

                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Current Skill level:
                                    </div>

                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" name="" value="<?php echo $Skill ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'">
                                    </div>

                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Update Skill Level:
                                    </div>
                                    <div class="col-md-9">

                                        <select name="slvl" id="" class="dropdown-item" required>
                                            <option value="Beginner">Beginner</option>
                                            <option value="Advanced">Advanced</option>
                                            <option value="AllLevel">All level</option>
                                        </select>


                                    </div>

                                </div>
                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Thumbnail picture for the course :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" name="timg" placeholder="" onfocus="this.placeholder = ''" onblur="this.placeholder = ''">
                                        <p style="color:red">* if you are not going to update the thumbnail picture, please upload the original picture again</p>
                                    </div>
                                </div>







                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Price $:
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" id="price" name="price" min="0" value="<?php echo $cprice ?>" placeholder="Set price for the course">
                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Description :
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="common-textarea form-control" name="description" value="<?php echo $cdesc ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"></textarea>

                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Outcomes :
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="common-textarea form-control" name="outcomes" value="<?php echo $coutcomes ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"></textarea>

                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Language :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="language" class="form-control" name="language" value="<?php echo $clang ?>">

                                    </div>
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