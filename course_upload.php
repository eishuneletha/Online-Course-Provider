<?php
include('connect.php');
include('header_inst.php');

if (isset($_POST['btnsubmit'])) {
    $instructorid = $_REQUEST['insid'];
    $ctitle=$_REQUEST['title'];
    $slvl=$_REQUEST['slvl'];
    $cid=$_REQUEST['category'];
    $price=$_REQUEST['price'];
    $des=$_REQUEST['description'];
    $outcomes=$_REQUEST['outcomes'];
    $language=$_REQUEST['language'];
    $date='0000-00-00';

    $status = 0;
    $date = '0000-00-00';

    $Image = $_FILES['timg']['name'];
    $folder = "coursethumbnail/";
    $filename = $folder . "_" . $Image;
    $copy = copy($_FILES['timg']['tmp_name'], $filename);
    if (!$copy) {
        exit('Something went wrong');
    }

    $insert="INSERT INTO courses(CategoryID,InstructorID,CourseTitle,SkillLevel,ThumbnailPicture,Price, Description,Outcomes,LanguageUsed, Status, PublishedDate) values(:cid,:instructorid,:ctitle,:slvl,:timg,:price,:des,:outcomes,:lang,:status,:date)";
    $stmt=$conn->prepare($insert);
    $stmt->bindParam(":cid",$cid);
    $stmt->bindParam(":instructorid",$instructorid);
    $stmt->bindParam(":ctitle",$ctitle);
    $stmt->bindParam(":slvl",$slvl);
    $stmt->bindParam(":timg",$filename);
    $stmt->bindParam(":price",$price);
    $stmt->bindParam(":des",$des);
    $stmt->bindParam(":outcomes",$outcomes);
    $stmt->bindParam(":lang",$language);
    $stmt->bindParam(":status",$status);
    $stmt->bindParam(":date",$date);

    $run=$stmt->execute();

    if($run)
    {
        echo "<script>window.alert('Your course has been submitted. It will be published on the site within 2 or 3 business days')</script>";
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
    <title>Course Upload</title>
</head>

<body>
    <section class="registration-area">
        <div class="container">
            <div class="row justify-content-center">

                <div class=" col-lg-10 col-md-12">
                    <div class="course-form-section">
                        <h3 class="text-white">Upload Course</h3>
                        <!-- <p class="text-white">It is high time for learning</p> -->
                        <form class="course-form-area contact-page-form course-form" id="myForm" action="" method="post" enctype="multipart/form-data">

                            <div class=" col-sm-12 col-md-12 col-lg-12" style="color:white; ">
                                <div class=" row form-group col-md-12">

                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Instructor Name:
                                    </div>

                                    <div class="col-md-9">
                                        <?php
                                            $iid=$_SESSION['IID'];
                                            $iselect="SELECT * from instructors where InstructorID=$iid";
                                            $istmt=$conn->prepare($iselect);
                                            $istmt->execute();
                                            $ifetch=$istmt->fetch();

                                            $iname=$ifetch['InstructorName'];
                                            $insid=$ifetch['InstructorID'];

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
                                        <input type="text" class="form-control"  name="title" placeholder="Enter title of the course" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'">
                                    </div>

                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Skill Level:
                                    </div>
                                    <div class="col-md-9">
                                        <select name="slvl" id="" class="dropdown-item" required>
                                            <option value="Beginner">Beginner</option>
                                            <option value="Advanced">Advanced</option>
                                            <option value="AllLevel">All level</option>
                                        </select>

                                        <p style="color: red;">Select required skill level for this course</p>
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





                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Thumbnail picture for the course :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" name="timg" placeholder="" onfocus="this.placeholder = ''" onblur="this.placeholder = ''">
                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Price $:
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" id="price" name="price" min="0" placeholder="Set price for the course">
                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Description :
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="common-textarea form-control" name="description" placeholder="Describe about your course" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"></textarea>

                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Outcomes :
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="common-textarea form-control" name="outcomes" placeholder="Describe learning outcomes of this course" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"></textarea>

                                    </div>
                                </div>

                                <div class="row form-group col-md-12">
                                    <div class="col-md-3" style="padding-top: 15px;padding-bottom:15px ;">
                                        Language :
                                    </div>
                                    <div class="col-md-9">
                                        <input type="language" class="form-control" name="language" placeholder="language used in this course">

                                    </div>
                                </div>






                                <div class="col-lg-12 text-center">
                                    <button class="btn text-uppercase" name="btnsubmit">Submit</button> <br>

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