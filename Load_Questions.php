<?php
include_once('functions.php');

	 $con=connect_db();
	 
	   function getuserlevel($type,$uname2)
	  {
		  $con=connect_db();
		  $userlevname=$type.'level';
		  $sql="select $userlevname from rank where uname='$uname2'";
		  $res=mysqli_query($con,$sql);
		  while($result=mysqli_fetch_array($res))
		    $unamelevel=$result[$userlevname];
		    if(!$res)
	    {  
		 echo '<script>alert("ERROR :Unable to get user levels.please try again");</script>';
		 echo mysqli_error($con);
	    } 
		return $unamelevel;
	  }
	  
	  function deleteuname2startedquiz($uname){
		  $con=connect_db();
		  $sql="delete from quizzes where cont1='$uname' and winner=''";
		  $res=mysqli_query($con,$sql);
		   if(!$res)
	    {  
		 echo '<script>alert("ERROR :Unable to delete user quiz.please try again");</script>';
		 echo mysqli_error($con);
	    } 
			
	  }
	  
	  if(isset($_GET['findonline']))
	  {
		  $uname=$_GET['findonline'];
		  $sql="select * from  loggedin where uname!='$uname'";
	      $res=mysqli_query($con,$sql);
		  $online="";
		    if(!$res)
	    {  
		 echo '<script>alert("ERROR :Unable to get list of online users.please try again");</script>';
		 echo mysqli_error($con);
	    } 
		if($result=mysqli_fetch_array($res))
		$online=$result['uname'];
		while($result=mysqli_fetch_array($res))
		{
			$online=$online."<br>".$result['uname'];
		}
		echo $online;
	  }
	  
	 else if(isset($_GET['ct'])&&isset($_GET['uname1']))
	 {
		 $ct=$_GET['ct'];//type of test
		 
		 $uname1=$_GET['uname1'];
		 $uname2='';
		 $levelname=$ct.'level';
		 $sql="select $levelname from rank where uname='$uname1'";
		 $res=mysqli_query($con,$sql);
		  if(!$res)
	     {  
		 echo '<script>alert("ERROR :Unable to get creator level.please try again");</script>';
		 echo mysqli_error($con);
	     } 
		 while($result=mysqli_fetch_array($res))
		 {
			 $userlevel=$result[$levelname];
		 }
		 
	       $sql="select * from quizzes where `topic`='$ct'";
		  $res=mysqli_query($con,$sql);

	   if(!$res)
	    {  
		 echo '<script>alert("ERROR :Unable to fetch count of quizzes.please try again");</script>';
		 echo mysqli_error($con);
	    }
		$count=0;
		while($result=mysqli_fetch_array($res))
	     {  $count++;}
		$type=$ct.($count+1);
		$empty='';
		$value=0;
		$sql="insert into quizzes values ('$type','$ct','$userlevel','$uname1','$uname2',$value,$value,'$empty',$value)";
		  $res=mysqli_query($con,$sql);
		   if(!$res)
	    {  
		 echo '<script>alert("ERROR :Unable to insert into quizzes.please try again");</script>';
		 echo mysqli_error($con);
	    } 
		
		echo "created<br>$type";

	 }
	 
	 
	 else if(isset($_GET['uname2'])){
		$uname2=$_GET['uname2'];
		
		 $sql="select * from quizzes where cont2='' and cont1!='$uname2'";
  		 $res=mysqli_query($con,$sql);
		  if(!$res)
	    {  
		 echo '<script>alert("ERROR :Unable to insert into quizzes.please try again");</script>';
		 echo mysqli_error($con);
	    } 
		$assignedquiz='';
		while($result=mysqli_fetch_array($res))
		{
		$topic=$result['topic'];
		$userlevel=$result['level'];
		$cont1=$result['cont1'];
		$user2level=getuserlevel($topic,$uname2);
		//echo $result['testid']." ".$cont1." ".$topic." ".$userlevel." ".$user2level."<br>";
		if($userlevel==$user2level)
		{
			$assignedquiz=$result['testid'];
			deleteuname2startedquiz($uname2);
			break;
		}
		}
		//echo $assignedquiz;
		if($assignedquiz=='')
		echo "noquiz";
		else
		{
			$sql="update quizzes set cont2='$uname2' where testid='$assignedquiz'";
			 $res=mysqli_query($con,$sql);
		  if(!$res)
	    {  
		 echo '<script>alert("ERROR :Unable to update testid in quizzes.please try again");</script>';
		 echo mysqli_error($con);
	    } 
		echo "quiz<br>$cont1<br>$topic";
		//echo "<br>".$assignedquiz;
		}
	 }
	 
	 
	 else if(isset($_GET['no'])&&isset($_GET['level'])&&isset($_GET['ans'])&&isset($_GET['table'])&&isset($_GET['cont'])&&isset($_GET['quizid']))//no means question no and table means category of question
	 {
		  $no=$_GET['no'];
		  $level=$_GET['level'];
		  $ans=$_GET['ans'];
		  $table=$_GET['table'];
		  $cont=$_GET['cont'];
		  $quizid=$_GET['quizid'];
		   $sql="select ans from $table where no=$no and level=$level";
	       $res=mysqli_query($con,$sql);
	      if(!$res)
	      {  
		  echo '<script>alert("ERROR :Unable to fetch answer.please try again");</script>';
		  echo mysqli_error($con);
	      }
		  
		  while($result=mysqli_fetch_array($res))
		  {
			$rs=$result['ans'];
		  }
		
		if($cont=='cont1')
		{
			$sql="select onescore from quizzes where testid='$quizid'";
			$res=mysqli_query($con,$sql);
			  if(!$res)
	      {
		  echo '<script>alert("ERROR :Unable to get score from quizzes table.please try again");</script>';
		  echo mysqli_error($con);
	      }
			while($result=mysqli_fetch_array($res)){
			$score=$result['onescore'];	
			}
		}
		else if($cont=='cont2')
		{
			$sql="select twoscore from quizzes where testid='$quizid'";
			$res=mysqli_query($con,$sql);
			  if(!$res)
	      {
		   echo '<script>alert("ERROR :Unable to get score from quizzes table.please try again");</script>';
		   echo mysqli_error($con);
	      }
			while($result=mysqli_fetch_array($res)){
			$score=$result['twoscore'];	
			}

		}
		if($rs==$ans)
		{
			//echo 'came<br>';
		if($cont=='cont1')
		{
			
			$score=$score+10;
		$sql="update quizzes set onescore=$score where testid='$quizid'";
		}
		else if($cont=='cont2')
		{
			
			 $score=$score+10;
		  $sql="update quizzes set twoscore=$score where testid='$quizid'";
		}
		$res=mysqli_query($con,$sql);
		  if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to update score in quizzes table.please try again");</script>';
		 echo mysqli_error($con);
	    }
		
		}
		//should be returned to client
		echo $rs."<br>".$score ;
		 
	  }
	  
	  
	  else if(isset($_GET['no'])&&isset($_GET['level'])&&isset($_GET['table']))
	  {
		   $no=$_GET['no'];
		  $table=$_GET['table'];
		  $level=$_GET['level'];
		 $sql="select question,opt1,opt2,opt3,opt4 from $table where no=$no and level=$level";
	    $res=mysqli_query($con,$sql);
	     if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to fetch questions.please try again");</script>';
		 echo mysqli_error($con);
	    }
		else 
		{
		while($result=mysqli_fetch_array($res))
		  {
			$quest=$result['question']."<brk>".$result['opt1']."<brk>".$result['opt2']."<brk>".$result['opt3']."<brk>".$result['opt4'];
			echo $quest;
			
		  }
		}
	  }
	  
	  
	  else if(isset($_GET['contscr'])&&isset($_GET['quizid'])){
		  $cont=$_GET['contscr'];
		  $quizid=$_GET['quizid'];
		  if($cont=='cont1')
		{
		  $sql="select onescore from quizzes where testid='$quizid'";
			$res=mysqli_query($con,$sql);
			  if(!$res)
	    {
		 echo '<script>alert("ERROR :Unable to get score from quizzes table.please try again");</script>';
		 echo mysqli_error($con);
	    }
			while($result=mysqli_fetch_array($res)){
			$score=$result['onescore'];	
			}
		}
		else if($cont=='cont2')
		{
			$sql="select twoscore from quizzes where testid='$quizid'";
			$res=mysqli_query($con,$sql);
			  if(!$res)
	     {
		  echo '<script>alert("ERROR :Unable to get score from quizzes table.please try again");</script>';
		  echo mysqli_error($con);
	     }
			while($result=mysqli_fetch_array($res)){
			$score=$result['twoscore'];	
			}
		}
		echo $score;
	  }
	  
	  
	  else if(isset($_GET['testid'])&&isset($_GET['ft'])&&isset($_GET['caller']))//ft stands for finish test for user
	  {
		    $test=$_GET['testid'];
		      $type=$_GET['ft'];
			  $caller=$_GET['caller'];
		     $sql="select cont1,cont2,onescore,twoscore,hasleft from quizzes where testid='$test'";
		     $res=mysqli_query($con,$sql);
			 while($result=mysqli_fetch_array($res))
			 {
				 $score1=$result['onescore'];
				  $score2=$result['twoscore'];
				  $uname1=$result['cont1'];
		         $uname2=$result['cont2'];
				 $hasleft=$result['hasleft'];
			 }
		   
	//echo $test." ".$type." ".$score1." ".$uname1." ".$uname2." ".$score2."<br/>";
		
		 if($hasleft==1)
		 {
	
		 $level=$type.'level';
		  $levelscore=$type.'score';
		 $sql="select $level,$levelscore from rank where uname='$caller'";
	      $res=mysqli_query($con,$sql);
		 while($result=mysqli_fetch_array($res))
		  {
			   $curscore=$result[$levelscore];
			   $curlevel=$result[$level];
		  }
		   // echo $curscore." ".$curlevel."<br/>";
		/* 
		  if($curscore==90||$curscore==190||$curscore==290||$curscore==390||$curscore==490)//max 5 levels
		  {  
		 */
		   $curscore=$curscore+100;//increment by 10 on each level when wins
		     $curlevel=$curlevel+1;//increment level
			  $sql="update rank set $levelscore=$curscore,$level=$curlevel where uname='$caller'";
		 /* }
		 else 
		 {    
   			 $curscore=$curscore+10;
		    $sql="update rank set $levelscore=$curscore where uname='$caller'";
		 }
		 */
		   $res=mysqli_query($con,$sql);
		  	  if(!$res)
	         {
		    echo '<script>alert("ERROR :Unable to update rank table.please try again");</script>';
		    echo mysqli_error($con);
	         }
			 if($caller==$uname1)
			 echo "winner<br>$caller($uname2 left the quiz)<br>$score1";
			 else if($caller==$uname2)
			 echo "winner<br>$caller($uname1 left the quiz)<br>$score2"; 
		die();
		 }
		 
		 
		if($score2>$score1)
		{
		  $sql="update quizzes set winner='$uname2' where testid='$test'";
		  $res=mysqli_query($con,$sql);
		   if(!$res)
	      {
		  echo '<script>alert("ERROR :Unable to update quizzes table.please try again");</script>';
		  echo mysqli_error($con);
	      }
		  if($caller==$uname1)
		  {
		  $level=$type.'level';
		  $levelscore=$type.'score';
		  $sql="select $level,$levelscore from rank where uname='$uname2'";
	      $res=mysqli_query($con,$sql);
		  while($result=mysqli_fetch_array($res))
		  {
			   $curscore=$result[$levelscore];
			   $curlevel=$result[$level];
		  }
		 // echo $curscore." ".$curlevel."<br/>";
		/* 
		  if($curscore==90||$curscore==190||$curscore==290||$curscore==390||$curscore==490)//max 5 levels
		  {  
		  */
		   $curscore=$curscore+100;//increment by 10 on each level when wins
		     $curlevel=$curlevel+1;//increment level
			  $sql="update rank set $levelscore=$curscore,$level=$curlevel where uname='$uname2'";
		/*}
		  else 
		  {
		    
   			 $curscore=$curscore+10;
		    $sql="update rank set $levelscore=$curscore where uname='$uname2'";
		  }
		  */
		   $res=mysqli_query($con,$sql);
		  	  if(!$res)
	         {
		   echo '<script>alert("ERROR :Unable to update rank table.please try again");</script>';
		   echo mysqli_error($con);
	         }
		  }
			echo "winner<br>$uname2<br>$score2"; 
		}
		  
		  
		 else if($score1>$score2)
		 {
			$sql="update quizzes set winner='$uname1' where testid='$test'";
		    $res=mysqli_query($con,$sql);
			 if(!$res)
	       {
		   echo '<script>alert("ERROR :Unable to update quizzes table.please try again");</script>';
		   echo mysqli_error($con);
	       }
		   if($caller==$uname1)
		   {
		    $level=$type.'level';
		   $levelscore=$type.'score';
		    $sql="select $level,$levelscore from rank where uname='$uname1'";
	       $res=mysqli_query($con,$sql);
		   while(($result=mysqli_fetch_array($res)))
		   {
			   $curscore=$result[$levelscore];
			   $curlevel=$result[$level];
		   }
		   // echo "<br/>".$curscore." ".$curlevel."<br/>";
		/*
		   if($curscore==90||$curscore==190||$curscore==290||$curscore==390||$curscore==490)//max 5 levels
		   {  
		   */ 
		      $curscore=$curscore+100;//increment by 10 on each level when wins
			 $curlevel=$curlevel+1;//increment level
			  $sql="update rank set $levelscore=$curscore,$level=$curlevel where uname='$uname1'";
		  /*
		   }
		   else 
		   {
			 $curscore=$curscore+10;
		     $sql="update rank set $levelscore=$curscore where uname='$uname1'";
		   }
		   */
		   $res=mysqli_query($con,$sql);
		  	  if(!$res)
	         {
		    echo '<script>alert("ERROR :Unable to update rank table.please try again");</script>';
		    echo mysqli_error($con);
	         }
		   }
		     echo "winner<br>$uname1<br>$score1"; 
		}
		   
		   
	  else{
			   $sql="update quizzes set winner='Tie' where testid='$test'";
		      $res=mysqli_query($con,$sql);
			 if(!$res)
	         {
		       echo '<script>alert("ERROR :Unable to update quizzes table.please try again");</script>';
		       echo mysqli_error($con);
	         }
		     if($caller==$uname1)
		    {
			//for player 1
		    $level=$type.'level';
		    $levelscore=$type.'score';
		    $sql="select $level,$levelscore from rank where uname='$uname1'";
	        $res=mysqli_query($con,$sql);
		     while(($result=mysqli_fetch_array($res)))
		    {
			   $curscore=$result[$levelscore];
			   $curlevel=$result[$level];
		    }
		   // echo "<br/>".$curscore." ".$curlevel."<br/>";
		/*
		   if($curscore==90||$curscore==190||$curscore==290||$curscore==390||$curscore==490)//max 5 levels
		   {   
		 */
		      $curscore=$curscore+100;//increment by 10 on each level when wins
			  $curlevel=$curlevel+1;//increment level
			  $sql="update rank set $levelscore=$curscore,$level=$curlevel where uname='$uname1'";
		  /*
		   }
		   else 
		   {
			 $curscore=$curscore+10;
		    $sql="update rank set $levelscore=$curscore where uname='$uname1'";
		   }
		   */
		   $res=mysqli_query($con,$sql);
		  	  if(!$res)
	         {
		    echo '<script>alert("ERROR :Unable to update rank table.please try again");</script>';
		    echo mysqli_error($con);
	         }
			 
			 //for player 2
			 $sql="select $level,$levelscore from rank where uname='$uname2'";
	       $res=mysqli_query($con,$sql);
		   while(($result=mysqli_fetch_array($res)))
		   {
			   $curscore=$result[$levelscore];
			   $curlevel=$result[$level];
		   }
		   // echo "<br/>".$curscore." ".$curlevel."<br/>";
		/*
		   if($curscore==90||$curscore==190||$curscore==290||$curscore==390||$curscore==490)//max 5 levels
		   {
		*/
		   
		      $curscore=$curscore+100;//increment by 10 on each level when wins
			 $curlevel=$curlevel+1;//increment level
			  $sql="update rank set $levelscore=$curscore,$level=$curlevel where uname='$uname2'";
		  /*
		   }
		   else 
		  {
			 $curscore=$curscore+10;
		   $sql="update rank set $levelscore=$curscore where uname='$uname2'";
		  }
		  */
		   $res=mysqli_query($con,$sql);
		  	  if(!$res)
	         {
		    echo '<script>alert("ERROR :Unable to update rank table.please try again");</script>';
		    echo mysqli_error($con);
	         }
		    }
			 echo "Tie<br>$score1";      
		}
		    
	  }
	  
	  
	  else if(isset($_GET['sq']))
	  {
		$testid=$_GET['sq'];
		$cont2='';
		$sql="select cont2 from quizzes where testid='$testid'";  
		   $res=mysqli_query($con,$sql);
		  	  if(!$res)
	         {
		 echo '<script>alert("ERROR :Unable to check opponent for test.please try again");</script>';
		 echo mysqli_error($con);
			 }
	
		  while(($result=mysqli_fetch_array($res)))
		  {
			   $cont2=$result['cont2'];
		  }
	      
			 if($cont2!='')
			 echo "startquiz<br>$cont2";
			 else
			 echo 'nostart';
	  }
	  
	  else if(isset($_GET['from'])&&isset($_GET['mesg'])&&isset($_GET['to']))
	  {
		  $from=$_GET['from'];
		  $mesg=$_GET['mesg'];
		  $to=$_GET['to'];
		  $sql="insert into messages values ('$from','$mesg','$to',0)";
		    $res=mysqli_query($con,$sql);
		  	  if(!$res)
	         {
		 echo '<script>alert("ERROR :Unable to insert into messages.please try again");</script>';
		 echo mysqli_error($con);
			 }
			 else
			 echo "ok"; 
	  }
	  
	  else if(isset($_GET['getmess']))
	  {
		  $text="";
		  $receiver=$_GET['getmess'];
		  $sql="select * from messages where receiver='$receiver' and status=0 ";
		   $res=mysqli_query($con,$sql);
		   while($result=mysqli_fetch_array($res))
		   {
		   $text=$text."<br>".$result['sender']."->".$result['mesg'];
		   }
		    $sql="update messages set status =1 where receiver='$receiver'";
		   $res=mysqli_query($con,$sql);
		     if(!$res)
	         {
		 echo '<script>alert("ERROR :Unable to update status of  messages.please try again");</script>';
		 echo mysqli_error($con);
			 }
		   echo $text;
	  }
	  
	  
	  else if(isset($_GET['findperson'])&&isset($_GET['finder']))
	  {
		  $user=$_GET['findperson'];
		  $finder=$_GET['finder'];
		  if($user=='')
		  echo "";
		  else
		  {
		  $sql="select uname from users where uname like '%$user%' and uname!='$finder'";
		   $res=mysqli_query($con,$sql);
		    if(!$res)
	         {
		   echo '<script>alert("ERROR :Unable to get list of people with similar names.please try again");</script>';
		   echo mysqli_error($con);
			 }
		   $str="";
		   if($result=mysqli_fetch_array($res))
		   $str=$result['uname'];
		   while($result=mysqli_fetch_array($res))
		   {
		   $str=$str."<br>".$result['uname'];
		   }
		   echo $str;
		   }
	  }
	  
	  else if(isset($_GET['confirmer'])&&isset($_GET['creator']))
	  {
		  $p2=$_GET['confirmer'];
		  $p1=$_GET['creator'];
		  $sql="update friends set status=1 where p1='$p1' and p2='$p2'";
		   $res=mysqli_query($con,$sql);
		    if(!$res)
	         {
		   echo '<script>alert("ERROR :Unable to add to friend list.please try again");</script>';
		   echo mysqli_error($con);
			 }
			 echo 'done';
	  }
	  else if(isset($_GET['denier'])&&isset($_GET['creator']))
	  {
		  $p2=$_GET['denier'];
		  $p1=$_GET['creator'];
		  $sql="update friends set status=2 where p1='$p1' and p2='$p2'";
		   $res=mysqli_query($con,$sql);
		    if(!$res)
	         {
		   echo '<script>alert("ERROR :Unable to mark as spam.please try again");</script>';
		   echo mysqli_error($con);
			 }
			 echo 'done';
	  }
?>