<?php

include_once('functions.php');
	 $con=connect_db();
$uname=$_GET['uname'];
$sql="select * from loggedin where uname='$uname'";
     $res=mysqli_query($con,$sql);
	  if(!$res)
	    {
		 echo "ERROR :Unable to check from loggedin users.please try again";
		 echo mysqli_error($con);
	    }
	 if(mysqli_num_rows($res)==0)
{
 $sql="insert into loggedin values ('$uname')";
	  $res=mysqli_query($con,$sql);
	  if(!$res)
	    {
		 echo "ERROR :Unable to insert into loggedin users.please try again";
		 echo mysqli_error($con);
	    }
}
else
{
	echo 'duplicates';
}
?>
