<?php
include('connect.php');
if (isset($_POST['search'])) {
    $response = "";
    // $response2 = "";

    $q = $_REQUEST['q'];

    $casql = "  SELECT CategoryName
                from categories 
                where CategoryName like '%$q%'  
                                ";
    $castmt = $conn->prepare($casql);

    $castmt->execute();
    $cacount = $castmt->rowCount(); //my sqli num rows


    ///////////////////////////////////////
    $cosql = " SELECT ca.CategoryName, co.CourseTitle
                from categories ca, courses co 
                where ca.CategoryID=co.CategoryID
                and  (ca.CategoryName like '%$q%'
                or co.CourseTitle like '%$q%')
                and co.Status=1
                Limit 10";
    $costmt = $conn->prepare($cosql);

    $costmt->execute();
    $cocount = $costmt->rowCount(); //my sqli num rows



    if ($cacount > 0) {
        echo "cacount= ".$cacount;

        $response = "<ul >";
       
        for ($i = 0; $i < $cacount; $i++) {

            $cafetch = $castmt->fetch(PDO::FETCH_BOTH);
            $caname = $cafetch['CategoryName'];
          


            $response .=   "<li id='calist' col-md-6>" . $caname . "</li>";
            
            
           
        }

       

        // $response .= "</ul>";
        
    } 
    if ($cocount > 0) {
        echo "cocount= ".$cocount;
       
        // $response2 = "<ul >";

        for ($i = 0; $i < $cocount; $i++) {
            $cofetch = $costmt->fetch(); //mysqli fetch array
         
            $coname = $cofetch['CourseTitle'];


            $response .=   "<li id='colist' col-md-6>" . $coname . "</li>";
            



        }

        $response .= "</ul>";
    } 



    exit($response);
    // exit($response2);
}

if (isset($_REQUEST['btnsearch'])) {
    $search = $_REQUEST['txtsearch'];
    echo "<script>location='search.php?svalue=$search'</script>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</head>

<style>
    #calist {
        background-color: pink;
        /* padding-left:-100px; */

    }

    #colist {
        background-color: palegreen;

    }

    #response {
        background-color: paleturquoise;
    }
</style>

<body>
    <form action="" method="post">
        <input type="text" placeholder="search" id="searchbox" name="txtsearch" >
        <button name="btnsearch" class="searchbutton">Search</button>
        <div id="response"  ></div>
        
    </form>
    <script>
        $(document).ready(function() {
            $("#searchbox").keyup(function appear() {

                console.log('key up activated');
                var query = $("#searchbox").val();
                var sug=document.getElementById('response');


                if (query.length > 0  ) {
                    sug.style.display='block';
                    $.ajax({
                        url: "searchautocomplete.php",
                        method: "POST",
                        data: {
                            search: 1,
                            q: query
                        },
                        success: function(data) { //if this ajax code is succeeded
                            // console.log(data);
                            $("#response").html(data);


                        },
                        dataType: 'text'
                    });
                }
                else{
                   
                    sug.style.display='none';
                    console.log('no text');
                    
                }

                
            });
            $(document).on('click', 'li', function() {
                var search = $(this).text();
                $("#searchbox").val(search);
                $("#response").html("");
            });

            
        });

        document.addEventListener('click', function hide(event){
            console.log('user clicked: ', event.target);

            const box=document.getElementById('response');

            if (!box.contains(event.target)) {
                box.style.display = 'none';
            }
        });

       

     
    </script>
</body>

</html>