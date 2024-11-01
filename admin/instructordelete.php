<?php
  include '../connect.php';

  $id=$_GET['iIdToDelete'];

  $stmt=$conn->prepare("delete from instructors where InstructorID=?");
  $stmt->bindValue(1,$id);
  $stmt->execute();

  echo "<script>location='InstructorManage.php'</script>";
 ?>