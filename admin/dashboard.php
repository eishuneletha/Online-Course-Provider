<?php
include('../connect.php');
include('header.php');
$cselect = "SELECT * from categories ";
$cstmt = $conn->prepare($cselect);
$cstmt->execute();

$clist = $cstmt->fetchAll();


//Who are you?

$adminId = $_SESSION['adminlogin'];
$selectadmin = $conn->prepare("SELECT * from admin where AdminID=$adminId");
$selectadmin->execute();
$selectname = $selectadmin->fetch();
$name = $selectname['AdminName'];
$email = $selectname['Email'];
$type = "Admin";

//upload numbers
foreach ($clist as $list) {
    $cat = $list['CategoryName'];
    $selectdata = "SELECT count(*) from courses co, categories ca
                where co.CategoryID=ca.CategoryID
                and ca.CategoryName='$cat'";

    $stmt = $conn->prepare($selectdata);
    $stmt->execute();
    $countcourse = $stmt->fetch();

    $numbers[] = $countcourse[0];
    $showcat[] = $cat;
}


//purchase numbers
foreach ($clist as $value) {
    $cat = $value['CategoryName'];
    $data = "SELECT count(*) from purchase p,courses co, categories ca
                where co.CategoryID=ca.CategoryID
                and co.CourseID=p.CourseID
                and ca.CategoryName='$cat'";

    $stmt = $conn->prepare($data);
    $stmt->execute();
    $countpurchase = $stmt->fetch();

    $pnumber[] = $countpurchase[0];
    $categories[] = $cat;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js"></script> -->
    <title>Document</title>
</head>
<script>
  setInterval(showTime, 1000);

  function showTime() {
    let time = new Date();
    let hour = time.getHours();
    var title_text = "";
    if (hour < 12) {
      title_text = "Good Morning, ";
    } else if (hour >= 12 && hour < 17) {
      title_text = "Good Afternoon, ";
    } else if (hour >= 17 && hour < 19) {
      title_text = "Good Evening, ";
    } else if (hour >= 19) {
      title_text = "Good Night, ";
    }
    document.getElementById("titleText").innerHTML = title_text + "<?php echo $name; ?>";
  }
</script>


<body>
    <section class="section-gap container">
        <div class="container">
            <div class="container-fluid px-4">
                <h2 class="mt-4" id="titleText"></h2>
                <br><br>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active text-dark">Login as : &nbsp;<b><?php echo $email; ?></b>, Account Type : &nbsp;<b><?php echo $type; ?></b></li>
                </ol>
            </div>


                <!-- bar+pie1-->
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Bar chart for Categories uploaded
                            </div>
                            <div class="card-body"><canvas id="bar1" width="100%" height="100"></canvas></div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-pie me-1"></i>
                                Pie chart for categories uploaded
                            </div>
                            <div class="card-body"><canvas id="pie1" width="100%" height="100"></canvas></div>
                        </div>
                    </div>
                </div>


                <!-- bar+pie2  -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Bar for purchase
                            </div>
                            <div class="card-body"><canvas id="bar2" width="100%" height="100"></canvas></div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-pie me-1"></i>
                                Pie for purchase
                            </div>
                            <div class="card-body"><canvas id="pie2" width="100%" height="100"></canvas></div>
                        </div>
                    </div>
                </div>




                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <script>
                    const ctx = document.getElementById('bar1');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode($showcat); ?>,
                            datasets: [{
                                label: 'Number of courses',
                                data: <?php echo json_encode($numbers); ?>, //number

                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(98, 13, 192, 0.2)',
                                    'rgba(19, 102, 255, 0.2)',
                                    'rgba(29, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],

                                borderWidth: 1
                            }]
                        },

                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    //pie1
                    const ctx2 = document.getElementById('pie1');

                    new Chart(ctx2, {
                        type: 'pie',
                        data: {
                            labels: <?php echo json_encode($showcat); ?>,
                            datasets: [{
                                label: 'Number of courses',
                                data: <?php echo json_encode($numbers); ?>, //number

                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(98, 13, 192, 0.2)',
                                    'rgba(19, 102, 255, 0.2)',
                                    'rgba(29, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],

                                borderWidth: 1
                            }]
                        },

                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>




                <script>
                    const bar2 = document.getElementById('bar2');

                    new Chart(bar2, {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode($categories); ?>,
                            datasets: [{
                                label: 'Number of purchases',
                                data: <?php echo json_encode($pnumber); ?>, //number

                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(98, 13, 192, 0.2)',
                                    'rgba(19, 102, 255, 0.2)',
                                    'rgba(29, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],

                                borderWidth: 1
                            }]
                        },

                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    const pie2 = document.getElementById('pie2');

                    new Chart(pie2, {
                        type: 'pie',
                        data: {
                            labels: <?php echo json_encode($categories); ?>,
                            datasets: [{
                                label: 'Number of purchases',
                                data: <?php echo json_encode($pnumber); ?>, //number

                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(98, 13, 192, 0.2)',
                                    'rgba(19, 102, 255, 0.2)',
                                    'rgba(29, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],

                                borderWidth: 1
                            }]
                        },

                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>

            </div>

    </section>
</body>

</html>