<?php
	function fix($val){
		return  htmlentities(trim($val));
	}

    function connect_db(){
		$con=mysqli_connect("localhost","root","umang736","webster");
		if(mysqli_connect_errno()){
			{
		 echo "<br><br><br><br><br><center><b>Error connecting to database".mysqli_connect_error()."</b></center>";
			die();
			}
		}
		else
		{
		return $con;
		}
	}


function redirect( $url ) 
{
		echo '<script language="javascript">';	
		echo	"window.location.href= \"$url\"  ";
       	echo	'</script>';
		
}

function palert($message,$tourl)
{
      echo "<script>
      alert( \"$message\" );
      </script>";
         redirect($tourl);
}


?>