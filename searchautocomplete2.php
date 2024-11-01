<?php
  $casql = "  SELECT CategoryName
            from categories
                  ";
 $castmt = $conn->prepare($casql);

 $castmt->execute();
 $cafetch = $castmt->fetch(PDO::FETCH_BOTH);//mysqli fetch array

 while ($row=$cafetch) {
   $caarray[]=$row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/c8fd1d96f9.js" crossorigin="anonymous"></script>
</head>
<style>
    /* .icon{
        top:0;
        position: absolute;
    } */

    .search-input{
        background-color: lightblue;
    }

    .search-input .autocom-box{
        opacity: 0;
        pointer-events: none;
    }

    .autocom-box li{
        display: none;
    }
</style>
<body>
    <div class="wrapper">
        <div class="search-input">
            <input type="text" placeholder="search here">
            <div class="icon"><i class="fas fa-search"></i></div>
            <div class="autocom-box">
                <li>ose9ruoew</li>
            </div>
           
        </div>

    </div>
    <script>
         var obj = <?php echo json_encode($caarray); ?>;
        let suggestions=[

        ];
    </script>
</body>
</html>