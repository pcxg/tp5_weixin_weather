<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx3b8926fde68a4907", "00d504c382ba26b9ea4d20e49e1b3b3f");
$signPackage = $jssdk->GetSignPackage();



//http://api.map.baidu.com/geocoder/v2/?callback=renderReverse&location=35.658651,139.745415&output=json&pois=1&ak=1WriolOWerqERs2KNlEVtiBUmGjDFvlx
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!-- meta使用viewport以确保页面可自由缩放 -->
  <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">

  <!-- 引入 jQuery Mobile 样式 -->
  <link rel="stylesheet" href="http://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.css">

  <!-- 引入 jQuery 库 -->
  <script src="http://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>

  <!-- 引入 jQuery Mobile 库 -->
  <script src="http://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  <title></title>
</head>
<body>
    <div data-role="page" style="background:#55AA66">
        <div data-role="header">
        	<h1 id="cityT"></h1>
            <a href="#myPopup" data-rel="popup" class="ui-btn  ui-btn-right ui-icon-bullets ui-btn-icon-notext ui-corner-all" data-transition="pop"></a>
		<div data-role="popup" id="myPopup">
			  <p>设置内容</p>
		</div>
        </div>
        <div data-role="content">
        	<div style="text-align: center;">
        		<h4 id="type"></h4>
			<h2 id="temp">17°C</h2>	
        	</div>
        	<HR style="border:1" color=#000000 SIZE=1  >
            <div class="ui-grid-b">
            	<div class="subtitle">
            		<h4>气候条件</h4>
            	</div>

           		<div class="ui-block-a">
           			<img src="../static/weather_icon/humidity.png">
					<p>湿度</p>
					<p id="shidu">65%</p>
				</div>
				<div class="ui-block-b">
					<img src="../static/weather_icon/pm25.png">
					<p>PM2.5</p>
					<p id="pm25">1000</p>
				</div>
				<div class="ui-block-c">
                  	<img src="../static/weather_icon/cansee.png">
					<p>PM10</p>
					<p id="pm10">10m</p>
				</div>
				
				<HR style="border:1" color=#000000 SIZE=1  >
				<div class="subtitle">
            		<h4>日出/日落</h4>
            	</div>

           		<div class="ui-block-a">
           			<img src="../static/weather_icon/sunrise.png">
					<p>日出</p>
					<p id="sunrise">6:00</p>
			</div>
				<div class="ui-block-b">
					<img src="../static/weather_icon/sun_duration.png">
					<p>日光照射</p>
					<p id="duration">10:00</p>
				</div>
				<div class="ui-block-c">
                  	<img src="../static/weather_icon/sunset.png">
					<p>日落</p>
					<p id="sunset">16:00</p>
				</div>

				<HR style="border:1" color=#000000 SIZE=1  >
				<div class="subtitle">
            		<h4>风力情况</h4>
            	</div>

           		<div class="ui-block-a">
           			<img src="../static/weather_icon/temp.png">
					<p>最低温</p>
					<p id="low_temp">100°C</p>
			</div>
				<div class="ui-block-b">
					<img src="../static/weather_icon/wind_direction.png">
					<p>风向</p>
					<p id="wind_dir">130°</p>
				</div>
				<div class="ui-block-c">
                  	<img src="../static/weather_icon/wind_speed.png">
					<p>风速</p>
					<p id="wind_speed">10km/h</p>
				</div>
				<HR style="border:1" color=#000000 SIZE=1  >
			</div>
           	
        </div>
        <div data-role="footer">
            <h1>页脚</h1>
        </div>
    </div>
</body>

<style>
.ui-block-a, 
.ui-block-b, 
.ui-block-c 
{

height: 150px;
text-align: center;


}
.subtitle{
	text-align: center;
}
</style>


<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
     'getLocation',
    ]
  });
  

  
  //初始化
  wx.ready(function () {
    
    // 在这里调用 API
     wx.getLocation({
            type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
    			$.post("getInfo.php",{lat:latitude,lng:longitude})
                  .done(function(data){
                  	var jdata = JSON.parse(data);
                  	
                  	setData(jdata);//动态赋值
                  });           
            }
        });
    
  });
  
  function setData(data){
  	$("#cityT").html(data.cityInfo.city);
    $("#type").html(data.data.forecast[0].type);
    $("#temp").html(data.data.wendu+"°C");
    
    $("#shidu").html(data.data.shidu);
    $("#pm25").html(data.data.pm25);
    $("#pm10").html(data.data.pm10);
    
    var rise = data.data.forecast[0].sunrise;
    var set = data.data.forecast[0].sunset;
    var r_time = rise.split(":");
    var s_time = set.split(":");
    var dura_hour = parseInt(s_time[1])>parseInt(r_time[1])?parseInt(s_time[0])-parseInt(r_time[0]):parseInt(s_time[0])-parseInt(r_time[0])-1;
    var dura_min = parseInt(s_time[1])>parseInt(r_time[1])?parseInt(s_time[1])-parseInt(r_time[1]):parseInt(s_time[1])-parseInt(r_time[1])+60;
    
    $("#sunrise").html(rise);
    $("#duration").html(dura_hour+":"+dura_min);
    $("#sunset").html(set);
    
   	$("#low_temp").html(data.data.forecast[0].low.substring(3));
    $("#wind_dir").html(data.data.forecast[0].fx);
    $("#wind_speed").html(data.data.forecast[0].fl);
  }
  
  
  
</script>
</html>


