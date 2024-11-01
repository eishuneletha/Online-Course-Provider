<?php
include('../connect.php');
include('header.php');


if (isset($_GET["iIdToAccept"])) {
    
    $updateStatusStmt = $conn->prepare("UPDATE instructors
                                         set status=?, InstructorSince=CURRENT_DATE
                                         where InstructorID=?");
    $updateStatusStmt->bindValue(1, TRUE);
    // $updateStatusStmt->bindParam(':dateaccount', $date);
    $updateStatusStmt->bindParam(2, $_GET['iIdToAccept']);
    if ($updateStatusStmt->execute()) {
        echo "<script>alert(' Success permitting!')</script>";
        echo "<script>location='InstructorManage.php'</script>";
       
    } else {
        echo "<script>alert('Error in permitting!')</script>";
    }
    // $updateStatusStmt->execute();
    // echo $date;
}

if (isset($_GET["iIdToDelete"])) {
    $iIdToDelete = $_GET["iIdToDelete"];
    echo "<script>
    if(confirm('Are you sure to delete this account?')==true){
    location='instructordelete.php?iIdToDelete=$iIdToDelete';
    }else{
    location='InstructorManage.php';
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <title>Document</title>
</head>

<body>
    <section class="section-gap container">
        
       
            <div class=" table-responsive ">
                <table id="example" class=" table table-striped table-bordered " style="width: 100%;">
                    <thead>
                        <tr class="">
                            <th >No</th>
                            <th >Profile Picture</th>
                            <th >Instructor Name</th>
                            <th >Email</th>
                            <th style="text-align:center">About the instructor</th>   
                            <th>Interested Categories</th>                         
                            <th >Status</th>
                            <th >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectctstmt = $conn->prepare("SELECT * from instructors");
                        $selectctstmt->execute();
                        $datalist = $selectctstmt->fetchAll(PDO::FETCH_ASSOC);
                        $count = 0;
                        foreach ($datalist as $data) {
                            $count++;
                            $iid = $data['InstructorID'];
                            echo "<tr >";
                            echo "<td>$count</td>";
                            echo "<td> <img style='width:60px; border-radius: 50%;  margin-top:0px' src='../" . $data['ProfilePicture'] . "'></td>";
                            echo "<td>" . $data['InstructorName'] . "</td>";
                            echo "<td > " . $data['Email'] . "</td>";
                            echo "<td  style='line-break:auto' > " . $data['About'] . "</td>";
                            echo "<td > " . $data['Interestedcategories'] . "</td>";
                            
                            if ($data['status'] == 0) {
                                echo "<td style='color:green;'>Requested</td>";
                                echo "<td><a href='InstructorManage.php?iIdToAccept=$iid' class='btn btn-success mb-2'>Accept</a><br>
                                        <a href='InstructorManage.php?iIdToDelete=$iid' class='btn btn-danger'>Deny</a></td>";
                            } else {
                                echo "<td>Accepted</td>";
                                echo "<td><a href='InstructorManage.php?iIdToDelete=$iid' class='actionlink'><i class='fas fa-trash'></i>&nbsp;&nbspDelete</a>
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
<script>
    $(document).ready(function () {
    $('#example').DataTable();
});
</script>

</html>