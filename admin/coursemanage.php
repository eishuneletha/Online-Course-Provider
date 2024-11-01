<?php
include('../connect.php');
include('header.php');


if (isset($_GET["cIdToAccept"])) {
    
    $updateStatusStmt = $conn->prepare("UPDATE courses
                                         set status=?, PublishedDate=CURRENT_DATE
                                         where CourseID=?");
    $updateStatusStmt->bindValue(1, TRUE);
    // $updateStatusStmt->bindParam(':dateaccount', $date);
    $updateStatusStmt->bindParam(2, $_GET['cIdToAccept']);
    if ($updateStatusStmt->execute()) {
        echo "<script>alert('The course had been published!')</script>";
        echo "<script>location='coursemanage.php'</script>";
       
    } else {
        echo "<script>alert('Error in permitting!')</script>";
    }
    // $updateStatusStmt->execute();
    // echo $date;
}

if (isset($_GET["cIdToDelete"])) {
    $cIdToDelete = $_GET["cIdToDelete"];
    echo "<script>
    if(confirm('Are you sure to delete this course?')==true){
    location='coursedelete.php?cIdToDelete=$cIdToDelete';
    }else{
    location='coursemanage.php';
    }
    </script>";
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course manage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
</head>

<body>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
    <section class="section-gap container">
        
       
            <div class=" table-responsive ">
                <table id="example" class=" table table-striped table-bordered" style="width: 100%;">
                    <thead>
                        <tr class="">
                            <th>No</th>
                            <th >Course Title</th>
                            <th >Category</th>
                            <th >Instructor Name</th>
                            <th >Skill Level</th>
                            <th >Thumbnail Picture</th>
                            <th >Price</th>
                            <th style="text-align:center">________Description_of_the_course________       </th>   
                            <th>_________Learning_Outcomes_________</th>         
                            <th>Language_Used</th>                                            
                            <th >Status</th>
                            <th >__Action___</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectctstmt = $conn->prepare("SELECT co.*,ins.InstructorName ,ca.CategoryName
                                                        from courses co, instructors ins, categories ca
                                                        where co.CategoryID=ca.CategoryID
                                                        and co.InstructorID=ins.InstructorID 
                                                    ");
                        $selectctstmt->execute();
                        $datalist = $selectctstmt->fetchAll(PDO::FETCH_ASSOC);
                        $count = 0;
                        foreach ($datalist as $data) {
                            $count++;
                            $cid = $data['CourseID'];
                            echo "<tr scope='row' >";
                            echo "<td>$count</td>";
                            
                            echo "<td>" . $data['CourseTitle'] . "</td>";
                            echo "<td > " . $data['CategoryName'] . "</td>";
                            echo "<td > " . $data['InstructorName'] . "</td>";
                            echo "<td > " . $data['SkillLevel'] . "</td>";
                            echo "<td> <img style='max-width:100px; max-height:70px border-radius: 0%;  margin-top:0px' src='../" . $data['ThumbnailPicture'] . "'></td>";
                            echo "<td > " . $data['Price'] . "</td>";
                            echo "<td > " . $data['Description'] . "</td>";
                            echo "<td > " . $data['Outcomes'] . "</td>";
                            echo "<td > " . $data['LanguageUsed'] . "</td>";
                            
                            
                            if ($data['Status'] == 0) {
                                echo "<td style='color:green;'>Requested</td>";
                                echo "<td><a href='coursemanage.php?cIdToAccept=$cid' class='btn btn-success mb-2'>Accept</a><br>
                                        <a href='coursemanage.php?cIdToDelete=$cid' class='btn btn-danger'>Deny</a></td>";
                            } else {
                                echo "<td>Published</td>";
                                echo "<td><a href='coursemanage.php?cIdToDelete=$cid' class='actionlink'><i class='fas fa-trash'></i>&nbsp;&nbspDelete</a>
                                <br>
                                ";
                              
                            }

                            echo "</tr>";
                        }



                        ?>
                            
                                    

                    </tbody>
                </table>
            
           
        </div>
    </section>
</body>

</html>