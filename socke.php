<?php
session_start();
if(!(isset($_SESSION['user'])))
header("location:home.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
.my{
border:1px solid green;
border-radius:5px;
text-align:right;
background:orange;
font-size:18px;
color:blue;
width:75%;
float:right;
}
.me{
border:1px solid purple;
border-radius:5px;
background:lightgreen;
font-size:18px;
color:purple;
width:75%;
text-align:left;
float:left;
}
#p{
width:100%;
height:250px;
border:2px solid blue;
overflow:scroll;
}
div{
border:2px solid green;
width:100%;
height:60px;
}
input,button{
border:1px solid blue;
border-radius:20px;
height:25px;
}
</style>
 <meta charset="utf-8">
 <title></title>
 <meta name="viewport" content="width=device-width">
</head>
<body bgcolor="lightgrey">
<h2 style="color:indigo;">Live Chat  <?php echo($_SESSION['user']); ?></h2>
<p id="m" style="color:red;">Offline</p>
<div id="p"></div>
<button onclick="mmm()">Logout</button>
<input type="text" id="n" name="n" placeholder="Data" required>
<input type="button" value="Send" onclick="m()"/>
<script>
var uri="ws://echo.websocket.org";
function nnn(){

}
function f()
{
var mm=prompt("Enter URL","ws://100.118.59.139:8888");
var name=prompt("Enter Your Name","<?php echo($_SESSION['user']); ?>"); 
var e=document.getElementById('m');
xx=document.getElementById('p');
var u="ws://localhost:8888";
u=mm;
s=new WebSocket(u);
s.onopen=function(d){
e.style.color="green";
e.innerHTML="Online";
s.send(name);
};
s.onmessage=function(mes){
var dat=JSON.parse(mes.data);
xx.innerHTML+=("<br/><div class='my'><small>"+dat.name+"</small><hr/>"+dat.msg+"<br/></div>");
};
s.onclose=function(d){e.style.color="red";e.innerHTML="Offline";};

s.onerror=function(d){
e.innerHTML="Error:"+d;};
}
f();
function m(){
var t=document.getElementById('n').value;
var y={"name":"<?php echo($_SESSION['user']); ?>","msg":t};
y=JSON.stringify(y);
s.send(y);
xx.innerHTML+=("<br/><div class='me'><small>"+"<?php echo($_SESSION['user']); ?>"+"</small><hr/>"+t+"<br/></div>");
t='';
}
function mmm(){
s.close();
window.location.href="logout.php";
}
</script>

</body>
</html>