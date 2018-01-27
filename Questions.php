<?php
include('functions.php');
$con=connect_db();
if(isset($_POST['submit']))
{

	 $question=$_POST['Question'];
	$option1=$_POST['option1'];
	$option2=$_POST['option2'];
	$option3=$_POST['option3'];
	$option4=$_POST['option4'];
	$answer=$_POST['answer'];
	$level=$_POST['level'];
	$no=$_POST['qno'];
	$category=$_POST['category'];
	echo $sql="insert into $category values ($level,$no,'$question','$option1','$option2','$option3','$option4','$answer')";
	$res=mysqli_query($con,$sql);
	if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to insert question");</script>';
		 echo mysqli_error($con);
	    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Questions</title>
 <link rel="stylesheet" href="css/bootstrap.min.css" />
  <script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>

<body>
<div class=" container " style="margin-top:8%;">
 <form class="form-horizontal  col-sm-8 col-sm-offset-2" role="form" method="post" action="" id="questans">
          
          <div class="form-group">
           <label for="Question" class="col-sm-2 control-label">Question</label>
           <div class="col-sm-6 input-group" >
           <input type="text" name="Question" id="Question" class=" form-control" placeholder="Question"  required="required"/> 
           </div>
          </div>
           <div class="form-group">
           <label for="option1" class="col-sm-2 control-label">option1</label>
           <div class="col-sm-6 input-group" >
           <input type="text" name="option1" id="option1" class=" form-control" placeholder="option1"  required="required"/> 
           </div>
          </div>
           <div class="form-group">
           <label for="option2" class="col-sm-2 control-label">option2</label>
           <div class="col-sm-6 input-group" >
           <input type="text" name="option2" id="option2" class=" form-control" placeholder="option2"  required="required"/> 
           </div>
          </div>
           <div class="form-group">
           <label for="option3" class="col-sm-2 control-label">option3</label>
           <div class="col-sm-6 input-group" >
           <input type="text" name="option3" id="option3" class=" form-control" placeholder="option3"  required="required"/> 
           </div>
          </div>
           <div class="form-group">
           <label for="option4" class="col-sm-2 control-label">option4</label>
           <div class="col-sm-6 input-group" >
           <input type="text" name="option4" id="option4" class=" form-control" placeholder="option4"  required="required"/> 
           </div>
          </div>
           <div class="form-group">
            <label for="answer" class="col-sm-2 control-label">Answer</label>
            <div class="col-sm-6 input-group">
          <input type="text" name="answer" id="answer" class="form-control" placeholder="answer" 
          required="required" />
            </div>
          </div>
            <div class="form-group ">
    <label class="col-sm-2 control-label"  for="category">Category</label>
      <!-- <h3>&nbsp;&nbsp;&nbsp;<span class="btn btn-info" style="cursor:default;">Select a category</span></h3>-->
    <div class="input-group col-sm-6" > 

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
          
          <div class="form-group ">
    <label class="col-sm-2 control-label"  for="level">Level</label>
      <!-- <h3>&nbsp;&nbsp;&nbsp;<span class="btn btn-info" style="cursor:default;">Select a category</span></h3>-->
    <div class="input-group col-sm-6" > 

<select  id="level" name="level" class="form-control" >
<option value="0" >Nothing selected</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
</select>
         </div>
          </div>
          
          <div class="form-group ">
    <label class="col-sm-2 control-label"  for="qno">Question no.</label>
      <!-- <h3>&nbsp;&nbsp;&nbsp;<span class="btn btn-info" style="cursor:default;">Select a category</span></h3>-->
    <div class="input-group col-sm-6" > 

<select  id="qno" name="qno" class="form-control" >
<option value="0" >Nothing selected</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>
         </div>
          </div>
          
          <div class="form-group">
          <div class="col-sm-offset-3 col-sm-3">
          <button type="submit" class="btn btn-info btn-lg" name="submit" >Add</button>
          </div>
   
          </div>
         </form>
</div>

</body>
</html>