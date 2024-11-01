<?php
include('connect.php');

$courseid=$_REQUEST['cidToDelete'];
$cdelete="DELETE from c.courses, s.sections,l.lessons
 where c.CourseID=s.CourseID
 and s.SectionID=l.SectionID
 and CourseID='$courseid'";

$stmt=$conn->prepare($cdelete);
$run=$stmt->execute();
if ($run) {
    echo "<script>window.alert('Deleted successful')</script>";
    echo "<script>ocation='instructor_courses.php'</script>";
}
else 
	{
		echo "<script>window.alert('Something went wrong')</script>";

	}



?>