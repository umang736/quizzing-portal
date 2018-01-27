<?php
session_start();
include('Header.php');
include_once('functions.php');

if(!isset($_SESSION['user']))
{
palert('please login first','./index.php');
die();
}
$con=connect_db();

if(isset($_SESSION['quizid']))
{
	//echo "reached";
   palert('you lost the quiz','./index.php');	
}
else
{

$uname=$_SESSION['user'];
$sql="select testid,topic,cont1,cont2,level from quizzes where (cont1='$uname' or cont2='$uname') and winner=''";
$res=mysqli_query($con,$sql);
  if(!$res)
	         {
		 echo '<script>alert("ERROR :Unable to get test details.please try again");</script>';
		 echo mysqli_error($con);
			 }
while($result=mysqli_fetch_array($res))
{
$_SESSION['quizid']=$result['testid'];	
$_SESSION['topic']=$result['topic'];
	$_SESSION['cont1']=$result['cont1'];
	$_SESSION['cont2']=$result['cont2'];
	$_SESSION['level']=$result['level'];
	$_SESSION['time']=30;
	//$imagecont1=;
	//echo 'cont1= '.$_SESSION['cont1']." cont2=".$_SESSION['cont2'];
}
if(!isset($_SESSION['quizid'])){
	palert('please choose a  category','./index.php');
	die();
}
  $imageuser=$_SESSION['cont1'];
	$sql="select name,picture from users where uname='$imageuser'";
	$res=mysqli_query($con,$sql);
	while($result=mysqli_fetch_array($res))
	{
	$name1=$result['name'];
	$image1=$result['picture'];	
	}
	$imageuser=$_SESSION['cont2'];
	$sql="select name,picture from users where uname='$imageuser'";
	$res=mysqli_query($con,$sql);
	while($result=mysqli_fetch_array($res))
	{
	$name2=$result['name'];
	$image2=$result['picture'];	
	}
//echo  '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

//echo $_SESSION['user']."<br/>".$_SESSION['gender']."<br/>".$_SESSION['dob']."<br/>".$_SESSION['country']."<br/>".
//$_SESSION['name']."<br/>".$_SESSION['email']."<br/>".$_SESSION['quizid']."<br />".$_SESSION['topic']."<br/>".
//$_SESSION['cont1']."<br />".$_SESSION['cont2']."<br />".$image1."<br />".$image2;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="bootstrap-progressbar-master/css/bootstrap-progressbar-3.2.0.min.css" />
<script type="text/javascript">
/*
window.onbeforeunload=function(){
var cond=<?php echo isset($_SESSION['user']);?>;
if(cond)
{
	loadDoc('<?php echo $_SESSION['user'];?>');
}	
    return 'you are leaving this site';
};
*/

/*
$(window).blur(function(){
  //your code here
  loadDoc('<?php// echo $_SESSION['user'];?>');
});

$(window).focus(function(){
  //your code here
   insertDoc('<?php// echo $_SESSION['user'];?>');
});
*/
/*
function getvalues(){
 var x = document.getElementById("category").selectedIndex;
   category =document.getElementsByTagName("option")[x].value;
	if(category==0)
	alert("slect a category");
	else
	{
		var uname='<?php //echo $_SESSION['user'];?>';
		alert(category+" "+uname+" "+"manku");
		caller(category,uname,"manku");
	}
}
*/
function remo(){
//window.location.href="Remove.php?uname=<?php// echo $_SESSION['user'];?>";
//window.location="Remove.php?uname=<?php //echo $_SESSION['user'];?>";
//alert("done");
}

</script>
<style type="text/css">
.six-sec-ease-in-out {
    -webkit-transition: height 2s ease-in-out;
    -moz-transition: height 2s ease-in-out;
    -ms-transition: height 2s ease-in-out;
    -o-transition: height 2s ease-in-out;
    transition: height 2s ease-in-out;
}
.custom{
width: 250px !important;
}
</style>
</head>
<body >
<!--<body onunload="loadDoc('<?php// echo $_SESSION['user'];?>')">-->
<!--<button >click</button>-->


<!--<form class="form-horizontal" role="form"  style="position:relative; top:200px; left:10px; " >-->
  <!--  <div class="form-group" style="position:relative; top:200px; left:10px; ">
    <label class="btn btn-info btn-lg "  style="position:relative; left:20px; cursor:default;" for="category">Select a category</label>
    -->
      <!-- <h3>&nbsp;&nbsp;&nbsp;<span class="btn btn-info" style="cursor:default;">Select a category</span></h3>-->
  <!--  <div class="input-group col-sm-2" > 
    <br />
<select  id="category" name="category" class="form-control" >
<option value="0" >Nothing selected</option>
<optgroup label="Sports" >
<option value="sp1">cricket</option>
<option value="sp2">tennis</option>
</optgroup>
<optgroup label="GK">
<option  value="gk1">events</option>
<option  value="gk2">geographical</option>
</optgroup>
</select>
         </div>
   <div class="col-sm-2 " style="position:relative; left:30px; ">
   <br />
     <button class="btn  btn-success " name="catsubmit" id="catsubmit" onclick="getvalues()" >
          Choose
       </button> 
         </div>
      </div>-->
 <!-- </form>-->
 
 <div class="col-sm-2 " style="position:absolute; top:160px; left:10%;" >
 
 <?php
  echo "<img src=\"pictures/".$image1."\"  width=\"145px\" height=\"200px\" class=\"img-responsive hidden-xs\" >";  
 echo"<br /><label style=\"color:#C60;\">".$name1."<br>(".$_SESSION['cont1'].")</label>";
 ?>
</div>

 <div class="col-sm-2 " style="position:absolute; top:160px; left:76%;" >
 <?php
  echo "<img src=\"pictures/".$image2."\"  width=\"145px\" height=\"200px\" class=\"img-responsive hidden-xs\" >";  
 echo"<br /><label style=\"color:#C60;\">".$name2."<br>(".$_SESSION['cont2'].")</label>";
 ?>
</div>

     <div class="panel panel-primary" style="position:absolute; top:53%; left:28%; width:600px;">
  <div class="panel-heading">
    <h3 class="panel-title" id="qno">Question no</h3>
  </div>
  <div class="panel-body" id="quest" >
    Question
  </div>
</div>

   <input type="button" class="btn btn-info btn-lg  custom" onclick="checkans('but1')" style="position:absolute; top:73%; left:28%;" id="but1" value="But1"></button>
   <input type="button" class="btn btn-info btn-lg custom" onclick="checkans('but2')" style="position:absolute;top:73%; left:52%;" id="but2"  value="But2"></button>
   <input type="button" class="btn btn-info btn-lg custom"  onclick="checkans('but3')" style="position:absolute;top:85%; left:28%;" id="but3"  value="But3"></button>
   <input type="button" class="btn btn-info btn-lg custom" onclick="checkans('but4')" style="position:absolute;top:85%; left:52%;" id="but4"  value="But4"></button>
 <div class="progress  vertical bottom progress-striped active  " style=" position:absolute; left:8%; top:25%; height:70%;">
  <div class="progress-bar progress-bar-success six-sec-ease-in-out" role="progressbar" id="p1" data-transitiongoal="0" >
     <!--style="height: 80%; width:100%;" can be used for setting initial height 80%-->
 </div>
</div>
<div class="progress vertical bottom progress-striped active " style="position:absolute; left:90%;top:25%; height:70%;">
  <div class="progress-bar progress-bar-danger six-sec-ease-in-out" role="progressbar" id="p2" data-transitiongoal="0">
   </div>
</div>
  <script src="js/jquery.min.js"></script>
<script type="text/javascript" src="scriptforhome.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="bootstrap-progressbar-master/bootstrap-progressbar.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.progress .progress-bar').progressbar();
});
</script>

