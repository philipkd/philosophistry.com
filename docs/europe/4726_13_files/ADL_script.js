var backColor="#ffffff"
var overColor="#e6e6e6"

function mouseOn(src){ 
	if (!src.contains(event.fromElement)){ 
		src.bgColor = overColor; 
	} 
} 
function mouseOff(src){ 
	if (!src.contains(event.toElement)){ 
		src.bgColor = backColor; 
	} 
} 
/*function mousePick(src){ 
	if(event.srcElement.tagName=='TD')
		src.children.tags('A')[0].click();
}*/
function setBgColor(src){
        src.bgColor =  backColor;
		}

		
		function openWindow_dimensions(param, w, h) {
    var newWindow = window.open(param,'Answer','width='+w+',height='+h+',scrollbars=no, resizable=no');
	if(newWindow.top != top) {newWindow.focus(); }
}		
		
		
		
function openWindow(param, w, h) {
    var newWindow = window.open(param,'Answer','width='+w+',height='+h+',scrollbars=yes, resizable=no');
	if(newWindow.top != top) {newWindow.focus(); }
}		

if (parent.location.href != window.location.href) parent.location.href = window.location.href;

function openWindow2(param, w, h) 
{
  newWindow2 = window.open(param,'Answer2','width='+w+',height='+h+',scrollbars=yes, resizable=yes');
	if(newWindow2.top != top) {newWindow2.focus(); }
 if (parseInt(navigator.appVersion)>3) {
   if (navigator.appName=="Netscape") {
    newWindow2.top.outerWidth=w;
    newWindow2.top.outerHeight=h;
   }
   else newWindow2.resizeTo(w,h);
 }
}

function resizeOuterTo(w,h) {
 if (parseInt(navigator.appVersion)>3) {
   if (navigator.appName=="Netscape") {
    top.outerWidth=w;
    top.outerHeight=h;
   }
   else top.resizeTo(w,h);
 }
}

/*******************************************************************************************************/

/*
This is the centered pop up script for the banner ad
*/

function ReadCookie (CookieName) {
  var CookieString = document.cookie;
  var CookieSet = CookieString.split (';');
  var SetSize = CookieSet.length;
  var CookiePieces
  var ReturnValue = "";
  var x = 0;

  for (x = 0; ((x < SetSize) && (ReturnValue == "")); x++) {

    CookiePieces = CookieSet[x].split ('=');

    if (CookiePieces[0].substring (0,1) == ' ') {
      CookiePieces[0] = CookiePieces[0].substring (1, CookiePieces[0].length);
    }

    if (CookiePieces[0] == CookieName) {
      ReturnValue = CookiePieces[1];
    }

  }

  return ReturnValue;

}

/*function adlAd(url, w, h, isPopunder, expDays) {

var winl = 3*(screen.width/5);
var wint = (screen.height/4);
winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars=0'+',resizable=0'
win = window.open(url, 'ADLPopup', winprops)

if (parseInt(navigator.appVersion) >= 4 && isPopunder) {self.focus();}
else if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }

}
*/

function adlAd(url, w, h, isPopunder, expDays) {

//var winl = 3*(screen.width/5); this was the original
//var winl = (screen.width - w)/ 2 + 200;
//var wint = (screen.height/4); this was the original
//var wint = (screen.height - h)/ 2 - 300;
//winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars=0'+',resizable=0'
winprops = 'height='+h+',width='+w+',top=0,left=0,scrollbars=0'+',resizable=0'
win = window.open(url, 'ADLPopup', winprops)

if (parseInt(navigator.appVersion) >= 4 && isPopunder) {self.focus();}
else if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }

}


 
/* An example of use......<a href="http://www.yahoo.com/" onclick="NewWindow(this.href,'name','400','400','yes');return false;">Popup Yahoo.com</a>
*/


/*This is the main cookie script used for the banner ad*/

var expDays = 1/24; // number of days the cookie should last
var winl = (screen.width -200)/ 2 + 300 ;
var wint = (screen.height - 200)/ 2 - 50;
var page = "cookie_child2.asp";
var windowprops = 'height=200,width=200,top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'

