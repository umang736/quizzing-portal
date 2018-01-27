<?php
  session_start();
include_once('functions.php');

if(!isset($_SESSION['user']))
{
palert('please login first','./index.php');
die();
}

$con=connect_db();
include('Header.php');
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Messages</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="scriptforchatting.js"></script>
<script type="text/javascript" src="scriptforsearching.js"></script>
<style type="text/css">
option{
font-weight:bold;
color:#063;
}
.look{
border-radius:20px;
box-shadow:10px 10px 10px black;
color:#03C;
}

#listen {list-style:none; text-decoration:none;}

</style>
</head>

<body>
<!--
<div id="demo2"></div>
<div id="demo"></div>
<div id="demo1"></div>
-->

<!--
<div class="form-group col-sm-offset-4" style="margin-top:10%">
<label for="userfield" class="col-sm-1 control-label">Search</label>
<div class="col-sm-4 input-group">
<span class="glyphicon glyphicon-user input-group-addon"></span>
<input type="text" name="userfield" id="userfield" />
</div>
</div>
-->
<div class="container-fluid " style="margin-top:10%" >
<div class="row">

<div class="col-sm-2">
<label for="userfield" class="control-label">Search People</label>
<div class="input-group">
<span class="glyphicon glyphicon-user input-group-addon"></span>
<input type="text" name="userfield" id="userfield" onkeyup="func()" />
</div>
<ul id="listen">

</ul>
</div>

<div class="col-sm-8  col-sm-offset-2 well" style="position:fixed;">
<textarea class=" form-control look"  id="reply" rows="19" spellcheck="false"></textarea>
<br /> 

                     <label class="control-label col-sm-2" for="content"  style="font-size:large">Message:</label>
                        <div class="col-sm-8 input-group">
                           <span class="glyphicon glyphicon-envelope input-group-addon"></span>
                           <input type="text" required="required" id="content" class="form-control" name="content" placeholder="Message" />
      
      </div>
      <div class=" col-sm-offset-11" style=" position:fixed; bottom:45px; right:23%;"
>             <button type="button" class="btn  btn-info " name="send" onclick="sendmesg()" >
                            Send
                            </button>          
                  </div>
    </div>

<div class="col-sm-2 col-sm-offset-10" style="position:fixed;" >
<center>
<label class="label label-warning" style="font-size:12px">Online</label>
</center>
<select id="people" size="28" style="width:210px;"   >
</select>

<div>

</div>

</div>

<script type="text/javascript">
var cond=<?php echo (isset($_SESSION['user'])?1:0);?>;
user='<?php echo $_SESSION['user']; ?>';
  if(cond==1)
 {
	findonline();  
  setTimeout(function(){getmessage()},1000);
 }
</script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>