<script type="text/javascript">
var time=1;
var ans;
/*
function func1(){
	var p1=document.getElementById("p1");
	var t=parseInt(p1.style.height);
	t=t+10;
    t=t+"%";
	//document.getElementById("demo").innerHTML=t;
	p1.style.height=t;
	
}
function func2(){
	
	var p2=document.getElementById("p2");
	var t=parseInt(p2.style.height);
	t=t+10;
    t=t+"%";
	//document.getElementById("demo").innerHTML=t;
	p2.style.height=t;
	
}
*/
function func1(ht){
	var p1=document.getElementById("p1");
	t=ht;
    t=t+"%";
	//document.getElementById("demo").innerHTML=t;
	p1.style.height=t;
	
}
function func2(ht){
	
	var p2=document.getElementById("p2");
	t=ht;
    t=t+"%";
	//document.getElementById("demo").innerHTML=t;
	p2.style.height=t;
	
}
</script>

<div  class="col-sm-offset-5 " style="position:absolute; top:25%;">
<label class="btn btn-default btn-lg " style="cursor:default;">Score Tally</label>
<br /><br />
&nbsp;<label class="label label-default" style="font-size:x-large" id="s1">00</label>
<label class="label label-default" style="font-size:x-large" id="s2">00</label>
</div>
<div  class="col-sm-offset-5 " style="position:absolute; top:45%;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="label label-warning" style="font-size:larger" id="time">29 sec</label>
</div>
<!--
<p id="demo"></p>
<p id="ansdemo"></p>
-->
<div id="ans" style=" position:absolute;top:90%; left:15%;"></div>
<!--<p id="demo1"></p>-->
<script>
player1='<?php echo $_SESSION['cont1']; ?>';
player2='<?php echo $_SESSION['cont2']; ?>';
user='<?php echo $_SESSION['user']; ?>';
quizid='<?php echo $_SESSION['quizid']; ?>';
//document.getElementById("ansdemo").innerHTML=player1+" "+player2+" "+user;
secs_r=<?php echo $_SESSION['time'];?>;
topic='<?php echo $_SESSION['topic'];?>';
level='<?php echo $_SESSION['level'];?>';
    loadquestion();
	setTimeout(function(){checkplayer2()},14000);
		</script>
       
        </div>
</body>

</html>