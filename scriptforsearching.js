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

function func(){
	var findperson=document.getElementById("userfield").value;
	if(findperson!="")
	{
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		//document.getElementById("demo").innerHTML='reached here';
		var list=xmlhttp.responseText;
		var text=list.split("<br>");
		c=document.getElementById("listen");
	    c.innerHTML="";
		if(list!="")
	for(i=0;i<text.length;i++)
	{	
   item1=document.createElement("li");
   link1=document.createElement("a");
   link1.href = "profile.php?uname="+text[i];
   link1.title = text[i];
   text1=document.createTextNode(text[i]);
   link1.appendChild(text1);
   item1.appendChild(link1);
   c.appendChild(item1);
	}	
	
    }
  }
xmlhttp.open("GET","Load_Questions.php?findperson="+findperson+"&finder="+user,true);
xmlhttp.send();
	}
	else
	{
		  c=document.getElementById("listen");
	      c.innerHTML="";
		 item1=document.createElement("li");
		 text1=document.createTextNode("No user found");
		  item1.appendChild(text1);
		  c.appendChild(item1);
	}
}