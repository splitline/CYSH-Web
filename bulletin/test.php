<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
<html>
<head>
<script type="text/javascript">
$(document).ready(function(){
	$.ajax({
		url: "../api/?format=json&view=list",
		type: "GET",
		dataType: "json",
		success: function(data) {
			//alert("SUCCESS!!!");
			//我們可以透過.length得知其中的物件數
			var NumOfJData = data.length; //NumOfJData=3

			//利用alert來逐筆將資料以message window的方式傳出
			for (var i = 0; i < NumOfJData; i++) {
			  console.log(data[i]["title"]);   //i=0→Wing; i=1→Wind; i=2→Edge
			  console.log(data[i]["date"]);    //i=0→20;   i=1→18;   i=2→25
			}
			var i = 0;
			//這裡改用.each這個函式來取出JData裡的物件
			$.each(data, function() {
			  $("#JSON_table").append("<tr>" +
			                          "<td>" + data[i].title   + "</td>" +
			                          "<td>" + data[i].date    + "</td>" +
			                          "</tr>");
			  i++;
			});
		},
	  
		error: function() {
			alert("ERROR!!!");
		}
	});
});
</script>
</head>

<body>


<table id="JSON_table"></p>

</body>
</html>
