// JavaScript Document
var xmlhttp=createxmlhttprequestObject();

function createxmlhttprequestObject(){
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
return xmlhttp;
}


function loadDoc(uname)
{
//document.getElementById("demo").innerHTML='reacheddelete';
if(uname!="")
{
xmlhttp.open("GET","Remove.php?uname="+uname,true);
xmlhttp.send();
}

/*
else
{
document.getElementById("demo").innerHTML='khalidelete';	
}
*/
}

function insertDoc(uname)
{
//document.getElementById("demo").innerHTML='reachedinsert';
if(uname!="")
{
xmlhttp.open("GET","insert.php?uname="+uname,true);
xmlhttp.send();
}
/*
else
{
document.getElementById("demo").innerHTML='khaliinsert';	
}
*/
}

var level;
var qno=0;
var secs_r;
var t;
var topic;
function loadquestion(){
	//document.getElementById("demo").innerHTML='reached loadquestion';
		  qno++;
	if(qno<=10)
	{
			
		xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var text=xmlhttp.responseText.split("<brk>");
	
 //document.getElementById("demo").innerHTML='<span style="color:green;">'+'got question '+qno+'</span>';
     //setTimeout(window.location.href='home.php',3000);
	  document.getElementById("qno").innerHTML='Question '+qno;
	  document.getElementById("quest").innerHTML=text[0];
	     document.getElementById("but1").value=text[1];
		  document.getElementById("but2").value=text[2];
		   document.getElementById("but3").value=text[3];
		    document.getElementById("but4").value=text[4];
			 document.getElementById("but1").disabled=false;
			 document.getElementById("but2").disabled=false;
			 document.getElementById("but3").disabled=false;
			 document.getElementById("but4").disabled=false;
	            showtime(secs_r);
	                         
    }
  }
xmlhttp.open("GET","Load_Questions.php?no="+qno+"&level="+level+"&table="+topic,true);
xmlhttp.send();
	}
	else
	{
		
		  //alert('test is finished');
		declare();	
	}
  }
  
  function showtime(seconds)
{
	seconds=seconds-1;
	secs=seconds;
	if(secs<=9)
	secs="0"+secs; 
	text=secs;
	document.getElementById('time').innerHTML=text+" sec";
	if(seconds<=0)
	{
		clearTimeout(t);
		//location.reload();
		setTimeout(function(){loadquestion()},1000);
	}
	//document.getElementById('time').innerHTML='got past if';
	if(seconds>0)
		 t=setTimeout(function(){showtime(seconds)},1000);
} 

var player1;
var player2;
var user;
var quizid;
function checkans(id)
{
	var ans=document.getElementById(id).value;
	
	document.getElementById("but1").disabled=true;
	document.getElementById("but2").disabled=true;
	document.getElementById("but3").disabled=true;
	document.getElementById("but4").disabled=true;
	//document.getElementById("ansdemo").innerHTML='answer for '+qno+" given is "+ans+" by "+user;
	var player=((user==player1)?'cont1':'cont2');
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var text=xmlhttp.responseText.split("<br>");
		if(text[0]==ans)
 { 
                
 document.getElementById("ans").innerHTML='<span style="color:green;">'+' you got it right '+'</span>';
     
	 if(user==player1)
	{ 
	document.getElementById("s1").innerHTML=text[1];
	func1(text[1]);
	}
	 else if(user==player2)
	 {
		 document.getElementById("s2").innerHTML=text[1];
	 func2(text[1]);
	 }
 }
      else
	  document.getElementById("ans").innerHTML='<span style="color:red;">'+' you got it wrong.'+'<br>'+' The correct answer was '+text[0]+'</span>';
	  
    }
  }
xmlhttp.open("GET","Load_Questions.php?no="+qno+"&level="+level+"&ans="+ans+"&table="+topic+"&cont="+player+"&quizid="+quizid,true);
xmlhttp.send();

}

var timep2;
function checkplayer2(){
	var player=((user==player1)?'cont2':'cont1');
	if(qno<=10)
	{	
		xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var text=xmlhttp.responseText;
   
 //document.getElementById("demo1").innerHTML='<span style="color:green;">'+'got score of '+player+" "+text+'</span>';
     
	 if(user==player1)
	 {
	 func2(text);
		 if(text==0)
		 text="00";
	 document.getElementById("s2").innerHTML=text;
	
	 }
	 else if(user==player2)
	 {
		  func1(text);
		  if(text==0)
		 text="00";
	document.getElementById("s1").innerHTML=text;
	
	 }
	 timep2=setTimeout(function(){checkplayer2()},15000);
	}
  }
xmlhttp.open("GET","Load_Questions.php?contscr="+player+"&quizid="+quizid,true);
xmlhttp.send();
	}
	else
	{
		clearTimeout(timep2);
	}
}

var count=1;
function declare(){
//document.getElementById("demo").innerHTML='reached declare '+count;
count++;
		xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var text=xmlhttp.responseText.split("<br>");

 //document.getElementById("demo1").innerHTML='<span style="color:green;">'+'declaring results '+text[0]+" "+text[1]+" "+text[2]+'</span>';
     if(text[0]=='Tie')
	 alert('test is finished'+'\n'+text[0]+'\n'+"score "+text[1]);
	 else
	 alert('test is finished'+'\n'+text[0]+" "+text[1]+'\n'+"score "+text[2]);
	  window.location.href='index.php';
	}
  }
xmlhttp.open("GET","Load_Questions.php?testid="+quizid+"&ft="+topic+"&caller="+user,true);
xmlhttp.send();
	
}