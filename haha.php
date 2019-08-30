<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>YA!!</title>
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMsXLhZlzF-R_JA4uWOIm8WxzDf_9RlJs&sensor=true">
	  </script>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry"></script>

</head>

<script type="text/javascript">
/*if(navigator.geolocation){
    alert("支援呦 :)");
}else{
    alert("瀏覽器不支援 geolocation API... 哭哭");
}*/

function init() { 
if (navigator.geolocation) { 
//獲取當前目前地理位置 
navigator.geolocation.getCurrentPosition(function (position) { 
var coords = position.coords; 
//console.log(position); 
//指定一個google地圖上的坐標點，同時指定該座標點的�坐標和縱座標
var latlng = new google.maps.LatLng(coords.latitude, coords.longitude); 
var myOptions = { 
zoom: 14, //設定放大倍數 
center: latlng, //將地圖中心點設定為指定的座標點 
mapTypeId: google.maps.MapTypeId.ROADMAP //指定地圖類型 
}; 


//創建地圖，並在頁面map中顯示 
var map = new google.maps.Map(document.getElementById("map"), myOptions); 
//在地圖上創建標記

var marker = new google.maps.Marker({ 
position: latlng, //將前面設定的座標標註出來
title: "your location!" ,
map: map //將該標註設置在剛才創建的map中
}); 
//標註提示窗口


/*var infoWindow = new google.maps.InfoWindow({
content: "目前位置：<br/>經度：" + latlng.lat() + "<br/>緯度：" + latlng.lng() //提示視窗�X的提示資訊 
});*/


// Creates a marker whose info window displays the given number
function createMarker(point, number)
{
var marker = new google.maps.Marker(point);
// Show this markers index in the info window when it is clicked
var html = number;
GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
return marker;
};

<?php
$link = mysql_connect("localhost", "root", "sai780701") or die("Could not connect: " . mysql_error());
mysql_selectdb("sai",$link) or die ("Can\'t use dbmapserver : " . mysql_error());

mysql_query("SET NAMES 'utf8'", $link);
$result = mysql_query("SELECT * FROM wholocations",$link);
if (!$result)
{
echo "no results ";
}
while($row = mysql_fetch_array($result))
{
echo "var point = new google.maps.LatLng(" . $row['lat'] . "," . $row['lon'] . ");\n";
echo "var marker0 = createMarker(point, '" . addslashes($row['description']) . "');\n";
echo "map.addOverlay(marker);\n";
echo "\n";
}

mysql_close($link);
?>

//打開提示窗口 
infoWindow.open(map, marker); 
}, 
function (error) { 
//處理錯誤 
switch (error.code) { 
case 1: 
alert("服務被拒絕=ˇ=。"); 
break; 
case 2: 
alert("獲取不到位置資訊@@。"); 
break; 
case 3: 
alert("獲取資訊超時= =。"); 
break; 
default: 
alert("未知的錯誤><。"); 
break; 
} 
}); 
} else { 
alert("您的瀏覽器不支援HTML5來獲取地理位置資訊。"); 
} 
} 


</script> 

</head> 
<body onload="init()">
<p><strong>Who-locations in London</strong></p>
<div id="map" style="width: 800px; height: 600px"></div>
<div id="msg"></div> 
</body> 
</html> 