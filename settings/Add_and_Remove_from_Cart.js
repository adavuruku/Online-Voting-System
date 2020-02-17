

function track_voting()
{
	//alert("sherif");
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
			  return;
	}
			//total vote for each position
			var c_track ="realtime";
			var url="Cart_Processor.php";
			parameters="c_track="+c_track;
			xmlHttp.onreadystatechange=stateChanged22;
			xmlHttp.open("POST",url,true);
			xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlHttp.send(parameters);
	//setTimeout('track_voting();', 1000);
}
track_voting();
//THIS UPDATE THE vote cast OF ITEM ON STACK
var c_vote_id = sug_vote_id = "";
function Add_to_Cart(p,q)
{
	c_vote_id = p;
	sug_vote_id =q;
	//alert(sug_vote_id);
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
			  alert ("Your browser does not support AJAX!");
			  return;
			 }
			var url="Cart_Processor.php";
			parameters="c_vote_id="+p+"&c_post_id="+q;
			xmlHttp.onreadystatechange=stateChanged33;
			xmlHttp.open("POST",url,true);
			xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlHttp.send(parameters);
}

function stateChanged22() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		/**document.getElementById('show_cart').innerHTML="";
		document.getElementById('show_cart').innerHTML=xmlHttp.responseText;**/
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
			document.getElementById(idat).innerHTML=poor[1].toString().concat("  Votes !");
			//alert(idat);
		}
		
		//change each contestant value
		
		/**var nm = not[1].toString().split(";");
		for (var gm = 0;gm<nm.length;gm++)
		{
			var pum = nm[gm];
			var poorm = pum.split("-");
			var idam = poorm[0].toString();
			document.getElementById(idam).innerHTML=poorm[1].toString().concat("  Votes !");
			//alert(idat);
		}
		**/
	}
}

function stateChanged33() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		/**document.getElementById('show_cart').innerHTML="";
		document.getElementById('show_cart').innerHTML=xmlHttp.responseText;**/
		var qou = xmlHttp.responseText;
		document.getElementById(c_vote_id).innerHTML = qou.concat("  Votes !");;
		
		var k = document.getElementById(sug_vote_id).value;
		//alert(qou);
		for(var i=1;i<=k;i++)
		{
			var t = sug_vote_id.concat(i);
			document.getElementById(t).innerHTML="";
		}
		track_voting();
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
