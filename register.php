<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<script type="text/javascript">
function gayab(){
document.getElementById("register").style.display="none";
}
</script>
</head>
<?php
//ini_set("display_errors",0);
  session_start();
include('functions.php');
include('Header.php');
	
if(isset($_POST['submit']))
{
	 $con=connect_db();
	 
	$name= mysqli_real_escape_string($con,fix($_POST['name']));
	$gender=mysqli_real_escape_string($con,fix($_POST['gender']));
	 $day=mysqli_real_escape_string($con,fix($_POST['day']));
	  $month=mysqli_real_escape_string($con,fix($_POST['month']));
	   $year=mysqli_real_escape_string($con,fix($_POST['year']));
	   $country=mysqli_real_escape_string($con,fix($_POST['country']));
	   $email=mysqli_real_escape_string($con,fix($_POST['email']));
	 $uname=mysqli_real_escape_string($con,fix($_POST['uname']));
	 $pass=mysqli_real_escape_string($con,fix($_POST['pass']));
	 $pass1=mysqli_real_escape_string($con,fix($_POST['pass1']));
	//  echo $name." ".$gender." ".$day." ".$month." ".$year." ".$country." ".$email." ".$uname." ".$pass." ".$pass1; 
	
	if (!preg_match("/^[a-zA-Z ]*$/",$name))
{
	 $message="ERROR : Invalid Name";
        echo "<script>
      alert( \"$message\" );
      </script>";
}

	else if($day==0||$month==0||$year==0)
	 {
		$message="ERROR : Choose your Date Of Birth";
        echo "<script>
      alert( \"$message\" );
      </script>";
	 }
	 
	 else if($country==0)
	 {
		$message="ERROR : Select your Country";
        echo "<script>
      alert( \"$message\" );
      </script>";
	 }
	 
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

$message="ERROR : Invalid Email";
        echo "<script>
      alert( \"$message\" );
      </script>";

}

	 else if(strlen($uname)<5)
{
	 $message="ERROR : Username too short";
        echo "<script>
      alert( \"$message\" );
      </script>";
}

	 else if($pass!=$pass1)
{
	$message="ERROR : ERROR : Passwords didn't match";
        echo "<script>
      alert( \"$message\" );
      </script>";
}
 else if(strlen($pass)<5)
{
	$message="ERROR : ERROR : Passwords too short";
        echo "<script>
      alert( \"$message\" );
      </script>";
}
else
{
	//echo "entered here";
	$sql='select uname from users where uname ='.$uname;
	 $rs=mysqli_query($con,$sql);
	 if(!$rs||mysqli_num_rows($rs)==0)
	 {
      $allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","JPEG","GIF");
		$temp = explode(".", $_FILES["image"]["name"]);
		$extension = end($temp);

		if ((($_FILES["image"]["type"] == "image/gif")
		|| ($_FILES["image"]["type"] == "image/jpeg")
		|| ($_FILES["image"]["type"] == "image/jpg")
		|| ($_FILES["image"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts)) {
			if ($_FILES["image"]["error"] > 0) {
				echo '<script type="text/javascript"> alert("Error uploading file");</script>';
				$err=1;
			    } 
			else {
				echo "entered upload";
	           $file=$uname.'.'.$extension;
				move_uploaded_file($_FILES["image"]["tmp_name"], "pictures/".$file);
				$err=0;
			   }
		 } 
		else {
			echo '<script type="text/javascript"> alert("Invalid file");
					 </script>';
					 $err=1;
		    }
		if($err==0)
	  {
	  $dob=$day.'/'.$month.'/'.$year;
		 
	    $sql="insert into users values ('$name','$gender','$dob','$country','$email','$uname','$pass','$file')";
	    $res=mysqli_query($con,$sql);
	    if(!$res)
	    {
		 echo "<script><alert>('ERROR :Unable to insert to database.please try again')</alert></script>";
		 echo mysqli_error($con);
	    }
		$one=1;$zero=0;
		$sql="insert into rank values ('$uname',$one,$zero,$one,$zero,$one,$zero,$one,$zero)";
	    $res=mysqli_query($con,$sql);
	    if(!$res)
	    {
		 echo "<script><alert>('ERROR :Unable to insert to rank table.please try again')</alert></script>";
		 echo mysqli_error($con);
	    }
	    else
	    {  
	    palert('Registered successfully','./index.php');
	    }
	  }
	}
	 else
	 {
		 $message="ERROR :Username already in use";
        echo "<script>
      alert( \"$message\" );
      </script>";
	 }
}
   }
?>
<body>
        	
        <div class="container well " style="margin-top:10%">
                    <form class="form-horizontal col-sm-8 col-sm-offset-2" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="register" enctype="multipart/form-data"> 
                      <div class="form-group" >
                        <label class="control-label col-sm-2" for="name">Name: </label>
                            <div class="col-sm-6 input-group" >
                            <span class=" glyphicon glyphicon-user input-group-addon"></span>
                            <input type="text"   required="required" id="name" class="form-control" name="name" placeholder="Name" />
                            </div>
                            </div>
                           
                           <div class="form-group " > 
                         <label class="control-label col-sm-2" >Gender:</label>
                     
                        <div class="col-sm-6 input-group">                        
    
       <label class="radio-inline " ><input type="radio" name="gender" required="required" value="M">Male:</label> 
   
       <label class="radio-inline " ><input type="radio" name="gender" required="required" value="F">Female:</label> 
    
                      </div>
                        </div>
                         
                          <div class="form-group">
             <label class="control-label col-sm-2" >DOB:</label>
               <div class="col-sm-6 input-group"> 
                <span class="glyphicon glyphicon-calendar input-group-addon"></span>
               &nbsp;&nbsp;
               <select id="day" name="day" style="height:28px;">
              <?php
			   echo "<option value=\"0\">"."dd"."</option>";
           for($i=0;$i<=30;$i++)
		   {
			   $val=($i+1);
           echo '<option value='.$val.'>'.date("d",$i*3600*24).'</option>';
		   }
		   ?>
                 </select>
                 &nbsp;/&nbsp;
                 <select name="month" id="month" style="height:28px;">
                <?php
                echo "<option value=\"0\">"."M"."</option>";
                for($i=1;$i<=12;$i++)
                echo "<option value=\"$i\">".date("M",$i*3600*24*29)."</option>"
                 ?>
                  </select>
                  &nbsp;/&nbsp;
                    <select name="year"  id="year" style="height:28px;">
               <?php
                 echo "<option value=\"0\">"."yyyy"."</option>";
                      for($i=1993;$i<=2005;$i++)
                     echo "<option value=\"$i\">".$i."</option>";
                  ?>
                  </select>
                       </div>
                           </div>
                         
                          <div class="form-group">
             <label class="control-label col-sm-2" for="country">Country:</label>
               <div class="col-sm-6 input-group"> 
                <span class="glyphicon glyphicon-flag input-group-addon"></span>
               <select class="form-control" id="country" name="country" >
               <option value="0">Choose your country</option>
                <option value="1">India</option>
                  <option value="2">Pakistan</option>
                  <option value="3">China</option>
                   <option value="4">Nepal</option>
                     <option value="5">Sri Lanka</option>
                       </select>
                       </div>
                           </div>
                           
                              <div class="form-group" >
                         <label class="control-label col-sm-2" for="email">Email:</label>
                        <div class="col-sm-6 input-group">
                           <span class="glyphicon glyphicon-envelope input-group-addon"></span>
                           <input type="email" id="email" required="required" class="form-control" name="email" placeholder="Email" />
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
                        <label class="control-label col-sm-2" for="uname">Username:</label>
                        <div class="col-sm-6 input-group">
                           <span class="glyphicon glyphicon-user input-group-addon"></span>
                           <input id="uname" required="required" type="text" class="form-control"  name="uname" placeholder="Username" />
                        </div>     
                         </div>
                         
                         <div class="form-group">
                         <label class="control-label col-sm-2" for="pass">Password:</label>
                        <div class="col-sm-6 input-group">
                           <span class="glyphicon glyphicon-lock input-group-addon"></span>
                           <input type="password" required="required" id="pass" class="form-control" name="pass" placeholder="Password"/>
                        </div>  
                        </div>
                        
                       <div class="form-group" > 
                         <label class="control-label col-sm-2" for="pass1">Confirm Password:</label>
                        <div class="col-sm-6 input-group">
                           <span class="glyphicon glyphicon-lock input-group-addon"></span>
                           <input type="password" required="required" id="pass1" class="form-control" name="pass1" placeholder="Confirm Password" />
                        </div>
                        </div>
                               
                        <div class="form-group" >
                            <div class="col-sm-offset-2 col-sm-3 ">
                            <button type="submit" class="btn  btn-success " name="submit" >
                            Register
                            </button> 
                            </div>
                        </div>
                        
                     </form>
                     </div>      
                         
   <script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

</body>
</html>