function GetCookie (name) {  
var arg = name + "=";  
var alen = arg.length;  
var clen = document.cookie.length;  
var i = 0;  
while (i < clen) {    
var j = i + alen;    
if (document.cookie.substring(i, j) == arg)      
return getCookieVal (j);    
i = document.cookie.indexOf(" ", i) + 1;    
if (i == 0) break;   
}  
return null;
}
function SetCookie (name, value) {
var expDays = 1/24; // number of days the cookie should last
var argv = SetCookie.arguments;  
var argc = SetCookie.arguments.length;  
var expires = (argc > 2) ? argv[2] : null;  
var path = (argc > 3) ? argv[3] : null;  
var domain = (argc > 4) ? argv[4] : null;  
var secure = (argc > 5) ? argv[5] : false;  
document.cookie = name + "=" + escape (value) + 
((expires == null) ? "" : ("; expires=" + expires.toGMTString())) + 
((path == null) ? "" : ("; path=" + path)) +  
((domain == null) ? "" : ("; domain=" + domain)) +    
((secure == true) ? "; secure" : "");
}
function DeleteCookie (name) {  
var exp = new Date();  
exp.setTime (exp.getTime() - 1);  
var cval = GetCookie (name);  
document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
}
var exp = new Date(); 
exp.setTime(exp.getTime() + (expDays*24*60*60*1000));
function amt(){
var count = GetCookie('count')
if(count == null) {
SetCookie('count','1')
return 1
}
else {
var newcount = parseInt(count) + 1;
DeleteCookie('count')
SetCookie('count',newcount,exp)
return count
   }
}
function getCookieVal(offset) {
var endstr = document.cookie.indexOf (";", offset);
if (endstr == -1)
endstr = document.cookie.length;
return unescape(document.cookie.substring(offset, endstr));
}


//leftpos = screen.width - 600

function checkCount() {
var count = GetCookie('count');
if (count == null) {
count=1;
SetCookie('count', count, exp);

window.open(page, "", windowprops);

}
else {
count++;
SetCookie('count', count, exp);
   }
}
/**************************************************************************************************************/

function exit(){ 
//var adlpage = location.href.substring(location.href.lastIndexOf("/")+1);
//var adlpage = location.href;
//var adlpage = location.href.indexOf("backup.adl.org")
//if (location.href.substring(location.href.lastIndexOf("/")+1) == "cookie_test2.asp")
alert(document.links[5])
this.location.href = "http://www.excite.com"
//window.open('http://www.yahoo.com');
}

/**************************************************************************************************************/


var odiv = "test"
function fnGetId2(){
   // Returns the DIV element in the collection.
   escape(odiv = document.getElementById("strTitle").innerHTML)
   return odiv
}

//alert(fnGetId2())
//alert(odiv)



function openWindow_for_email(w, h) {
var adl_url = location.href
var adl_title = fnGetId2()
param = "http://cgi.adl.org/cgi-bin/send_form.pl?send_url=" + adl_url + "&amp;send_description=" + adl_title
    var newWindow = window.open(param,'Answer','width='+w+',height='+h+'toolbar=yes, location = yes');
	if(newWindow.top != top) {newWindow.focus(); }
}


///////////////---form scripts

function verifyContents(ask)
{
			
       if (ask.First_Name.value == "") 
	   		{ 
			     alert("Please enter your name");
				   	return false
			}

					
		if (ask.email.value == "") 
	        { 
			     alert("Please enter your e-mail");
				 		return false 
			}
		else if (ADL_checkemail(ask.email.value) == false) 
			{ 
			    alert("Please enter a valid e-mail");
				   	return false
			}
						
  }


  
  function ADL_checkemail(str){
//var str=document.validation.emailcheck.value
var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
if (filter.test(str))
testresults=true
else{
//alert("Please input a valid email address!")
testresults=false
return (testresults)
}
return (testresults)
}

  
  
  
  
  
  
  //the two functions at the bottom are not implemented with this form
function CheckEmail(x)
{
if (x.indexOf("@",0) > 0 )
alert(x + " is a valid email");
else
alert(x + " is not a valid email address");
} 
  
  
  
  
  
  function isEmail(str) {
  // are regular expressions supported?
  var supported = 0;
  if (window.RegExp) {
    var tempStr = "a";
    var tempReg = new RegExp(tempStr);
    if (tempReg.test(tempStr)) supported = 1;
  }
  if (!supported) 
    return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
  var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
  var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
  return (!r1.test(str) && r2.test(str));
}

//***********************************************************************************************************