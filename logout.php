<html>
<head>
<title>Logout</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<link rel="icon" href="images/icon.jpg" />
<style>
b
{
	color:#0F0;
}

</style>
</head>
<?php
session_start();
include('functions.php');
?>
<body>
<?php
       $con=connect_db();
	  if(isset($_SESSION['quizid']))
{
	//echo "reached";
	$testid=$_SESSION['quizid'];
	$user=$_SESSION['user'];
	$winner='noquiz';
	$sql="select cont1,cont2,winner from quizzes where testid='$testid'";
	$res=mysqli_query($con,$sql);
	if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to get contestants");</script>';
		 echo mysqli_error($con);
	    }
	while($result=mysqli_fetch_array($res))
	{
		 $p1=$result['cont1'];
		 $p2=$result['cont2'];
		 $winner=$result['winner'];
	}
	if($winner=='')
	{
	if($p1==$user)
	$sql="update quizzes set winner='$p2',hasleft=1 where testid='$testid' ";
	else if($p2==$user)
	$sql="update quizzes set winner='$p1',hasleft=1 where testid='$testid' ";
	$res=mysqli_query($con,$sql);
	if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to update winner list");</script>';
		 echo mysqli_error($con);
	    }
	}
   unset($_SESSION['quizid']);	
   unset($_SESSION['topic']);
	unset($_SESSION['cont1']);
	unset($_SESSION['cont2']);
	unset($_SESSION['time']);	
}

      if(isset($_SESSION['user']))
	  {  	 
	$uname=$_SESSION['user'];
	  $sql="delete from loggedin where uname='$uname'";
	  $res=mysqli_query($con,$sql);
	  if(!$res)
	    {
		 echo '<script><alert>("ERROR :Unable to delete from loggedin users.please try again")</alert></script>';
		 echo mysqli_error($con);
	    }
	   }
	    session_destroy();
		unset($_SESSION['user']);
		include('Header.php');
	//session_unset can be used for resetting a perticuler variable e.g. session_unset($_SESSION['id']); will remove only 'id' index of session other will remain intact but sesssion_destroy will clear all session variables
	//session_unset($_SESSION['id']);
	
?>
 <br/><br/><br/><br/><br/><b><br/><br/><br/><br/><br/><b><center>You have been logged out</b><br>
<button type="button" class="btn btn-link" onClick="window.location.href='index.php'">click here to login</button>
</center>
</body>
</html>