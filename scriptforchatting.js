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


var mesgtimecheck;
var user;
function getmessage(){
	//document.getElementById("demo").innerHTML='came here';
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		//document.getElementById("demo").innerHTML='got message for user';
		 var notify=xmlhttp.responseText;
	//	document.getElementById("demo").innerHTML=notify;
	      
		if(notify!="")
		{
		var text=notify.split("<br>");	              
		for(i=1;i<text.length;i++)
		{
			var part=text[i].split("->");
			var textgiven=part[0]+' > '+user+' : '+part[1]+'\n'
		var textmesg=document.createTextNode(textgiven);
		//var textmesg=document.createTextNode(text[i]);
		document.getElementById("reply").appendChild(textmesg);
		}
		}
		mesgtimecheck=setTimeout(function(){getmessage()},20000);
    }
  }
xmlhttp.open("GET","Load_Questions.php?getmess="+user,true);
xmlhttp.send();
		
}


var timecheck;
function findonline(){
	//document.getElementById("demo2").innerHTML='reached findonline';
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	//	document.getElementById("demo2").innerHTML='got list of users';
		var people=document.getElementById("people");
		 people.innerHTML="";
		var text=xmlhttp.responseText.split("<br>");
		//document.getElementById("demo2").innerHTML=text;
		for(i=0;i<text.length;i++)
		{
		var item1=document.createElement("option");
        item1.value=text[i];
         item1.text=text[i];
         people.add(item1,people[i]);
		}
		timecheck=setTimeout(function(){findonline()},30000);
    }
  }
xmlhttp.open("GET","Load_Questions.php?findonline="+user,true);
xmlhttp.send();	
}


function sendmesg(){
 var mesg=document.getElementById("content").value;
 var receiver="";
  receiver = document.getElementById("people").value;
   //document.getElementById("demo1").innerHTML='sending message '+mesg+' from '+user+' to '+receiver;
if(receiver!=""&&mesg!="")
{
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var text=xmlhttp.responseText;
		if(text=="ok")
		{
			var textgiven=user+' > '+receiver+' : '+mesg+'\n';
		var textmesg=document.createTextNode(textgiven);
		document.getElementById("reply").appendChild(textmesg);
		}
    }
  }
xmlhttp.open("GET","Load_Questions.php?from="+user+"&mesg="+mesg+"&to="+receiver,true);
xmlhttp.send();
}
else
if(mesg=="")
alert("type some message");
else if(receiver=="")
alert("select a receiver");
}

