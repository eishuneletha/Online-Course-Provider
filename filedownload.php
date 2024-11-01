<?php
include('connect.php');

$file = $_GET['file'];
// echo $file;

$fileselect="SELECT * from sections";
$stmt=$conn->prepare($fileselect);
$run=$stmt->execute();

$ffetch=$stmt->fetch();


if ($file == "Uploads/No File Found") {
    echo "<script>alert('File not found!')</script>";
} 
else {    
 
	if(ISSET($_REQUEST['file'])){
		$file = $_REQUEST['file'];
		$query = $conn->prepare("SELECT * FROM `sections` WHERE `SectionMaterial`='$file'");
		$query->execute();
		$fetch = $query->fetch();
 
		header("Content-Disposition: attachment; filename=".$fetch['SectionMaterial']);
		header("Content-Type: application/octet-stream;");
		readfile("sectionmaterials/".$fetch['SectionMaterial']);
	}

}
