
<?php
include('functions.php');
class Database{
public $con;
	function __construct() {
		 $this->con=connect_db();
	}
	 public function getanswer($no,$ans,$table)
	 {
	//no means question no and table means category of question

		   $sql="select ans from $table where no=$no";
	    $res=mysqli_query($this->con,$sql);
	  if(!$res)
	    {  
		 echo '<script>alert("ERROR :Unable to fetch answer.please try again");</script>';
		 echo mysqli_error($this->con);
	    }
		else
	   {
		while($result=mysqli_fetch_array($res))
		{
			if($ans==$result['ans'])
			$rs="true";
			else 
			$rs="false";
		}
		 /* echo "<script>alert('$rs');</script>";*/
		echo $rs;//should be returned to server
	   }
		 
	 }	

      public function getquestion($no,$table)
	  {
		 $sql="select question,opt1,opt2,opt3,opt4 from $table where no=$no";
	    $res=mysqli_query($this->con,$sql);
	     if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to fetch questions.please try again")alert;</script>';
		 echo mysqli_error($this->con);
	    }
		else 
		{
		while($result=mysqli_fetch_array($res))
		  {
			$quest=$result['question']."<br>".$result['opt1']."<br>".$result['opt2']."<br>".$result['opt3']."<br>".$result['opt4'];
			echo $quest;
			
		  }
		}
	  }
	  
	  public function finishtest($test, $type, $uname1, $uname2, $score1, $score2)
	  {
	
	//echo $test." ".$type." ".$score1." ".$uname1." ".$uname2." ".$score2."<br/>";
		 
		  if($score2>$score1)
		  {
		  $sql="update quizzes set onescore=$score1,twoscore=$score2,winner='$uname2' where testid='$test'";
		  $res=mysqli_query($this->con,$sql);
		   if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to update quizzes table.please try again");</script>';
		 echo mysqli_error($this->con);
	    }
		$level=$type.'level';
		$levelscore=$type.'score';
		 $sql="select $level,$levelscore from rank where uname='$uname2'";
	      $res=mysqli_query($this->con,$sql);
		  while($result=mysqli_fetch_array($res))
		  {
			   $curscore=$result[$levelscore];
			   $curlevel=$result[$level];
		  }
		 // echo $curscore." ".$curlevel."<br/>";
		 
		  if($curscore==90||$curscore==190||$curscore==290||$curscore==390||$curscore==490)//max 5 levels
		  {  
		   $curscore=$curscore+10;//increment by 10 on each level when wins
		     $curlevel=$curlevel+1;//increment level
			  $sql="update rank set $levelscore=$curscore,$level=$curlevel where uname='$uname2'";
		  }
		 else 
		 {
			  $curscore=$curscore+10;
		  $sql="update rank set $levelscore=$curscore where uname='$uname2'";
		 }
		   $res=mysqli_query($this->con,$sql);
		  	  if(!$res)
	         {
		 echo '<script>alert("ERROR :Unable to update rank table.please try again");</script>';
		 echo mysqli_error($this->con);
	         }
			   
		 }
		  
		  else if($score1>$score2)
		  {
			$sql="update quizzes set onescore=$score1,twoscore=$score2,winner='$uname1' where testid='$test'";
		    $res=mysqli_query($this->con,$sql);
			 if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to update quizzes table.please try again");</script>';
		 echo mysqli_error($this->con);
	    }
		$level=$type.'level';
		$levelscore=$type.'score';
		    $sql="select $level,$levelscore from rank where uname='$uname1'";
	      $res=mysqli_query($this->con,$sql);
		  while(($result=mysqli_fetch_array($res)))
		  {
			   $curscore=$result[$levelscore];
			   $curlevel=$result[$level];
		  }
		   // echo "<br/>".$curscore." ".$curlevel."<br/>";
		
		  if($curscore==90||$curscore==190||$curscore==290||$curscore==390||$curscore==490)//max 5 levels
		  {   
		      $curscore=$curscore+10;//increment by 10 on each level when wins
			 $curlevel=$curlevel+1;//increment level
			  $sql="update rank set $levelscore=$curscore,$level=$curlevel where uname='$uname1'";
		  }
		 else 
		 {
			 $curscore=$curscore+10;
		 $sql="update rank set $levelscore=$curscore where uname='$uname1'";
		 }
		   $res=mysqli_query($this->con,$sql);
		  	  if(!$res)
	         {
		 echo '<script>alert("ERROR :Unable to update rank table.please try again");</script>';
		 echo mysqli_error($this->con);
	         }
		
		  }
	  
	  }
}


/*
$data=new Database();
$data->getanswer('1','klnblkgfnl','sp1');
$data->getquestion('1','sp1');
$data->finishtest('sp21','sp2','umang','manku',70,50);
*/
?>
