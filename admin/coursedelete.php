<?php
  include '../connect.php';

  $cid=$_REQUEST['cIdToDelete'];

  $stmt=$conn->prepare("DELETE  c.*,s.*,l.*
                        from courses c, sections s, lessons l                       
                       where s.CourseID=c.CourseID
                       and l.SectionID=s.SectionID
                       and c.CourseID=$cid");

  // $stmt=$conn->prepare("DELETE c, s,l
  //                       FROM courses b
  //                       INNER JOIN sections s
  //                         ON b.id = v.birthdays_id
  //                       WHERE b.date = 1976-09-28");
  $run=$stmt->execute();

  if($run)
  {
    echo "<script>alert('The course had been deleted!')</script>";
    echo "<script>location='coursemanage.php'</script>";
  }

  else{
    echo "<script>alert('Something went wrong')</script>";
  }
 
 ?>