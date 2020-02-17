function track_voting()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
			  return;
	}
			//total vote for each position
			var c_track ="realtime";
			var url="sug_live_result_Ajax.php";
			parameters="c_track="+c_track;
			xmlHttp.onreadystatechange=stateChanged22;
			xmlHttp.open("POST",url,true);
			xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlHttp.send(parameters);
	setTimeout('track_voting();', 5000);
}
track_voting();
//THIS UPDATE THE vote cast OF ITEM ON STACK
var c_vote_id = sug_vote_id = "";
function stateChanged22() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		//alert("sherif");
		var qou = xmlHttp.responseText;
		//alert(qou);
		var not = qou.split("*");
		var n = not[0].toString().split(";");
		for (var g = 0;g<n.length;g++)
		{
			var pu = n[g];
			var poor = pu.split("-");
			var ida = poor[0].toString();
			//alert(ida);
			var hh = "A";
			var idat = ida.concat(hh);
			document.getElementById(ida).innerHTML=poor[1].toString().concat("  Votes !");
			//alert(document.getElementById(ida).innerHTML);
		}
		
		//change each contestant value
		
		var nm = not[1].toString().split(";");
		for (var gm = 0;gm<nm.length;gm++)
		{
			//alert("entered");
			var pum = nm[gm];
			var poorm = pum.split("-");
			var idam = poorm[0].toString();
			document.getElementById(idam).innerHTML = poorm[1].toString().concat("  Votes !");
			//alert(document.getElementById(idam).innerHTML);
			//alert(idat);
		}
	}
}



function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
		{
			 // Firefox, Opera 8.0+, Safari
			xmlHttp=new XMLHttpRequest();
		}
	catch (e)
		{
			// Internet Explorer
			 try
				{
					xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
				}
			  catch (e)
				{
					xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
		}
			return xmlHttp;
}
