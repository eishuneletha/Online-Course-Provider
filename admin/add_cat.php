<?php
include('header.php');
include('../connect.php');

if (isset($_POST['btnadd'])) {
    $inscat="INSERT into categories(CategoryName) values (:catval)";
    $insstmt=$conn->prepare($inscat);
    $insstmt->bindParam(":catval",$_POST['category']);
    $insstmt->execute();
    // if ($insstmt->execute()) {
    //     echo "<script>window.alert('New Category added')</script>";
    // }
}

if (isset($_GET['catIdToDelete'])) {
    $cattodelete=$_GET['catIdToDelete'];
    $delcat="DELETE from categories where CategoryID=:catidtodel";
    $delstmt=$conn->prepare($delcat);
    $delstmt->bindParam(":catidtodel",$cattodelete);
    $delstmt->execute();
    
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <section class="contact-page-area section-gap">
        <div class="container">

            <div class=" d-flex justify-content-center">

                <div class="col-lg-12 col-sm-12" style="justify-content: center;">
                    <form class="form-area contact-form " id="myForm" action="" method="post">
                        <div class="row" style=" justify-content:center">
                            <div class=" col-xs-10 col-lg-6 form-group">
                                <input name="category" type="text" placeholder="Enter category" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Category'" class="common-input mb-20 form-control" required="" type="text">
                            </div>

                            <div class=" col-xs-2 col-lg-2">
                                <button class="btn" name="btnadd" type="submit">Add Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

           
        </div>

        <div class="d-flex justify-content-center mt-3">
                <table class="table col-10">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Category</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectctstmt=$conn->prepare("SELECT * from categories order by CategoryName asc");
                        $selectctstmt->execute();
                        $datalist=$selectctstmt->fetchAll(PDO::FETCH_ASSOC);
                        if ($selectctstmt->rowCount()==0) {
                            echo "<tr><td colspan='2' style='text-align:center;'>There's no data!</td></tr>";
                        }
                        else {
                            $count=0;
                            foreach ($datalist as $data) {
                                $count++;
                                $cat=$data['CategoryName'];
                                $catid=$data['CategoryID'];
                                echo "
                                <tr>
                                <th>$count</th>
                                <td>$cat</td>
                                <td><a href='add_cat.php?catIdToDelete=$catid'><i class='fas fa-trash-alt'></i></a>
                                </tr>
                                ";

                            }
                        }

                        
                        ?>

                    </tbody>
                </table>
            </div>
    </section>

</body>

</html>