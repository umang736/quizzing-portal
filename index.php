<?php
  session_start();
  //echo $_SESSION['user']." ".$_SESSION['gender']." ".$_SESSION['dob']." ".$_SESSION['country']." ".$_SESSION['name']." ".$_SESSION['email'];

include_once('functions.php');
$con=connect_db();
if(isset($_POST['submit']))
{    
	 $uname=mysqli_real_escape_string($con,fix($_POST['uname']));
	 $pass=mysqli_real_escape_string($con,fix($_POST['pass']));
      //echo $uname." ".$pass;
	  $sql="Select * from users where uname='$uname' or email='$uname'";
	  $res=mysqli_query($con,$sql);
	  if(mysqli_num_rows($res)==1)
	  {
	$result=mysqli_fetch_array($res);	
	if($result['pass']==$pass)
	{
		//echo $uname." ".$result['gender']." ".$result['dob']." ".$result['country']." ".$result['name']." ".$result['email'];
		$_SESSION['user']=$uname;
		$_SESSION['gender']=$result['gender'];
		$_SESSION['dob']=$result['dob'];
		$_SESSION['country']=$result['country'];
		$_SESSION['name']=$result['name'];
		$_SESSION['email']=$result['email'];
		$_SESSION['userimage']=$result['picture'];
		//echo $_SESSION['user']." ".$_SESSION['gender']." ".$_SESSION['dob']." ".$_SESSION['country']." ".$_SESSION['name']." ".$_SESSION['email'];
		//echo "done";
	   //redirect('./home.php');
	    $sql="insert into loggedin values ('$uname') ";
	  $res=mysqli_query($con,$sql);
	   if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to insert into loggedin users,you are already logged in from somewhere");</script>';
		 echo mysqli_error($con);
		 session_destroy();
		 unset($_SESSION['user']);
	    }
		
	}
	else
	{
		$message="Invalid Password";
		 echo "<script>
      alert( \"$message\" );
      </script>";
	}
	  }
	  else 
	  { 
		$message="Invalid Username";
     echo "<script>
      alert( \"$message\" );
      </script>";
	  }
}

?>
<?php
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
<?php
if(isset($_POST['forgotsubmit']))
{
foreach($_POST as $t)
$t=fix($t);
$userforgot=$_POST['userforgot'];
$emailforgot=$_POST['mail'];
$pass1=$_POST['pass1'];
$pass2=$_POST['pass2'];
if($pass1==$pass2)
{
	$sql="select email from users where uname='$userforgot'";
	$res=mysqli_query($con,$sql);
	if(!$res)
	    {
		 echo '<script>alert("ERROR :User not found");</script>';
		 echo mysqli_error($con);
	    }
		else
		{
			while($result=mysqli_fetch_array($res))
			{
				$email=$result['email'];
			}
			if($email==$emailforgot)
			{
				$sql="update users set pass='$pass1' where uname='$userforgot'";
	             $res=mysqli_query($con,$sql);
	          if(!$res)
	          {
		        echo '<script>alert("ERROR :User not found");</script>';
		        echo mysqli_error($con);
	           }
			   else
			    echo '<script>alert("Password updated");</script>';
		    }
			else
			{
				 echo '<script>alert("ERROR :Invalid Username or email");</script>';
			}
		}
}
else
{
	echo '<script>alert("ERROR :password mismatch");</script>';
}
}
?>
<?php
include('Header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="scriptforremoving.js"></script>
 
 <script type="text/javascript">
 var category;
 var cond2=<?php echo (isset($_SESSION['user'])?1:0);?>;
 if(cond2==1)
 var uname='<?php echo $_SESSION['user'];?>';
else
var uname='';
    function getdata(){
		//document.getElementById("demo").innerHTML='reached';
   var x = document.getElementById("category").selectedIndex;
   category =document.getElementsByTagName("option")[x].value;
	if(category==0)
	alert("slect a category");
	else
	{
		
		//alert(category+" "+uname);
		//document.getElementById("demo").innerHTML=category+" "+uname;
		caller(category,uname);
		
	}	
	
}

/*
function searchtest(){
	document.getElementById("demo").innerHTML='reached searchtest';
	findonline(uname);	
}
*/
</script>

<style type="text/css">
</style>
</head>

<body>
	 
        <div class="container well" style="margin-top:13%" >
         <?php
        
         if(!isset($_SESSION['user']))
		 {
		?>
         <form class="form-horizontal  col-sm-8 col-sm-offset-2" role="form" method="post" action="" id="login">
          
          <div class="form-group">
           <label for="userfield" class="col-sm-2 control-label">Username</label>
           <div class="col-sm-6 input-group" >
           <span class="glyphicon glyphicon-user input-group-addon"></span>
           <input type="text" name="uname" id="userfield" class=" form-control" placeholder="Username or email"  required="required"/> 
           </div>
          </div>
           <div class="form-group">
            <label for="passfield" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-6 input-group">
            <span class="glyphicon glyphicon-log-in input-group-addon"></span>
          <input type="password" name="pass" id="passfield" class="form-control" placeholder="Password" 
          required="required" />
            </div>
          </div>
          
          <div class="form-group">
          <div class="col-sm-offset-2 col-sm-3">
          <button type="submit" class="btn btn-success" name="submit" >Log In</button>
          </div>
           <a id="forgot" class="col-sm-offset-1" onclick="changa()" >
                    <small>
                        <b>Forgot your password?</b>
                    </small>
              </a>
          </div>
         </form>
         <div>
       
            <form class="form-horizontal  col-sm-8 col-sm-offset-2" role="form" method="post" action="" id="forgotform" style="display:none;">
          
          <div class="form-group">
           <label for="userforgot" class="col-sm-2 control-label">Username</label>
           <div class="col-sm-6 input-group">
           <span class="glyphicon glyphicon-user input-group-addon"></span>
           <input type="text" name="userforgot" id="userforgot" class=" form-control" placeholder="Username"  required="required"/> 
           </div>
          </div>
          <div class="form-group">
           <label for="forgotemail" class="col-sm-2 control-label">Email</label>
           <div class="col-sm-6 input-group">
           <span class="glyphicon glyphicon-envelope input-group-addon"></span>
           <input type="email" name="mail" id="forgotemail" class=" form-control" placeholder="Email"  required="required"/> 
           </div>
          </div>
           <div class="form-group">
            <label for="forgotpass1" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-6 input-group">
            <span class="glyphicon glyphicon-log-in input-group-addon"></span>
          <input type="password" name="pass1" id="forgotpass1" class="form-control" placeholder="Password" 
          required="required" />
            </div>
          </div>
           <div class="form-group">
            <label for="forgotpass2" class="col-sm-2 control-label">Confirm Password</label>
            <div class="col-sm-6 input-group">
            <span class="glyphicon glyphicon-log-in input-group-addon"></span>
          <input type="password" name="pass2" id="forgotpass2" class="form-control" placeholder="Confirm Password" 
          required="required" />
            </div>
          </div>
          <div class="form-group">
          <div class="col-sm-offset-2 col-sm-3">
          <button type="submit" class="btn btn-primary" name="forgotsubmit" >Change</button>
          </div>
          </div>
         </form>
         
         <?php
		 }
		 else
		 {
		
		?>
        
		
     <form class="form-horizontal col-sm-8 col-sm-offset-3" role="form" action="#" >
        <div class="form-group ">
    <label class="btn btn-info btn-lg col-sm-8"  style="cursor:default;" for="category">Select a category</label>
      <!-- <h3>&nbsp;&nbsp;&nbsp;<span class="btn btn-info" style="cursor:default;">Select a category</span></h3>-->
    <div class="input-group col-sm-8" > 
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
          </div>
                          <div class="form-group" >
                            <div class="col-sm-8 col-sm-offset-3" >
                        <br />
                            <input class="btn  btn-success  btn-large" name="catsubmit" id="catsubmit"  value="Choose" type="button" onclick="getdata()" /> 
                            
                            </div>
                        </div>
                         <div class="form-group" style="position:relative; left:-16%;" >
                         <div class="alert alert-danger " role="alert" >please don't navigate to other pages or refresh or press back button during the quiz otherwise you would loose it</div>
                            </div>
                             </div>
                        </form>
                      
         <?php
		 }
		 ?>
         <div id="demo"></div>       
          <div id="demo1"></div>

           </div> 
        <script>
		var cond=<?php echo (isset($_SESSION['user'])?1:0);?>;
   if(cond==1)
    findonline(uname);

	function changa()
{
	//document.getElementById("demo").innerHTML='reached change';
	document.getElementById("forgotform").style.display="block";
}
		</script>
</body>
</html>
