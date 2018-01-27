<?php
  session_start();
 include('Header.php');
include_once('functions.php');
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

$topic=array();
$sql="select topic from topics where 1";
$res=mysqli_query($con,$sql);
while($result=mysqli_fetch_array($res))
{
 $topic[]=$result["topic"];
}

$counttopic=count($topic);
$arr=array();
$i=0;
while($i<$counttopic)
{
$scoretype=$topic[$i].'score';
$sql="select uname,$scoretype from rank order by $scoretype DESC ";
$res=mysqli_query($con,$sql);
$j=0;
while($result=mysqli_fetch_array($res))
{
 $arr[$j][$i]=$result['uname']."(".$result[$scoretype].")";
$j++;
}
$i++;
}
 $people=$j;
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dashboard</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
</head>

<body>
<div  style="clear:both;"></div>
<!--
<div style="position:absolute; top:21%; ">
<div class="row col-sm-offset-4 col-sm-12">

            <div class="col-sm-3">
                        Cricket
            </div>
            <div class="col-sm-3">
                        Tennis
            </div>
            <div  class="col-sm-3">
                         Events
            </div>
            <div class="col-sm-3">
                         Geographical
            </div>

</div>
</div>
-->
<div class="container" style="margin-top:10%" >
<div class="table-responsive" >
            <table class="table table-striped" >
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Events</th>
                  <th>Geographical</th>
                  <th>Cricket</th>
                  <th>Tennis</th>
                </tr>
             </thead>
             <tbody>
               <?php
			   $i=0;
               while($i<$people)
			   {
				   $j=0;
				    echo'<tr>';
					echo'<td>'.($i+1).'</td>';
				  while($j<$counttopic)
				  {
                 echo'<td>'.$arr[$i][$j].'</td>';
				     $j++;
				  }	  
                  echo '</tr>';
			     $i++;
			   }
				?>
              </tbody>
            </table>
          </div>
          </div>
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>