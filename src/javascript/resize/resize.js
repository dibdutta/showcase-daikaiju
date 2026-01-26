/*
 * SOTC Resizeable Textbox Version 1
 * https://www.switchonthecode.com/tutorials/javascript-tutorial-resizeable-textboxes
 */
/*
 * SOTC Resizeable Textbox Version 1
 * https://www.switchonthecode.com/tutorials/javascript-tutorial-resizeable-textboxes
 */
var xmlHttp;
function  fetchimage(image)
{

xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
var url="fetchimg.php";
url=url+"?imgurl="+image;
//url=url+"&sid="+Math.random();
//alert(url);
xmlHttp.onreadystatechange=stateChanged2;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged2()
{
if (xmlHttp.readyState==4 && xmlHttp.status==200)
{
var subcat_arr=xmlHttp.responseText;
//document.getElementById("onlinephotos").innerHTML=subcat_arr;
var cnt=document.getElementById("cnt").value;
var ind=subcat_arr.indexOf("text/javascript");
if(ind==-1){
if(Number(cnt) >=1)
{
var radList = document.getElementsByName('is_default');
for (var i = 0; i < radList.length; i++) {
if(radList[i].checked) radList[i].checked = false;
}	 
}
cnt=Number(cnt)+1;
document.getElementById("cnt").value=cnt;

if(cnt==12)
{
$("#browse").hide();
$("#path").hide();
}
}
$("#photos").append(subcat_arr);
document.getElementById("imgurl").value="";
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

var xmlHttp;
function  fetchimageedit(image)
{
xmlHttp=GetXmlHttpObject2();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
var url="fetchimg.php";
url=url+"?imgurl="+image+"&mode=edit";
//url=url+"&sid="+Math.random();
//alert(url);
xmlHttp.onreadystatechange=stateChanged3;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged3()
{
if (xmlHttp.readyState==4 && xmlHttp.status==200)
{
	
var subcat_arr=xmlHttp.responseText;
//document.getElementById("onlinephotos").innerHTML=subcat_arr;
var ind=subcat_arr.indexOf("text/javascript");
if(ind==-1){
var cnt=document.getElementById("cnt").value;
cnt=Number(cnt)+1;
document.getElementById("cnt").value=cnt;
if(cnt==12)
{
$("#browse").hide();
$("#path").hide();
}
}
$("#new_photos").append(subcat_arr);
document.getElementById("imgurl").value="";
}
}

function GetXmlHttpObject2()
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

function Position(x, y)
{
  this.X = x;
  this.Y = y;
  
  this.Add = function(val)
  {
    var newPos = new Position(this.X, this.Y);
    if(val != null)
    {
      if(!isNaN(val.X))
        newPos.X += val.X;
      if(!isNaN(val.Y))
        newPos.Y += val.Y
    }
    return newPos;
  }
  
  this.Subtract = function(val)
  {
    var newPos = new Position(this.X, this.Y);
    if(val != null)
    {
      if(!isNaN(val.X))
        newPos.X -= val.X;
      if(!isNaN(val.Y))
        newPos.Y -= val.Y
    }
    return newPos;
  }
  
  this.Min = function(val)
  {
    var newPos = new Position(this.X, this.Y)
    if(val == null)
      return newPos;
    
    if(!isNaN(val.X) && this.X > val.X)
      newPos.X = val.X;
    if(!isNaN(val.Y) && this.Y > val.Y)
      newPos.Y = val.Y;
    
    return newPos;  
  }
  
  this.Max = function(val)
  {
    var newPos = new Position(this.X, this.Y)
    if(val == null)
      return newPos;
    
    if(!isNaN(val.X) && this.X < val.X)
      newPos.X = val.X;
    if(!isNaN(val.Y) && this.Y < val.Y)
      newPos.Y = val.Y;
    
    return newPos;  
  }  
  
  this.Bound = function(lower, upper)
  {
    var newPos = this.Max(lower);
    return newPos.Min(upper);
  }
  
  this.Check = function()
  {
    var newPos = new Position(this.X, this.Y);
    if(isNaN(newPos.X))
      newPos.X = 0;
    if(isNaN(newPos.Y))
      newPos.Y = 0;
    return newPos;
  }
  
  this.Apply = function(element)
  {
    if(typeof(element) == "string")
      element = document.getElementById(element);
    if(element == null)
      return;
    if(!isNaN(this.X))
      element.style.left = this.X + 'px';
    if(!isNaN(this.Y))
      element.style.top = this.Y + 'px';  
  }
}

function hookEvent(element, eventName, callback)
{
  if(typeof(element) == "string")
    element = document.getElementById(element);
  if(element == null)
    return;
  if(element.addEventListener)
  {
    element.addEventListener(eventName, callback, false);
  }
  else if(element.attachEvent)
    element.attachEvent("on" + eventName, callback);
}

function unhookEvent(element, eventName, callback)
{
  if(typeof(element) == "string")
    element = document.getElementById(element);
  if(element == null)
    return;
  if(element.removeEventListener)
    element.removeEventListener(eventName, callback, false);
  else if(element.detachEvent)
    element.detachEvent("on" + eventName, callback);
}

function cancelEvent(e)
{
  e = e ? e : window.event;
  if(e.stopPropagation)
    e.stopPropagation();
  if(e.preventDefault)
    e.preventDefault();
  e.cancelBubble = true;
  e.cancel = true;
  e.returnValue = false;
  return false;
}

function getMousePos(eventObj)
{
  eventObj = eventObj ? eventObj : window.event;
  var pos;
  if(isNaN(eventObj.layerX))
    pos = new Position(eventObj.offsetX, eventObj.offsetY);
  else
    pos = new Position(eventObj.layerX, eventObj.layerY);
  return correctOffset(pos, pointerOffset, true);
}

function getEventTarget(e)
{
  e = e ? e : window.event;
  return e.target ? e.target : e.srcElement;
}

function absoluteCursorPostion(eventObj)
{
  eventObj = eventObj ? eventObj : window.event;
  
  if(isNaN(window.scrollX))
    return new Position(eventObj.clientX + document.documentElement.scrollLeft + document.body.scrollLeft, 
      eventObj.clientY + document.documentElement.scrollTop + document.body.scrollTop);
  else
    return new Position(eventObj.clientX + window.scrollX, eventObj.clientY + window.scrollY);
}

function dragObject(element, attachElement, lowerBound, upperBound, startCallback, moveCallback, endCallback, attachLater)
{
  if(typeof(element) == "string")
    element = document.getElementById(element);
  if(element == null)
      return;
  
  if(lowerBound != null && upperBound != null)
  {
    var temp = lowerBound.Min(upperBound);
    upperBound = lowerBound.Max(upperBound);
    lowerBound = temp;
  }

  var cursorStartPos = null;
  var elementStartPos = null;
  var dragging = false;
  var listening = false;
  var disposed = false;
  
  function dragStart(eventObj)
  { 
    if(dragging || !listening || disposed) return;
    dragging = true;
    
    if(startCallback != null)
      startCallback(eventObj, element);
    
    cursorStartPos = absoluteCursorPostion(eventObj);
    
    elementStartPos = new Position(parseInt(element.style.left), parseInt(element.style.top));
   
    elementStartPos = elementStartPos.Check();
    
    hookEvent(document, "mousemove", dragGo);
    hookEvent(document, "mouseup", dragStopHook);
    
    return cancelEvent(eventObj);
  }
  
  function dragGo(eventObj)
  {
    if(!dragging || disposed) return;
    
    var newPos = absoluteCursorPostion(eventObj);
    newPos = newPos.Add(elementStartPos).Subtract(cursorStartPos);
    newPos = newPos.Bound(lowerBound, upperBound)
    newPos.Apply(element);
    if(moveCallback != null)
      moveCallback(newPos, element);
        
    return cancelEvent(eventObj); 
  }
  
  function dragStopHook(eventObj)
  {
    dragStop();
    return cancelEvent(eventObj);
  }
  
  function dragStop()
  {
    if(!dragging || disposed) return;
    unhookEvent(document, "mousemove", dragGo);
    unhookEvent(document, "mouseup", dragStopHook);
    cursorStartPos = null;
    elementStartPos = null;
    if(endCallback != null)
      endCallback(element);
    dragging = false;
  }
  
  this.Dispose = function()
  {
    if(disposed) return;
    this.StopListening(true);
    element = null;
    attachElement = null
    lowerBound = null;
    upperBound = null;
    startCallback = null;
    moveCallback = null
    endCallback = null;
    disposed = true;
  }
  
  this.StartListening = function()
  {
    if(listening || disposed) return;
    listening = true;
    hookEvent(attachElement, "mousedown", dragStart);
  }
  
  this.StopListening = function(stopCurrentDragging)
  {
    if(!listening || disposed) return;
    unhookEvent(attachElement, "mousedown", dragStart);
    listening = false;
    
    if(stopCurrentDragging && dragging)
      dragStop();
  }
  
  this.IsDragging = function(){ return dragging; }
  this.IsListening = function() { return listening; }
  this.IsDisposed = function() { return disposed; }
  
  if(typeof(attachElement) == "string")
    attachElement = document.getElementById(attachElement);
  if(attachElement == null)
    attachElement = element;
    
  if(!attachLater)
    this.StartListening();
}

function BottomMove(newPos, element)
{
  DoHeight(newPos.Y, element);
}

function RightMove(newPos, element)
{
  DoWidth(newPos.X, element);
}

function CornerMove(newPos, element)
{
  DoHeight(newPos.Y, element);
  DoWidth(newPos.X, element);
}

function BottomMove1(newPos, element)
{
  DoHeight1(newPos.Y, element);
}

function RightMove1(newPos, element)
{
  DoWidth1(newPos.X, element);
}

function CornerMove1(newPos, element)
{
  DoHeight1(newPos.Y, element);
  DoWidth1(newPos.X, element);
}

function DoHeight(y, element)
{
  textDiv.style.height = (y ) + 'px';

  if(element != handleCorner)
    handleCorner.style.top = y + 'px';

  handleRight.style.height = y + 'px';

  if(element != handleBottom)
    handleBottom.style.top = y + 'px';
  
  textBox.style.height = (y ) + 'px';
}

function DoWidth(x, element)
{
  textDiv.style.width =  (x ) + 'px';

  if(element != handleCorner)
    handleCorner.style.left = x + 'px';

  if(element != handleRight)
    handleRight.style.left = x + 'px';

  handleBottom.style.width = x + 'px';

  textBox.style.width = (x ) + 'px';
}
function DoHeight1(y, element)
{
  textDiv1.style.height = (y ) + 'px';

  if(element != handleCorner1)
    handleCorner1.style.top = y + 'px';

  handleRight.style.height = y + 'px';

  if(element != handleBottom1)
    handleBottom1.style.top = y + 'px';
  
  textBox1.style.height = (y ) + 'px';
}

function DoWidth1(x, element)
{
  textDiv1.style.width =  (x ) + 'px';

  if(element != handleCorner1)
    handleCorner.style.left = x + 'px';

  if(element != handleRight1)
    handleRight.style.left = x + 'px';

  handleBottom.style.width = x + 'px';

  textBox1.style.width = (x ) + 'px';
}

var textBox = document.getElementById("textBox");
var handleRight = document.getElementById("handleRight");
var handleCorner = document.getElementById("handleCorner");
var handleBottom = document.getElementById("handleBottom");
var textDiv = document.getElementById("textDiv");

var textBox1 = document.getElementById("textBox1");
var handleRight1 = document.getElementById("handleRight1");
var handleCorner1 = document.getElementById("handleCorner1");
var handleBottom1 = document.getElementById("handleBottom1");
var textDiv1 = document.getElementById("textDiv1");

new dragObject(handleRight, null, new Position(15, 0), new Position(620, 0), null, RightMove, null, false);
new dragObject(handleBottom, null, new Position(0, 5), new Position(0, 400), null, BottomMove, null, false);
new dragObject(handleCorner, null, new Position(15, 15), new Position(620, 400), null, CornerMove, null, false);

new dragObject(handleRight1, null, new Position(15, 0), new Position(620, 0), null, RightMove1, null, false);
new dragObject(handleBottom1, null, new Position(0, 15), new Position(0, 400), null, BottomMove1, null, false);
new dragObject(handleCorner1, null, new Position(15, 15), new Position(620, 400), null, CornerMove1, null, false);
