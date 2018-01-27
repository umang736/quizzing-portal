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



function findonline(uname2){
	
	//document.getElementById("demo1").innerHTML='reached findonline for'+uname2;
	
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var text=xmlhttp.responseText.split("<br>");
		//document.getElementById("demo1").innerHTML=text;
		var type;
		if(text[0]=='quiz')
		{
			switch(text[2])
			{
			case 'sp1':
			type='cricket';
			break;
			case 'sp2':
			type='tennis';
			break;
			case 'gk1':
			type='events';
			break;
			case 'gk2':
			type='geographical';
			}
		  alert('found opponent='+text[1]+'\nquiz type='+type);
		 window.location.href='home.php';
		
		}
		else
		{
		//document.getElementById("demo1").innerHTML='no user found'+text[0];
		setTimeout(function(){findonline(uname2)},5000);
		}
	
    }
  }
xmlhttp.open("GET","Load_Questions.php?uname2="+uname2,true);
xmlhttp.send();
	
}


function caller(category,uname1){
//document.getElementById("demo").innerHTML='reached here';
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var text=xmlhttp.responseText.split("<br>");
		if(text[0]=="created")
 { 
 //document.getElementById("demo").innerHTML='<span style="color:green;">'+text[0]+text[1]+'</span>';
     //setTimeout(window.location.href='home.php',3000);
	 document.getElementById("catsubmit").value="searching for opponent ...";
	 document.getElementById("catsubmit").disabled=true;
	 checkother(text[1]);
 }
      else
	 {
		 alert("uanable to create quiz");
		 // document.getElementById("demo").innerHTML='<span style="color:red;">'+text[0]+'</span>';
	 }
    }
  }
xmlhttp.open("GET","Load_Questions.php?ct="+category+"&uname1="+uname1,true);
xmlhttp.send();
}

function checkother(testid){
	
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var text=xmlhttp.responseText.split("<br>");
		if(text[0]=="startquiz")
 { 
 //document.getElementById("demo").innerHTML='<span style="color:green;">'+text[0]+'</span>';
     //setTimeout(window.location.href='home.php',3000);
	  alert('found opponent='+text[1]);
		 window.location.href='home.php';
 }
      else
	  {
		 // document.getElementById("demo").innerHTML='no opponent found '+text[0];
		  setTimeout(function(){checkother(testid)},5000);
	  }
    }
  }
xmlhttp.open("GET","Load_Questions.php?sq="+testid,true);
xmlhttp.send();

}
