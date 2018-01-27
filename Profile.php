<?php
  session_start();
include_once('functions.php');

if(!isset($_SESSION['user']))
{
palert('please login first','./index.php');
die();
}
$profilename="";
if(isset($_GET['uname']))
echo $profilename=fix($_GET['uname']);

$con=connect_db();
if(isset($_POST['friendsubmit']))
{
	$friend=$_POST['sendfriend'];
	$creator=$_SESSION['user'];
	$sql="insert into friends values ('$creator','$friend','$creator',0)";
	$res=mysqli_query($con,$sql);
	if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to insert into friends");</script>';
		 echo mysqli_error($con);
		 $profilename=$friend;
	    }
		else
		{
		palert('friend request sent','./Messages.php');	
		}
}
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
<title>Profile</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/dashboard.css" />
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="scriptforfriendrequest.js"></script>

<style type="text/css">
</style>
</head>

<body>
<div id="demo"></div>
 <div class="container-fluid " style="margin-top:12%">
 <div class="row">
  <?php
  if($profilename=="")
  {
         echo '<div class="col-sm-offset-10" style="position:fixed;">';
                        
                       
                        echo "<img src=\"pictures/".$_SESSION['userimage']."\"  width=\"145px\" height=\"200px\"   class=\"img-responsive hidden-xs \" >";
						echo '<label class="control-label col-sm-2" >'.$_SESSION['user'].'</label>';
						                        
                        echo '</div>';
  }
  ?>  
 <div class="col-sm-offset-3 col-sm-8">
                     <?php
                       if($profilename=="")
					   {
					   ?>
                        
                    <form class="form-horizontal  col-sm-offset-2 " role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"                            id="update" enctype="multipart/form-data"> 
                      <div class="form-group" >
                        <label class="control-label col-sm-2" for="name">Name: </label>
                            <div class="col-sm-6 input-group" >
                            <span class=" glyphicon glyphicon-user input-group-addon"></span>
                            <input type="text"  required="required" id="name" class="form-control" name="name" 
                             value="<?php echo $_SESSION['name'];?>" />
                            </div>
                            </div>
                           
                           <div class="form-group " > 
                         <label class="control-label col-sm-2" >Gender:</label>
                     
                        <div class="col-sm-6 input-group">                        
    
       <label class="radio-inline " ><input type="radio" name="gender" required="required" value="M" <?php if($_SESSION['gender']=="M") echo 'checked="checked"';?> >Male:</label> 
   
       <label class="radio-inline " ><input type="radio" name="gender" required="required" value="F"  <?php if($_SESSION['gender']=="F") echo 'checked="checked"';?> >Female:</label> 
    
                      </div>
                        </div>
                         
                          <div class="form-group">
             <label class="control-label col-sm-2" >DOB:</label>
               <div class="col-sm-6 input-group"> 
                <span class="glyphicon glyphicon-calendar input-group-addon"></span>
               &nbsp;&nbsp;
               <?php $dob=explode("/",$_SESSION['dob']);?>
               <select id="day" name="day" style="height:28px;">
              <?php
           for($i=0;$i<=30;$i++)
		   {
			   $val=($i+1);
			   if($val!=$dob[0])
           echo '<option value='.$val.'>'.date("d",$i*3600*24).'</option>';
		   else
           echo '<option value='.$val.' selected="selected">'.date("d",$i*3600*24).'</option>';
		   }
		   ?>
                 </select>
                 &nbsp;/&nbsp;
                 <select name="month" id="month" style="height:28px;">
                <?php
               
                for($i=1;$i<=12;$i++)
				if($i!=$dob[1])
                echo "<option value=\"$i\">".date("M",$i*3600*24*29)."</option>";
				else
				echo "<option value=\"$i\" selected=\"selected\">".date("M",$i*3600*24*29)."</option>";
                 ?>
                  </select>
                  &nbsp;/&nbsp;
                    <select name="year"  id="year" style="height:28px;">
               <?php
                 
                      for($i=1993;$i<=2005;$i++)
					  if($i!=$dob[2])
                     echo "<option value=\"$i\" >".$i."</option>";
					 else
					  echo "<option value=\"$i\" selected=\"selected\">".$i."</option>";
                  ?>
                  </select>
                       </div>
                           </div>
                         
                          <div class="form-group">
             <label class="control-label col-sm-2" for="country">Country:</label>
               <div class="col-sm-6 input-group"> 
                <span class="glyphicon glyphicon-flag input-group-addon"></span>
               <select class="form-control" id="country" name="country" >
                <option value="1" <?php if($_SESSION['country']==1)echo 'selected="selected"';?> >India</option>
                  <option value="2" <?php if($_SESSION['country']==2)echo 'selected="selected"';?> >Pakistan</option>
                  <option value="3"  <?php if($_SESSION['country']==3)echo 'selected="selected"';?> >China</option>
                   <option value="4"  <?php if($_SESSION['country']==4)echo 'selected="selected"';?> >Nepal</option>
                     <option value="5"  <?php if($_SESSION['country']==5)echo 'selected="selected"';?> >Sri Lanka</option>
                       </select>
                       </div>
                           </div>
                           
                              <div class="form-group" >
                         <label class="control-label col-sm-2" for="email">Email:</label>
                        <div class="col-sm-6 input-group">
                           <span class="glyphicon glyphicon-envelope input-group-addon"></span>
                           <input type="email" id="email" required="required" class="form-control" name="email" value="<?php echo $_SESSION['email'];?>" />
                        </div>  
                        </div>
                      
                      <div class="form-group" >
                        <label class="control-label col-sm-2" for="picture" >Picture:</label>
                        <div class="input-group">
                           
                          <input id="picture" required="required" type="file" accept="image/*"   style="height:28px;" name="image" data-toggle="tooltip"
                           title=" file should be of maximum 1mb and of type jpg,gif,png or jpeg" data-placement="right"/>                         <!--<span> file should be of maximum 1mb</span>-->
                        </div>     
                         </div>
                         
                        <div class="form-group" >
                        <label class="control-label col-sm-2" for="uname" >Username:</label>
                        <div class="col-sm-6 input-group">
                           <span class="glyphicon glyphicon-user input-group-addon"></span>
                           <input id="uname" required="required" type="text" class="form-control"  name="uname" value="<?php echo $_SESSION['user'];?>" readonly="readonly" />
                        </div>     
                         </div>
                               
                                <div class="table-responsive" >
            <table class="table table-striped"  style="position:relative; left:-15%;">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Events</th>
                  <th>Geographical</th>
                  <th>Cricket</th>
                  <th>Tennis</th>
                </tr>
             </thead>
              <tbody>
               <?php
			  $topic=array();
               $sql="select topic from topics where 1";
                $res=mysqli_query($con,$sql);
				
                     while($result=mysqli_fetch_array($res))
                   {
                  $topic[]=$result["topic"];
                   }
                    $counttopic=count($topic);
                   $user=$_SESSION['user'];
				    echo'<tr>';
					echo'<td>score</td>';
					$sql="select * from rank where uname='$user' ";
                   $res=mysqli_query($con,$sql); 
				   $result=mysqli_fetch_array($res);
				   if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to get score list");</script>';
		 echo mysqli_error($con);
	    }
				  $j=0;
				  while($j<$counttopic)
				  {
					  //echo 'entered';
					 $cat=$topic[$j].'score';
                 echo'<td>'.$result[$cat].'</td>';
				     $j++;
				  }	  
                  echo '</tr>';
			     
				?>
              </tbody>
             </table>
             </div>
             
                        <div class="form-group" >
                            <div class="col-sm-offset-2 col-sm-3 ">
                            <button type="submit" class="btn  btn-primary " name="updatesubmit" >
                           Update
                            </button> 
                            </div>
                        </div>
                        
                     </form>
                   <?php
					   }
					   else
					   {
						   $sql="select gender,country,name,picture from users  where uname='$profilename' ";
	$res=mysqli_query($con,$sql);
	if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to update winner list");</script>';
		 echo mysqli_error($con);
	    }                         $count=0;
						   while($result=mysqli_fetch_array($res))
						   {
							   $count++;
							   $profilenaam=$result['name'];
							   $profilegender=$result['gender'];
							   $profilecountry=$result['country'];
							   $profilepicture=$result['picture'];

						   }
				   ?>
                   
                   <div class="col-sm-offset-3">
                       <div style="position: absolute; left:80%; top:-10%;">
                       
                        <?php
                        echo "<img src=\"pictures/".$profilepicture."\"  width=\"145px\" height=\"200px\"   class=\"img-responsive hidden-xs \" >";
						?>  
                         <label class="control-label col-sm-2" for="picture" ><?php echo $profilename;?></label>
                        </div>
                      <div class="form-group" >
                        <label class="control-label col-sm-2" for="name">Name: </label>
                            <div class="col-sm-6 input-group" >
                            
                           <label class="label-info label" style="font-size:16px"><?php echo $profilenaam;?></label>
                            </div>
                            </div>
                           <br />
                           
                           <div class="form-group " > 
                         <label class="control-label col-sm-2" >Gender:</label>
                     
                        <div class="col-sm-6 input-group">                        
    
       <label class="label-info label" style="font-size:16px">  <?php if($profilegender=="M") echo 'Male';?> 
   
       <?php if($profilegender=="F") echo 'Female:';?> </label>
    
                      </div>
                        </div>
                         <br />
                          <div class="form-group">
             <label class="control-label col-sm-2" for="country">Country:</label>
               <div class="col-sm-6 input-group"> 
               
                <label class="label-info label" style="font-size:16px"> 
				<?php if($profilecountry==1)echo 'India';?> 
                  <?php if($profilecountry==2)echo 'Pakistan';?> 
                  <?php if($profilecountry==3)echo 'China';?> 
                   <?php if($profilecountry==4)echo 'Nepal';?> 
                     <?php if($profilecountry==5)echo 'Nepal';?> 
                      </label>
                       </div>
                           </div>
                      <br />
                     <!-- <div class="form-group" >-->
                         
                        <!-- </div>-->
                         
                        <div class="form-group" >
                        <label class="control-label col-sm-2" for="uname">Username:</label>
                        <div class="col-sm-6 input-group">
                          
                           <label class="label-info label" style="font-size:16px">  <?php echo $profilename;?></label>
                        </div>     
                         </div>
                             <br />  
              
                         <div class="table-responsive" >
            <table class="table table-striped"  style="position:relative; left:-28%;">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Events</th>
                  <th>Geographical</th>
                  <th>Cricket</th>
                  <th>Tennis</th>
                </tr>
             </thead>
              <tbody>
               <?php
			  $topic=array();
               $sql="select topic from topics where 1";
                $res=mysqli_query($con,$sql);
				
                     while($result=mysqli_fetch_array($res))
                   {
                  $topic[]=$result["topic"];
                   }
                    $counttopic=count($topic);
            
				    echo'<tr>';
					echo'<td>score</td>';
					$sql="select * from rank where uname='$profilename' ";
                   $res=mysqli_query($con,$sql); 
				   $result=mysqli_fetch_array($res);
				   if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to get score list");</script>';
		 echo mysqli_error($con);
	    }
				  $j=0;
				  while($j<$counttopic)
				  {
					  //echo 'entered';
					 $cat=$topic[$j].'score';
                 echo'<td>'.$result[$cat].'</td>';
				     $j++;
				  }	  
                  echo '</tr>';
			     
				?>
              </tbody>
             </table>
             </div>
             <br />
                              <form class="form-horizontal   " role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id=                      "friendrequest" > 
                              <input type="hidden" value="<?php echo $profilename;?>" name="sendfriend" />
                        <div class="form-group" >
                            <div class="col-sm-offset-2 col-sm-3 ">
                            <button type="submit" class="btn  btn-primary " name="friendsubmit" >
                           Send a friend request
                            </button> 
                            </div>
                        </div>
                        
                     </form> 
                        </div>      
                   <?php
					   }
				   ?>
                   </div>
                   
                   <div class="col-sm-2 col-sm-offset-1  sidebar" >
                   <center>
                   <label class="label label-warning" style="font-size:16px">Pending Friend Requests</label>
                   </center>
                 
                    <ul class="nav nav-sidebar">
                    <?php
                    $user=$_SESSION['user'];
					$sql="select p1,p2 from friends where p2='$user' and status=0 ";
					$res=mysqli_query($con,$sql);
					if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to get friend requests list");</script>';
		 echo mysqli_error($con);
	    }
		$count=1;
		
		     while($result=mysqli_fetch_array($res))
			   {
				   $p1=$result['p1'];
				   $p2=$result['p2'];
				   $idacptbut='acptbut'.$count;
				   $iddenybut='denybut'.$count;
				   $name=($p1==$user)?$p2:$p1;
				echo '<li><center><label style="font-size:16px"><a href="Profile.php?uname='.$name.'">'.$name.'</a></label>';
			
				   echo "<br/><button type=\"button\" onclick=\"conf('$name','$idacptbut','$iddenybut')\" id=\"$idacptbut\" >".'Confirm'."</button>";
				   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" onclick=\"deny('$name','$iddenybut','$idacptbut')\"  id=\"$iddenybut\">".'Not Now'."</button></center></li>";
				   $count++;
			   }
			    echo '</ul>';
				if($count==1)
				echo '<center>no pending requests</center>';
					?>
                     <br /><br />
                   <center>
                  <label class="label label-warning" style="font-size:16px">Friend List</label>
                   </center>
                   <ul id="listen" class="nav nav-sidebar">
                    <?php
					
					$user=$_SESSION['user'];
					$sql="select p1,p2 from friends where (p1='$user' or p2='$user') and status=1 ";
					$res=mysqli_query($con,$sql);
	if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to get friend list");</script>';
		 echo mysqli_error($con);
	    }  
		       while($result=mysqli_fetch_array($res))
			   {
				   if($result['p1']==$user)
				echo '<li style="font-size:16px"><a href="#"><center>'.$result['p2'].'</center></a></li>';
				else 
				   echo '<li  style="font-size:16px"><a href="#"><center>'.$result['p1'].'</center></a></li>';
			   }
						 
						 ?>   
                      </ul>
                     
                   </div>
                  
                   </div>
                     </div>     
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
user='<?php echo  $_SESSION['user'];?>';

</script>
</body>
</html>