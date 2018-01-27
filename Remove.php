<?php
$uname=$_GET['uname'];
include_once('functions.php');
	 $con=connect_db();
	  $sql="delete from loggedin where uname='$uname'";
	  $res=mysqli_query($con,$sql);
	  if(!$res)
	    {
		 echo '<script><alert>("ERROR :Unable to delete from loggedin users.please try again")</alert></script>';
		 echo mysqli_error($con);
	    }
		//echo "done";

?>
