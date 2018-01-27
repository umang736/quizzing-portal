<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="css/bootstrap.min.css" />
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<link rel="icon" href="images/icon.jpg" />
<style type="text/css">
.error{color:#F00;}
#forgot{
	text-decoration:none;
	cursor:pointer;
}

#maintitle
{
	/*float:left;*/	
	margin-left:35%;
	margin-right:auto;
	
	width:500px;	
	font-size:40px;
		 }
	#mainimage{
		display:block;
		float:left;
		position:relative;
		}
		.navbar-nav > li{
  padding-left:30px;
  padding-right:30px;
  font-size:26px;
}
#reglink{
position:absolute; top:20px; left:1200px;}	
}

</style>
</head>

<body>
<div class="navbar navbar-default navbar-fixed-top col-lg-12" role="navigation" >
        	<img class="img-circle img-responsive hidden-xs" src="images/icon.jpg"  id="mainimage" />
             <h1 id="maintitle">Online Quizzing</h1>
		    <?php
			
//echo $_SESSION['user']."<br/>".$_SESSION['gender']."<br/>".$_SESSION['dob']."<br/>".$_SESSION['country']."<br/>".$_SESSION['name']."<br/>".$_SESSION['email'];
          
		    if(!isset($_SESSION['user'])&&($_SERVER['PHP_SELF']!='/Quizzing/register.php'))
			{
				echo '<a href="register.php" class="btn btn-info btn-lg" role="button" id="reglink">Register</a>'; 
				
			  }
			?>
		<div class="navbar-header ">
 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#list" ><span class="icon-bar"></span> <span class="icon-bar"></span><span class="icon-bar"></span> </button>
       </div>
       <div class="navbar-collapse collapse col-lg-offset-2" id="list" >
                <ul class="nav navbar-nav">
                    <li ><a href="index.php">Home</a></li>
                    <li><a href="Dashboard.php">Dashboard</a></li>
                    <?php
                   
					  if(isset($_SESSION['user'])&&($_SERVER['PHP_SELF']!='/Quizzing/Messages.php'))
					{
					echo'<li><a href='.'Messages.php'.'>Messages</a></li>';
					}
					  if(isset($_SESSION['user'])&&($_SERVER['PHP_SELF']!='/Quizzing/Profile.php'))
					{
					echo'<li><a href='.'Profile.php'.'>Profile</a></li>';					
					}
					/*
					  if(isset($_SESSION['user'])&&($_SERVER['PHP_SELF']!='/Quizzing/Friends.php'))
					{
					echo'<li><a href='.'Friends.php'.'>Friends</a></li>';					
					}
					*/
					 if(isset($_SESSION['user'])&&($_SERVER['PHP_SELF']!='/Quizzing/logout.php'))
					{
                    echo'<li><a href='.'logout.php'.'>Logout</a></li>';
					}
					?>
                </ul>    
        </div>
       
</div> 
</body>
</html>