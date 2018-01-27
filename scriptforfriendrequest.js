// JavaScript Document
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


var user;
function conf(creator,butid,denybut){
	//document.getElementById("demo").innerHTML='came here';
	
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		//document.getElementById("demo").innerHTML='got message for user';
		 var notify=xmlhttp.responseText;
	//	document.getElementById("demo").innerHTML=notify;
	     if(notify=="done")
		 {
			 document.getElementById(butid).innerHTML='confirmed';
	      document.getElementById(butid).disabled="disabled";
		  document.getElementById(denybut).style.display="none";
		   item1=document.createElement("li");
   link1=document.createElement("a");
   center1=document.createElement("center");
   link1.href = "#";
   text1=document.createTextNode(creator);
   center1.appendChild(text1);
   link1.appendChild(center1);
   item1.appendChild(link1);
   document.getElementById("listen").appendChild(item1);
		 }
    }
  }
xmlhttp.open("GET","Load_Questions.php?confirmer="+user+"&creator="+creator,true);
xmlhttp.send();
		
}

function deny(creator,denybut,butid){
	//document.getElementById("demo").innerHTML='came here';
	
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		//document.getElementById("demo").innerHTML='got message for user';
		 var notify=xmlhttp.responseText;
	//	document.getElementById("demo").innerHTML=notify;
	     if(notify=="done")
		 {
			 document.getElementById(denybut).innerHTML='denied';
	      document.getElementById(denybut).disabled="disabled";
		  document.getElementById(butid).style.display="none";
		 }
    }
  }
xmlhttp.open("GET","Load_Questions.php?denier="+user+"&creator="+creator,true);
xmlhttp.send();
		
}