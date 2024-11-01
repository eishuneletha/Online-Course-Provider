<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c8fd1d96f9.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <div align="center" style="background-color: black; padding: 50px">
        <i class="fas fa-star fa-2x" data-index="0"></i>
        <i class="fas fa-star fa-2x" data-index="1"></i>
        <i class="fas fa-star fa-2x" data-index="2"></i>
        <i class="fas fa-star fa-2x" data-index="3"></i>
        <i class="fas fa-star fa-2x" data-index="4"></i>
    </div>

    <script>
        var ratedIndex = -1;


        $(document).ready(function() {
            resetStarColors();

            if (localStorage.getItem('ratedIndex') != null) {
                setStars(parseInt(localStorage.getItem('ratedIndex')));
            }


            $('.fa-star').on('click', function() {
                ratedIndex = parseInt($(this).data('index'));
                localStorage.setItem('ratedIndex', ratedIndex);
                saveToDB();
            });

            $('.fa-star').mouseover(function() {
                resetStarColors();

                var currentIndex = parseInt($(this).data('index'));

                setStars(currentIndex);
            });

            $('.fa-star').mouseleave(function() {
                resetStarColors();
                if (ratedIndex != -1) {
                    setStars(ratedIndex);
                }
            });
        });

        function saveToDB() {
            $.ajax({
                url:"coursedetail.php",
                method:"POST",
                dataType:"json",
                data:{
                    save:1,
                    ratedIndex: ratedIndex,
                },
                // success: function (r){

                // }

            })
        }

        function setStars(max) {
            for (var i = 0; i <= max; i++) {
                $('.fa-star:eq(' + i + ')').css('color', 'green');
            }
        }

        function resetStarColors() {
            $('.fa-star').css('color', 'white');
        }
    </script>
</body>

</html>


<p> Rating: <?php echo $value['Scale'] ?> / 5 </p>